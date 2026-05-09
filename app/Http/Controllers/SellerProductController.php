<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Harvest;
use App\Models\Product;
use App\Models\Seller;
use App\Models\SellerProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerProductController extends Controller
{
    private function seller()
    {
        return Seller::where('user_id', Auth::id())->firstOrFail();
    }

    public function index()
    {
        $seller   = $this->seller();
        $sellerProfile = SellerProfile::where('user_id', Auth::id())->first();

        $harvests = Harvest::with('product.category')
            ->where('seller_id', $seller->id)
            ->orderByDesc('harvest_date')
            ->paginate(12);

        $categories = Category::orderBy('name')->get();
        $products   = Product::with('category')->orderBy('name')->get();

        return view('seller.produk', compact('harvests', 'categories', 'products', 'seller', 'sellerProfile'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id'      => 'required|exists:products,id',
            'harvest_date'    => 'required|date',
            'remaining_stock' => 'required|integer|min:0',
            'price_per_unit'  => 'required|numeric|min:0',
            'is_organic'      => 'nullable|boolean',
        ]);

        $seller = $this->seller();

        Harvest::create([
            'seller_id'       => $seller->id,
            'product_id'      => $request->product_id,
            'harvest_date'    => $request->harvest_date,
            'remaining_stock' => $request->remaining_stock,
            'price_per_unit'  => $request->price_per_unit,
            'is_organic'      => $request->boolean('is_organic'),
        ]);

        return redirect()->route('seller.products.index')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    public function update(Request $request, Harvest $harvest)
    {
        abort_if($harvest->seller_id !== $this->seller()->id, 403);

        $request->validate([
            'product_id'      => 'required|exists:products,id',
            'harvest_date'    => 'required|date',
            'remaining_stock' => 'required|integer|min:0',
            'price_per_unit'  => 'required|numeric|min:0',
            'is_organic'      => 'nullable|boolean',
        ]);

        $harvest->update([
            'product_id'      => $request->product_id,
            'harvest_date'    => $request->harvest_date,
            'remaining_stock' => $request->remaining_stock,
            'price_per_unit'  => $request->price_per_unit,
            'is_organic'      => $request->boolean('is_organic'),
        ]);

        return redirect()->route('seller.products.index')
            ->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy(Harvest $harvest)
    {
        abort_if($harvest->seller_id !== $this->seller()->id, 403);
        $harvest->delete();

        return redirect()->route('seller.products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }
}
