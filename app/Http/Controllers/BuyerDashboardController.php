<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Harvest;
use App\Models\SellerProfile;

class BuyerDashboardController extends Controller
{
    public function index()
    {
        $categories = Category::withCount(['products' => fn($q) => $q->whereHas('harvests')])
            ->having('products_count', '>', 0)
            ->get();

        $activeCategoryId = request('category');
        $search           = request('q');

        $harvestQuery = Harvest::with(['product.category', 'seller.user'])
            ->whereDate('harvest_date', '>=', now()->subDays(1));

        if ($activeCategoryId) {
            $harvestQuery->whereHas('product', fn($q) =>
                $q->where('category_id', $activeCategoryId)
            );
        }

        if ($search) {
            $harvestQuery->where(function($q) use ($search) {
                $q->whereHas('product', fn($pq) =>
                    $pq->where('name', 'like', "%{$search}%")
                )->orWhereHas('seller.user', fn($uq) =>
                    $uq->where('name', 'like', "%{$search}%")
                );
            });
        }

        $harvests = $harvestQuery->latest()->take(12)->get();

        // Rekomendasi saat search kosong
        $recommendations = collect();
        if ($search && $harvests->isEmpty()) {
            // Cari berdasarkan kategori yang relevan
            $recommendations = Harvest::with(['product.category', 'seller.user'])
                ->whereDate('harvest_date', '>=', now()->subDays(1))
                ->inRandomOrder()
                ->take(6)
                ->get();
        }

        $todayHarvests = Harvest::with(['product.category', 'seller.user'])
            ->whereDate('harvest_date', now())
            ->latest()
            ->take(6)
            ->get();

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
            'search',
            'recommendations',
        ));
    }

    /**
     * Halaman semua panen hari ini
     */
    public function panenHariIni()
    {
        $search           = request('q');
        $activeCategoryId = request('category');

        $categories = Category::withCount(['products' => fn($q) => $q->whereHas('harvests')])
            ->having('products_count', '>', 0)
            ->get();

        $query = Harvest::with(['product.category', 'seller.user'])
            ->whereDate('harvest_date', now());

        if ($activeCategoryId) {
            $query->whereHas('product', fn($q) =>
                $q->where('category_id', $activeCategoryId)
            );
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->whereHas('product', fn($pq) =>
                    $pq->where('name', 'like', "%{$search}%")
                )->orWhereHas('seller.user', fn($uq) =>
                    $uq->where('name', 'like', "%{$search}%")
                );
            });
        }

        $harvests = $query->latest()->paginate(18)->withQueryString();
        $total    = Harvest::whereDate('harvest_date', now())->count();

        // Rekomendasi saat hasil pencarian kosong
        $recommendations = collect();
        if ($search && $harvests->isEmpty()) {
            // Coba cari dari kategori yang namanya mirip keyword
            $matchedCategory = Category::where('name', 'like', "%{$search}%")->first();

            $recQuery = Harvest::with(['product.category', 'seller.user'])
                ->whereDate('harvest_date', now());

            if ($matchedCategory) {
                $recQuery->whereHas('product', fn($q) =>
                    $q->where('category_id', $matchedCategory->id)
                );
            } else {
                $recQuery->inRandomOrder();
            }

            $recommendations = $recQuery->take(6)->get();
        }

        return view('pembeli.panen-hari-ini', compact(
            'harvests',
            'categories',
            'activeCategoryId',
            'search',
            'total',
            'recommendations',
        ));
    }
}