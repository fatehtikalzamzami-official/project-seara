<?php

namespace App\Http\Controllers;

use App\Models\Harvest;
use App\Models\Product;
use App\Models\SellerProfile;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Halaman hasil pencarian
     */
    public function index(Request $request)
    {
        $query = trim($request->get('q', ''));
        $categoryId = $request->get('category');

        $harvestQuery = Harvest::with(['product.category', 'seller.user'])
            ->whereDate('harvest_date', '>=', now()->subDays(1));

        if ($query) {
            $harvestQuery->where(function ($q) use ($query) {
                $q->whereHas('product', fn($pq) =>
                    $pq->where('name', 'like', "%{$query}%")
                )->orWhereHas('seller.user', fn($uq) =>
                    $uq->where('nama_lengkap', 'like', "%{$query}%")
                );
            });
        }

        if ($categoryId) {
            $harvestQuery->whereHas('product', fn($q) =>
                $q->where('category_id', $categoryId)
            );
        }

        $harvests = $harvestQuery->latest()->paginate(12)->withQueryString();

        // Rekomendasi jika hasil kosong
        $recommendations = collect();
        if ($harvests->isEmpty() && $query) {
            $recommendations = Harvest::with(['product.category', 'seller.user'])
                ->whereDate('harvest_date', '>=', now()->subDays(1))
                ->inRandomOrder()
                ->take(6)
                ->get();
        }

        return view('search.results', compact('harvests', 'query', 'recommendations', 'categoryId'));
    }

    /**
     * API autocomplete suggestion (min 3 karakter)
     */
    public function suggest(Request $request)
    {
        $query = trim($request->get('q', ''));

        if (strlen($query) < 3) {
            return response()->json([]);
        }

        // Produk yang cocok
        $products = Product::where('name', 'like', "%{$query}%")
            ->whereHas('harvests', fn($q) =>
                $q->whereDate('harvest_date', '>=', now()->subDays(1))
            )
            ->select('id', 'name')
            ->limit(5)
            ->get()
            ->map(fn($p) => [
                'type'  => 'produk',
                'label' => $p->name,
                'query' => $p->name,
                'icon'  => '🌿',
            ]);

        // Seller yang cocok
        $sellers = SellerProfile::with('user')
            ->whereHas('user', fn($q) =>
                $q->where('nama_lengkap', 'like', "%{$query}%")
            )
            ->where('is_verified', true)
            ->limit(3)
            ->get()
            ->map(fn($s) => [
                'type'  => 'petani',
                'label' => $s->user->nama_lengkap ?? '',
                'query' => $s->user->nama_lengkap ?? '',
                'icon'  => '👨‍🌾',
            ]);

        $suggestions = $products->merge($sellers)->take(7)->values();

        return response()->json($suggestions);
    }
}
