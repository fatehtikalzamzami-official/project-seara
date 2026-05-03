<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Harvest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    // ── Tampilkan halaman wishlist ───────────────────────────────────────
    public function index()
    {
        $items = Wishlist::with([
                'harvest.product.category',
                'harvest.seller.user',
            ])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('pembeli.wishlist', compact('items'));
    }

    // ── Toggle wishlist (tambah / hapus) via AJAX ───────────────────────
    public function toggle(Request $request)
    {
        $request->validate([
            'harvest_id' => 'required|exists:harvests,id',
        ]);

        $existing = Wishlist::where('user_id', Auth::id())
                            ->where('harvest_id', $request->harvest_id)
                            ->first();

        if ($existing) {
            $existing->delete();
            $wishlisted = false;
        } else {
            Wishlist::create([
                'user_id'    => Auth::id(),
                'harvest_id' => $request->harvest_id,
            ]);
            $wishlisted = true;
        }

        $count = Wishlist::where('user_id', Auth::id())->count();

        return response()->json([
            'success'    => true,
            'wishlisted' => $wishlisted,
            'count'      => $count,
        ]);
    }

    // ── Hapus satu item dari wishlist ────────────────────────────────────
    public function destroy(Wishlist $wishlist)
    {
        abort_if($wishlist->user_id !== Auth::id(), 403);
        $wishlist->delete();

        if (request()->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Item dihapus dari wishlist.');
    }

    // ── Jumlah wishlist (untuk badge) ────────────────────────────────────
    public function count()
    {
        $count = Wishlist::where('user_id', Auth::id())->count();
        return response()->json(['count' => $count]);
    }
}
