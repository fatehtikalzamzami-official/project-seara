<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CartItem;
use App\Models\Harvest;
use App\Models\PriceOffer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // ── Daftar pesanan buyer ───────────────────────────────────────────────
    public function index(Request $request)
    {
        $status = $request->query('status');

        $query = Order::where('buyer_id', Auth::id())
            ->with('items')
            ->latest();

        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        $orders = $query->paginate(10);

        $countByStatus = Order::where('buyer_id', Auth::id())
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $allCount = array_sum($countByStatus);

        return view('pembeli.orders', compact('orders', 'countByStatus', 'allCount'));
    }

    // ── Checkout dari keranjang ────────────────────────────────────────────
    public function checkoutFromCart(Request $request)
    {
        $items = CartItem::where('user_id', Auth::id())
            ->with(['harvest.product', 'harvest.seller'])
            ->get();

        if ($items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kamu kosong.');
        }

        $subtotal     = $items->sum(fn($i) => $i->quantity * $i->harvest->price_per_unit);
        $shippingCost = 15000;
        $total        = $subtotal + $shippingCost;
        $source       = 'cart';
        $offer        = null;
        $harvest      = null;
        $cartItemIds  = $items->pluck('id')->toArray();

        return view('pembeli.checkout', compact('items', 'subtotal', 'source', 'offer', 'harvest', 'cartItemIds', 'shippingCost', 'total'));
    }

    // ── Checkout dari penawaran harga ──────────────────────────────────────
    public function checkoutFromOffer(Request $request, PriceOffer $priceOffer)
    {
        if ($priceOffer->buyer_id !== Auth::id()) {
            abort(403);
        }

        if (! $priceOffer->isAccepted()) {
            return redirect()->back()->with('error', 'Penawaran ini belum diterima penjual.');
        }

        $harvest      = $priceOffer->harvest()->with('product', 'seller')->firstOrFail();
        $finalPrice   = $priceOffer->counter_price ?? $priceOffer->offer_price;
        $subtotal     = $finalPrice * $priceOffer->quantity;
        $shippingCost = 15000;
        $total        = $subtotal + $shippingCost;
        $items        = collect();
        $source       = 'offer';
        $offer        = $priceOffer;
        $cartItemIds  = [];

        return view('pembeli.checkout', compact('items', 'subtotal', 'source', 'offer', 'harvest', 'finalPrice', 'shippingCost', 'total', 'cartItemIds'));
    }

    // ── Simpan pesanan baru ────────────────────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'recipient_name'   => 'required|string|max:100',
            'recipient_phone'  => 'required|string|max:20',
            'shipping_address' => 'required|string|max:500',
            'province'         => 'required|string|max:100',
            'city'             => 'required|string|max:100',
            'postal_code'      => 'required|string|max:10',
            'payment_method'   => 'required|in:transfer,e-wallet,cod',
            'source'           => 'required|in:cart,offer',
        ]);

        DB::beginTransaction();

        try {
            $subtotal       = 0;
            $shippingCost   = 15000;
            $discountAmount = 0;
            $orderItems     = [];

            if ($request->source === 'cart') {
                $cartItems = CartItem::where('user_id', Auth::id())
                    ->with(['harvest.product', 'harvest.seller.user'])
                    ->get();

                if ($cartItems->isEmpty()) {
                    return redirect()->route('cart.index')->with('error', 'Keranjang kosong.');
                }

                foreach ($cartItems as $ci) {
                    $h        = $ci->harvest;
                    $itemSub  = $ci->quantity * $h->price_per_unit;
                    $subtotal += $itemSub;

                    $orderItems[] = [
                        'harvest_id'     => $h->id,
                        'product_name'   => $h->product->name,
                        'product_unit'   => $h->product->unit,
                        'seller_name'    => $h->seller->farm_name ?? ($h->seller->user->name ?? 'Petani'),
                        'seller_user_id' => $h->seller->user_id,
                        'quantity'       => $ci->quantity,
                        'price_per_unit' => $h->price_per_unit,
                        'subtotal'       => $itemSub,
                        'is_offer_price' => false,
                    ];

                    $h->decrement('remaining_stock', $ci->quantity);
                }

                CartItem::where('user_id', Auth::id())->delete();

            } else {
                $priceOffer = PriceOffer::findOrFail($request->price_offer_id);

                if ($priceOffer->buyer_id !== Auth::id() || ! $priceOffer->isAccepted()) {
                    abort(403);
                }

                $h          = $priceOffer->harvest()->with('product', 'seller.user')->firstOrFail();
                $finalPrice = $priceOffer->counter_price ?? $priceOffer->offer_price;
                $itemSub    = $finalPrice * $priceOffer->quantity;
                $subtotal   = $itemSub;

                $discountAmount = max(0, ($h->price_per_unit - $finalPrice) * $priceOffer->quantity);

                $orderItems[] = [
                    'harvest_id'     => $h->id,
                    'product_name'   => $h->product->name,
                    'product_unit'   => $h->product->unit,
                    'seller_name'    => $h->seller->farm_name ?? ($h->seller->user->name ?? 'Petani'),
                    'seller_user_id' => $h->seller->user_id,
                    'quantity'       => $priceOffer->quantity,
                    'price_per_unit' => $finalPrice,
                    'subtotal'       => $itemSub,
                    'price_offer_id' => $priceOffer->id,
                    'is_offer_price' => true,
                ];

                $h->decrement('remaining_stock', $priceOffer->quantity);
                $priceOffer->update(['status' => 'completed']);
            }

            $totalAmount = $subtotal + $shippingCost - $discountAmount;

            $order = Order::create([
                'order_number'     => Order::generateOrderNumber(),
                'buyer_id'         => Auth::id(),
                'recipient_name'   => $request->recipient_name,
                'recipient_phone'  => $request->recipient_phone,
                'shipping_address' => $request->shipping_address,
                'province'         => $request->province,
                'city'             => $request->city,
                'postal_code'      => $request->postal_code,
                'subtotal'         => $subtotal,
                'shipping_cost'    => $shippingCost,
                'discount_amount'  => $discountAmount,
                'total_amount'     => $totalAmount,
                'status'           => 'pending_payment',
                'payment_method'   => $request->payment_method,
                'buyer_notes'      => $request->buyer_notes,
            ]);

            foreach ($orderItems as $item) {
                $order->items()->create($item);
            }

            DB::commit();

            return redirect()->route('orders.show', $order)
                ->with('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran.');

        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal membuat pesanan: ' . $e->getMessage());
        }
    }

    // ── Detail pesanan ────────────────────────────────────────────────────
    public function show(Order $order)
    {
        if ($order->buyer_id !== Auth::id()) {
            abort(403);
        }

        $order->load('items');

        return view('pembeli.order-detail', compact('order'));
    }

    // ── Upload bukti pembayaran ────────────────────────────────────────────
    public function uploadPaymentProof(Request $request, Order $order)
    {
        if ($order->buyer_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'payment_proof' => 'required|image|max:4096',
        ]);

        $path = $request->file('payment_proof')->store('payment-proofs', 'public');

        $order->update([
            'payment_proof' => $path,
            'status'        => 'paid',
            'paid_at'       => now(),
        ]);

        return redirect()->route('orders.show', $order)
            ->with('success', 'Bukti pembayaran berhasil diupload.');
    }

    // ── Batalkan pesanan ──────────────────────────────────────────────────
    public function cancel(Request $request, Order $order)
    {
        if ($order->buyer_id !== Auth::id()) {
            abort(403);
        }

        if (! in_array($order->status, ['pending_payment', 'paid'])) {
            return redirect()->back()->with('error', 'Pesanan ini tidak dapat dibatalkan.');
        }

        foreach ($order->items as $item) {
            if ($item->harvest_id) {
                Harvest::where('id', $item->harvest_id)
                    ->increment('remaining_stock', $item->quantity);
            }
        }

        $order->update([
            'status'        => 'cancelled',
            'cancel_reason' => $request->cancel_reason ?? 'Dibatalkan oleh pembeli',
        ]);

        return redirect()->route('orders.index')
            ->with('success', 'Pesanan berhasil dibatalkan.');
    }
}