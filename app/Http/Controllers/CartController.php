<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Harvest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // ── Tampilkan halaman keranjang ──────────────────────────────────────
    public function index()
    {
        $items = CartItem::with([
                'harvest.product.category',
                'harvest.seller',   // SellerProfile
            ])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        // Kelompokkan per seller untuk ringkasan pengiriman
        $grouped = $items->groupBy(fn($item) => $item->harvest->seller_id);

        $subtotal   = $items->sum('subtotal');
        $ongkir     = $subtotal >= 50000 ? 0 : 15000;
        $total      = $subtotal + $ongkir;

        return view('pembeli.keranjang', compact('items', 'grouped', 'subtotal', 'ongkir', 'total'));
    }

    // ── Tambah / update item ─────────────────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'harvest_id' => 'required|exists:harvests,id',
            'quantity'   => 'required|integer|min:1|max:999',
        ]);

        $harvest = Harvest::findOrFail($request->harvest_id);

        if ($request->quantity > $harvest->remaining_stock) {
            return back()->with('error', 'Stok tidak mencukupi.');
        }

        CartItem::updateOrCreate(
            [
                'user_id'    => Auth::id(),
                'harvest_id' => $request->harvest_id,
            ],
            [
                'quantity' => \DB::raw("quantity + {$request->quantity}"),
            ]
        );

        // Pastikan qty tidak melebihi stok
        CartItem::where('user_id', Auth::id())
            ->where('harvest_id', $request->harvest_id)
            ->update([
                'quantity' => \DB::raw("LEAST(quantity, {$harvest->remaining_stock})"),
            ]);

        if ($request->wantsJson()) {
            $count = CartItem::where('user_id', Auth::id())->sum('quantity');
            return response()->json(['success' => true, 'cart_count' => $count]);
        }

        return back()->with('success', 'Produk ditambahkan ke keranjang.');
    }

    // ── Update quantity lewat AJAX ───────────────────────────────────────
    public function update(Request $request, CartItem $cartItem)
    {
        $this->authorize('update', $cartItem);

        $request->validate(['quantity' => 'required|integer|min:1|max:999']);

        $harvest = $cartItem->harvest;
        $qty     = min($request->quantity, $harvest->remaining_stock);

        $cartItem->update(['quantity' => $qty]);

        return response()->json([
            'success'  => true,
            'quantity' => $qty,
            'subtotal' => $cartItem->subtotal,
        ]);
    }

    // ── Hapus item ───────────────────────────────────────────────────────
    public function destroy(CartItem $cartItem)
    {
        $this->authorize('delete', $cartItem);
        $cartItem->delete();

        if (request()->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Item dihapus dari keranjang.');
    }

    // ── Hapus semua item ─────────────────────────────────────────────────
    public function clear()
    {
        CartItem::where('user_id', Auth::id())->delete();
        return back()->with('success', 'Keranjang dikosongkan.');
    }

    // ── Jumlah item (untuk badge topbar) ─────────────────────────────────
    public function count()
    {
        $count = CartItem::where('user_id', Auth::id())->sum('quantity');
        return response()->json(['count' => $count]);
    }
}
