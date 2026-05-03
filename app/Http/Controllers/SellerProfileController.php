<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use App\Models\SellerProfile;
use App\Models\Harvest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SellerProfileController extends Controller
{
    // ─────────────────────────────────────────────────────────────────────
    // PUBLIC — Tampilan untuk buyer
    // ─────────────────────────────────────────────────────────────────────

    /**
     * Halaman explore semua toko/petani
     * Route: GET /explore
     */
    public function explore(Request $request)
    {
        $search   = $request->query('q');
        $kategori = $request->query('kategori');
        $provinsi = $request->query('provinsi');

        $sellers = SellerProfile::with('user')
            ->where('is_verified', true)
            ->when($search, fn($q) =>
                $q->where('nama_toko', 'like', "%{$search}%")
                  ->orWhere('deskripsi_toko', 'like', "%{$search}%")
            )
            ->when($kategori, fn($q) => $q->where('kategori_utama', $kategori))
            ->when($provinsi, fn($q) => $q->where('provinsi', $provinsi))
            ->orderByDesc('total_transaksi')
            ->paginate(12);

        $provinsiList = SellerProfile::where('is_verified', true)
            ->whereNotNull('provinsi')
            ->distinct()
            ->pluck('provinsi')
            ->sort()
            ->values();

        $kategoriList = SellerProfile::where('is_verified', true)
            ->whereNotNull('kategori_utama')
            ->distinct()
            ->pluck('kategori_utama')
            ->sort()
            ->values();

        return view('pembeli.explore', compact('sellers', 'search', 'kategori', 'provinsi', 'provinsiList', 'kategoriList'));
    }

    /**
     * Halaman profil toko — bisa diakses via /toko/{slug} atau /petani/{seller}
     * Route: GET /toko/{slug}  dan  GET /petani/{seller}
     */
    public function show($param)
    {
        // Coba resolve sebagai slug_toko dulu, fallback ke ID seller
        $sellerProfile = SellerProfile::where('slug_toko', $param)->with('user')->first();

        if (! $sellerProfile) {
            // Coba anggap $param adalah ID Seller (model Seller lama)
            $seller = Seller::with('user')->find($param);
            if ($seller) {
                $sellerProfile = SellerProfile::where('user_id', $seller->user_id)->with('user')->first();
            }
        }

        if (! $sellerProfile) {
            abort(404, 'Toko tidak ditemukan.');
        }

        // Seller record (untuk harvest)
        $seller = Seller::where('user_id', $sellerProfile->user_id)->first();

        $harvests = collect();
        if ($seller) {
            $harvests = Harvest::with('product')
                ->where('seller_id', $seller->id)
                ->where('remaining_stock', '>', 0)
                ->whereDate('harvest_date', '>=', now()->subDays(7))
                ->orderByDesc('harvest_date')
                ->get();
        }

        $activeHarvest = $harvests->first();

        return view('pembeli.seller-profile', compact(
            'sellerProfile',
            'seller',
            'harvests',
            'activeHarvest',
        ));
    }

    // ─────────────────────────────────────────────────────────────────────
    // SELLER — Dashboard dan manajemen profil toko
    // ─────────────────────────────────────────────────────────────────────

    /**
     * Dashboard seller
     * Route: GET /seller/dashboard
     */
    public function dashboard()
    {
        $user          = Auth::user();
        $sellerProfile = SellerProfile::where('user_id', $user->id)->firstOrFail();
        $seller        = Seller::where('user_id', $user->id)->first();

        $harvests = collect();
        $totalStok = 0;
        $totalTerjual = 0;

        if ($seller) {
            $harvests = Harvest::with('product')
                ->where('seller_id', $seller->id)
                ->orderByDesc('harvest_date')
                ->paginate(10);

            $totalStok    = Harvest::where('seller_id', $seller->id)->sum('remaining_stock');
            $totalTerjual = $sellerProfile->total_transaksi ?? 0;
        }

        return view('seller.dashboard', compact('sellerProfile', 'seller', 'harvests', 'totalStok', 'totalTerjual'));
    }

    /**
     * Form edit profil toko
     * Route: GET /seller/profil
     */
    public function edit()
    {
        $sellerProfile = SellerProfile::where('user_id', Auth::id())->firstOrFail();
        return view('seller.profile-edit', compact('sellerProfile'));
    }

    /**
     * Simpan perubahan profil toko
     * Route: PUT /seller/profil
     */
    public function update(Request $request)
    {
        $sellerProfile = SellerProfile::where('user_id', Auth::id())->firstOrFail();

        $request->validate([
            'nama_toko'        => 'required|string|max:100',
            'deskripsi_toko'   => 'nullable|string|max:1000',
            'kategori_utama'   => 'nullable|string|max:100',
            'provinsi'         => 'nullable|string|max:100',
            'kota_kabupaten'   => 'nullable|string|max:100',
            'alamat_toko'      => 'nullable|string|max:500',
            'jam_operasional'  => 'nullable|array',
            'foto_toko'        => 'nullable|image|max:4096',
            'banner_toko'      => 'nullable|image|max:8192',
        ]);

        $data = $request->only([
            'nama_toko', 'deskripsi_toko', 'kategori_utama',
            'provinsi', 'kota_kabupaten', 'alamat_toko', 'jam_operasional',
        ]);

        if ($request->hasFile('foto_toko')) {
            if ($sellerProfile->foto_toko) {
                Storage::disk('public')->delete($sellerProfile->foto_toko);
            }
            $data['foto_toko'] = $request->file('foto_toko')->store('toko-foto', 'public');
        }

        if ($request->hasFile('banner_toko')) {
            if ($sellerProfile->banner_toko ?? null) {
                Storage::disk('public')->delete($sellerProfile->banner_toko);
            }
            $data['banner_toko'] = $request->file('banner_toko')->store('toko-banner', 'public');
        }

        $sellerProfile->update($data);

        return redirect()->route('seller.profile.edit')
            ->with('success', 'Profil toko berhasil diperbarui.');
    }

    /**
     * Toggle buka/tutup toko
     * Route: POST /seller/profil/toggle
     */
    public function toggleOpen()
    {
        $sellerProfile = SellerProfile::where('user_id', Auth::id())->firstOrFail();
        $sellerProfile->update(['is_open' => ! $sellerProfile->is_open]);

        $status = $sellerProfile->is_open ? 'dibuka' : 'ditutup';

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'is_open' => $sellerProfile->is_open,
                'message' => "Toko berhasil {$status}.",
            ]);
        }

        return back()->with('success', "Toko berhasil {$status}.");
    }

    // ─────────────────────────────────────────────────────────────────────
    // ADMIN — Suspend dan reinstate toko
    // ─────────────────────────────────────────────────────────────────────

    /**
     * Suspend toko (admin)
     * Route: POST /admin/toko/{sellerProfile}/suspend
     */
    public function suspend(Request $request, SellerProfile $sellerProfile)
    {
        $request->validate([
            'alasan' => 'nullable|string|max:500',
        ]);

        $sellerProfile->update([
            'is_verified' => false,
            'is_open'     => false,
        ]);

        return back()->with('success', "Toko {$sellerProfile->nama_toko} berhasil disuspend.");
    }

    /**
     * Pulihkan toko yang disuspend (admin)
     * Route: POST /admin/toko/{sellerProfile}/reinstate
     */
    public function reinstate(SellerProfile $sellerProfile)
    {
        $sellerProfile->update([
            'is_verified' => true,
            'is_open'     => true,
        ]);

        return back()->with('success', "Toko {$sellerProfile->nama_toko} berhasil dipulihkan.");
    }
}
