<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Harvest;
use App\Models\Product;
use App\Models\SellerProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SellerProductController extends Controller
{
    /**
     * Ambil SellerProfile milik user yang login.
     * Menggunakan SellerProfile (tabel `seller_profiles`) yang dibuat saat approve,
     * BUKAN Seller (tabel `sellers`) yang tidak pernah diisi saat approval.
     */
    private function seller()
    {
        return SellerProfile::where('user_id', Auth::id())->firstOrFail();
    }

    public function index()
    {
        $seller        = $this->seller();
        $sellerProfile = $seller;

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
            'product_name'     => 'required|string|max:255',
            'category_id'      => 'required|exists:categories,id',
            'unit'             => 'required|string|max:50',
            'harvest_date'     => 'required|date',
            'remaining_stock'  => 'required|integer|min:0',
            'price_per_unit'   => 'required|numeric|min:0',
            'is_organic'       => 'nullable',
            'description'      => 'nullable|string',
            'status'           => 'nullable|string|in:tersedia,habis,pre-order',
            'photo'            => 'nullable|image|max:2048',
            'kebun_lokasi'     => 'nullable|string|max:255',
            'metode_tanam'     => 'nullable|string',
            'masa_simpan_hari' => 'nullable|integer|min:1',
            'kondisi_produk'   => 'nullable|string',
            'berat_bersih'     => 'nullable|numeric|min:0',
            'minimal_pembelian'=> 'nullable|integer|min:1',
        ]);

        $seller = $this->seller();

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('products', 'public');
        }

        try {
            DB::beginTransaction();

            $product = Product::create([
                'name'        => $request->product_name,
                'category_id' => $request->category_id,
                'unit'        => $request->unit,
                'description' => $request->description,
                'status'      => $request->status ?? 'tersedia',
                'photo'       => $photoPath,
            ]);

            Harvest::create([
                'seller_id'         => $seller->id,
                'product_id'        => $product->id,
                'harvest_date'      => $request->harvest_date,
                'remaining_stock'   => $request->remaining_stock,
                'price_per_unit'    => $request->price_per_unit,
                // Checkbox dengan value="1": hadir = true, tidak hadir = false
                'is_organic'        => $request->has('is_organic') && $request->input('is_organic') ? true : false,
                'kebun_lokasi'      => $request->kebun_lokasi,
                'metode_tanam'      => $request->metode_tanam,
                'masa_simpan_hari'  => $request->masa_simpan_hari,
                'kondisi_produk'    => $request->kondisi_produk,
                'berat_bersih'      => $request->berat_bersih,
                'minimal_pembelian' => $request->minimal_pembelian ?? 1,
            ]);

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();

            // Hapus foto yang sudah di-upload jika transaksi gagal
            if ($photoPath) {
                Storage::disk('public')->delete($photoPath);
            }

            Log::error('SellerProductController@store gagal: ' . $e->getMessage(), [
                'user_id'   => Auth::id(),
                'seller_id' => $seller->id ?? null,
                'request'   => $request->except(['photo', '_token']),
                'trace'     => $e->getTraceAsString(),
            ]);

            return redirect()->route('seller.products.index')
                ->with('error', 'Gagal menambahkan produk. Silakan coba lagi atau hubungi admin.');
        }

        return redirect()->route('seller.products.index')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    public function update(Request $request, Harvest $harvest)
    {
        abort_if($harvest->seller_id !== $this->seller()->id, 403);

        $request->validate([
            'product_name'     => 'required|string|max:255',
            'category_id'      => 'required|exists:categories,id',
            'unit'             => 'required|string|max:50',
            'harvest_date'     => 'required|date',
            'remaining_stock'  => 'required|integer|min:0',
            'price_per_unit'   => 'required|numeric|min:0',
            'is_organic'       => 'nullable',
            'description'      => 'nullable|string',
            'status'           => 'nullable|string|in:tersedia,habis,pre-order',
            'photo'            => 'nullable|image|max:2048',
            'kebun_lokasi'     => 'nullable|string|max:255',
            'metode_tanam'     => 'nullable|string',
            'masa_simpan_hari' => 'nullable|integer|min:1',
            'kondisi_produk'   => 'nullable|string',
            'berat_bersih'     => 'nullable|numeric|min:0',
            'minimal_pembelian'=> 'nullable|integer|min:1',
        ]);

        $photoPath = $harvest->product->photo;
        if ($request->hasFile('photo')) {
            if ($photoPath) {
                Storage::disk('public')->delete($photoPath);
            }
            $photoPath = $request->file('photo')->store('products', 'public');
        }

        try {
            DB::beginTransaction();

            $harvest->product->update([
                'name'        => $request->product_name,
                'category_id' => $request->category_id,
                'unit'        => $request->unit,
                'description' => $request->description,
                'status'      => $request->status ?? 'tersedia',
                'photo'       => $photoPath,
            ]);

            $harvest->update([
                'harvest_date'      => $request->harvest_date,
                'remaining_stock'   => $request->remaining_stock,
                'price_per_unit'    => $request->price_per_unit,
                'is_organic'        => $request->has('is_organic') && $request->input('is_organic') ? true : false,
                'kebun_lokasi'      => $request->kebun_lokasi,
                'metode_tanam'      => $request->metode_tanam,
                'masa_simpan_hari'  => $request->masa_simpan_hari,
                'kondisi_produk'    => $request->kondisi_produk,
                'berat_bersih'      => $request->berat_bersih,
                'minimal_pembelian' => $request->minimal_pembelian ?? 1,
            ]);

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('SellerProductController@update gagal: ' . $e->getMessage(), [
                'user_id'    => Auth::id(),
                'harvest_id' => $harvest->id,
                'trace'      => $e->getTraceAsString(),
            ]);

            return redirect()->route('seller.products.index')
                ->with('error', 'Gagal memperbarui produk. Silakan coba lagi atau hubungi admin.');
        }

        return redirect()->route('seller.products.index')
            ->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy(Harvest $harvest)
    {
        abort_if($harvest->seller_id !== $this->seller()->id, 403);

        if ($harvest->product && $harvest->product->photo) {
            Storage::disk('public')->delete($harvest->product->photo);
        }

        $harvest->product?->delete();
        $harvest->delete();

        return redirect()->route('seller.products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }
}
