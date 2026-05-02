<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Harvest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PriceOffer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // ── Halaman checkout dari keranjang ───────────────────────────────────
    public function checkoutFromCart(Request $request)
    {
        // Ambil item yang dipilih (bisa semua atau selected)
        $selectedIds = $request->query('items'); // array harvest_id atau null = semua

        $query = CartItem::with(['harvest.product.category', 'harvest.seller.user'])
            ->where('user_id', Auth::id());

        if ($selectedIds) {
            $query->whereIn('id', (array) $selectedIds);
        }

        $items = $query->latest()->get();

        if ($items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong atau item tidak ditemukan.');
        }

        $subtotal     = $items->sum('subtotal');
        $shippingCost = $subtotal >= 50000 ? 0 : 15000;
        $total        = $subtotal + $shippingCost;

        return view('pembeli.checkout', [
            'source'       => 'cart',
            'items'        => $items,
            'cartItemIds'  => $items->pluck('id')->toArray(),
            'subtotal'     => $subtotal,
            'shippingCost' => $shippingCost,
            'total'        => $total,
            'offer'        => null,
        ]);
    }

    // ── Halaman checkout dari price offer yang diterima ───────────────────
    public function checkoutFromOffer(PriceOffer $priceOffer)
    {
        // Hanya buyer yang bersangkutan
        abort_unless($priceOffer->buyer_id === Auth::id(), 403);
        abort_unless($priceOffer->isAccepted(), 422, 'Tawaran belum/tidak diterima.');

        $harvest = $priceOffer->harvest()->with(['product.category', 'seller.user'])->first();

        // Harga final: counter_price jika ada, else offer_price
        $finalPrice   = $priceOffer->counter_price ?? $priceOffer->offer_price;
        $subtotal     = $finalPrice * $priceOffer->quantity;
        $shippingCost = $subtotal >= 50000 ? 0 : 15000;
        $total        = $subtotal + $shippingCost;

        return view('pembeli.checkout', [
            'source'       => 'offer',
            'items'        => collect([]),  // kosong, gunakan offer
            'cartItemIds'  => [],
            'subtotal'     => $subtotal,
            'shippingCost' => $shippingCost,
            'total'        => $total,
            'offer'        => $priceOffer,
            'harvest'      => $harvest,
            'finalPrice'   => $finalPrice,
        ]);
    }

    // ── Proses order (submit dari form checkout) ──────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'source'           => 'required|in:cart,offer',
            'recipient_name'   => 'required|string|max:100',
            'recipient_phone'  => 'required|string|max:20',
            'shipping_address' => 'required|string|max:500',
            'province'         => 'nullable|string|max:100',
            'city'             => 'nullable|string|max:100',
            'postal_code'      => 'nullable|string|max:10',
            'payment_method'   => 'required|in:transfer,cod,e-wallet',
            'buyer_notes'      => 'nullable|string|max:500',
        ]);

        if ($request->source === 'cart') {
            return $this->processCartOrder($request);
        }

        return $this->processOfferOrder($request);
    }

    // ── Proses order dari keranjang ───────────────────────────────────────
    private function processCartOrder(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'cart_item_ids'   => 'required|array|min:1',
            'cart_item_ids.*' => 'exists:cart_items,id',
        ]);

        $cartItems = CartItem::with(['harvest.product', 'harvest.seller.user'])
            ->whereIn('id', $request->cart_item_ids)
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Item keranjang tidak ditemukan.');
        }

        // Validasi stok
        foreach ($cartItems as $item) {
            if ($item->quantity > $item->harvest->remaining_stock) {
                return back()->with('error', "Stok {$item->harvest->product->name} tidak mencukupi.");
            }
        }

        $subtotal     = $cartItems->sum('subtotal');
        $shippingCost = $subtotal >= 50000 ? 0 : 15000;
        $total        = $subtotal + $shippingCost;

        $order = DB::transaction(function () use ($request, $cartItems, $subtotal, $shippingCost, $total) {
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
                'discount_amount'  => 0,
                'total_amount'     => $total,
                'payment_method'   => $request->payment_method,
                'buyer_notes'      => $request->buyer_notes,
                'status'           => 'pending_payment',
            ]);

            foreach ($cartItems as $item) {
                $harvest  = $item->harvest;
                $seller   = $harvest->seller;

                OrderItem::create([
                    'order_id'       => $order->id,
                    'harvest_id'     => $harvest->id,
                    'product_name'   => $harvest->product->name,
                    'product_unit'   => $harvest->product->unit,
                    'seller_name'    => $seller->farm_name ?? $seller->user->name,
                    'seller_user_id' => $seller->user_id,
                    'quantity'       => $item->quantity,
                    'price_per_unit' => $harvest->price_per_unit,
                    'subtotal'       => $item->subtotal,
                    'is_offer_price' => false,
                ]);

                // Kurangi stok
                $harvest->decrement('remaining_stock', $item->quantity);
            }

            // Hapus dari keranjang
            CartItem::whereIn('id', $cartItems->pluck('id'))->delete();

            return $order;
        });

        return redirect()->route('orders.show', $order)
            ->with('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran.');
    }

    // ── Proses order dari offer ───────────────────────────────────────────
    private function processOfferOrder(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'price_offer_id' => 'required|exists:price_offers,id',
        ]);

        $offer = PriceOffer::with(['harvest.product', 'harvest.seller.user'])->findOrFail($request->price_offer_id);

        abort_unless($offer->buyer_id === Auth::id(), 403);
        abort_unless($offer->isAccepted(), 422, 'Tawaran sudah tidak valid.');

        $harvest    = $offer->harvest;
        $finalPrice = $offer->counter_price ?? $offer->offer_price;

        if ($offer->quantity > $harvest->remaining_stock) {
            return back()->with('error', "Stok {$harvest->product->name} tidak mencukupi.");
        }

        $subtotal     = $finalPrice * $offer->quantity;
        $shippingCost = $subtotal >= 50000 ? 0 : 15000;
        $total        = $subtotal + $shippingCost;

        $order = DB::transaction(function () use ($request, $offer, $harvest, $finalPrice, $subtotal, $shippingCost, $total) {
            $seller = $harvest->seller;

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
                'discount_amount'  => ($offer->original_price - $finalPrice) * $offer->quantity,
                'total_amount'     => $total,
                'payment_method'   => $request->payment_method,
                'buyer_notes'      => $request->buyer_notes,
                'status'           => 'pending_payment',
            ]);

            OrderItem::create([
                'order_id'        => $order->id,
                'harvest_id'      => $harvest->id,
                'product_name'    => $harvest->product->name,
                'product_unit'    => $harvest->product->unit,
                'seller_name'     => $seller->farm_name ?? $seller->user->name,
                'seller_user_id'  => $seller->user_id,
                'quantity'        => $offer->quantity,
                'price_per_unit'  => $finalPrice,
                'subtotal'        => $subtotal,
                'price_offer_id'  => $offer->id,
                'is_offer_price'  => true,
            ]);

            // Kurangi stok
            $harvest->decrement('remaining_stock', $offer->quantity);

            // Update status offer → selesai dipakai
            $offer->update(['status' => 'completed']);

            return $order;
        });

        return redirect()->route('orders.show', $order)
            ->with('success', 'Pesanan berhasil dibuat dari penawaran harga!');
    }

    // ── Detail pesanan ─────────────────────────────────────────────────────
    public function show(Order $order)
    {
        abort_unless($order->buyer_id === Auth::id(), 403);

        $order->load(['items.harvest.product', 'items.harvest.seller']);

        return view('pembeli.order-detail', compact('order'));
    }

    // ── Daftar pesanan buyer ───────────────────────────────────────────────
    public function index()
    {
        $orders = Order::where('buyer_id', Auth::id())
            ->with('items')
            ->latest()
            ->paginate(10);

        return view('pembeli.orders', compact('orders'));
    }

    // ── Upload bukti bayar ─────────────────────────────────────────────────
    public function uploadPaymentProof(Request $request, Order $order)
    {
        abort_unless($order->buyer_id === Auth::id(), 403);
        abort_unless($order->isPendingPayment(), 422, 'Status order tidak valid.');

        $request->validate([
            'payment_proof' => 'required|image|max:5120', // 5MB
        ]);

        $path = $request->file('payment_proof')->store('payment-proofs', 'public');

        $order->update([
            'payment_proof' => $path,
            'status'        => 'paid',
            'paid_at'       => now(),
        ]);

        return back()->with('success', 'Bukti pembayaran berhasil diunggah. Pesanan sedang diproses.');
    }

    // ── Batalkan order ─────────────────────────────────────────────────────
    public function cancel(Request $request, Order $order)
    {
        abort_unless($order->buyer_id === Auth::id(), 403);
        abort_unless(in_array($order->status, ['pending_payment', 'paid']), 422, 'Order tidak bisa dibatalkan.');

        $request->validate(['cancel_reason' => 'nullable|string|max:300']);

        DB::transaction(function () use ($request, $order) {
            // Kembalikan stok
            foreach ($order->items as $item) {
                $item->harvest->increment('remaining_stock', $item->quantity);
            }

            $order->update([
                'status'        => 'cancelled',
                'cancel_reason' => $request->cancel_reason,
            ]);
        });

        return back()->with('success', 'Pesanan berhasil dibatalkan.');
    }
}
