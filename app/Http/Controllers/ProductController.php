<?php

namespace App\Http\Controllers;

use App\Models\Harvest;

class ProductController extends Controller
{
    public function show($id)
    {
        $harvest = Harvest::with(['product.category', 'seller.user'])
            ->findOrFail($id);

        // Produk serupa: same category, bukan produk ini
        $relatedHarvests = Harvest::with(['product', 'seller.user'])
            ->where('id', '!=', $id)
            ->whereHas('product', function ($q) use ($harvest) {
                $q->where('category_id', $harvest->product->category_id);
            })
            ->whereDate('harvest_date', now())
            ->take(5)
            ->get();

        return view('pembeli.product-detail', compact('harvest', 'relatedHarvests'));
    }
}
