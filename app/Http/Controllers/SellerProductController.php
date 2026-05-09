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

        return view('seller.produk', compact('harvests', 'categories', 'seller', 'sellerProfile'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_name'    => 'required|string|max:255',
            'category_id'     => 'required|exists:categories,id',
            'unit'            => 'required|string|max:50',
            'harvest_date'    => 'required|date',
            'remaining_stock' => 'required|integer|min:0',
            'price_per_unit'  => 'required|numeric|min:0',
            'is_organic'      => 'nullable|boolean',
        ]);

        $seller = $this->seller();

        // Buat produk baru dari input petani
        $product = Product::create([
            'name'        => $request->product_name,
            'category_id' => $request->category_id,
            'unit'        => $request->unit,
        ]);

        Harvest::create([
            'seller_id'       => $seller->id,
            'product_id'      => $product->id,
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
            'product_name'    => 'required|string|max:255',
            'category_id'     => 'required|exists:categories,id',
            'unit'            => 'required|string|max:50',
            'harvest_date'    => 'required|date',
            'remaining_stock' => 'required|integer|min:0',
            'price_per_unit'  => 'required|numeric|min:0',
            'is_organic'      => 'nullable|boolean',
        ]);

        // Update data produk terkait
        $harvest->product->update([
            'name'        => $request->product_name,
            'category_id' => $request->category_id,
            'unit'        => $request->unit,
        ]);

        $harvest->update([
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
