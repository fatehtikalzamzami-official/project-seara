<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Harvest;
use App\Models\SellerProfile;

class BuyerDashboardController extends Controller
{
    public function index()
    {
        // ── Kategori untuk filter ──────────────────────────────────────
        $categories = Category::withCount(['products' => fn($q) => $q->whereHas('harvests')])
            ->having('products_count', '>', 0)
            ->get();

        $activeCategoryId = request('category');

        // ── Produk panen hari ini + filter kategori ────────────────────
        $harvestQuery = Harvest::with(['product.category', 'seller.user'])
            ->where('remaining_stock', '>', 0)
            ->whereDate('harvest_date', '>=', now()->subDays(1));

        if ($activeCategoryId) {
            $harvestQuery->whereHas('product', fn($q) =>
                $q->where('category_id', $activeCategoryId)
            );
        }

        $harvests = $harvestQuery->latest()->take(12)->get();

        // ── Panen hari ini (untuk section tersendiri, tanpa filter) ────
        $todayHarvests = Harvest::with(['product.category', 'seller.user'])
            ->where('remaining_stock', '>', 0)
            ->whereDate('harvest_date', now())
            ->latest()
            ->take(6)
            ->get();

        // ── Petani Terpopuler (real data) ──────────────────────────────
        $topSellers = SellerProfile::with('user')
            ->where('is_verified', true)
            ->where('is_open', true)
            ->orderByDesc('total_transaksi')
            ->take(5)
            ->get();

        return view('pembeli.dashboard', compact(
            'harvests',
            'todayHarvests',
            'categories',
            'activeCategoryId',
            'topSellers',
        ));
    }
}
