<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use App\Models\SellerProfile;
use App\Models\Harvest;
use Illuminate\Http\Request;

class SellerProfileController extends Controller
{
    /**
     * Halaman profil petani/toko — tampilan untuk buyer
     * Route: GET /petani/{seller}
     */
    public function show(Seller $seller)
    {
        // Load relasi yang dibutuhkan
        $seller->load('user');

        // Ambil seller_profile via user
        $sellerProfile = SellerProfile::where('user_id', $seller->user_id)->first();

        if (!$sellerProfile) {
            abort(404, 'Profil toko tidak ditemukan.');
        }

        // Ambil semua harvest aktif milik seller ini
        $harvests = Harvest::with('product')
            ->where('seller_id', $seller->id)
            ->where('remaining_stock', '>', 0)
            ->whereDate('harvest_date', '>=', now()->subDays(7))
            ->orderByDesc('harvest_date')
            ->get();

        // Harvest aktif paling baru untuk tombol Chat
        $activeHarvest = $harvests->first();

        return view('pembeli.seller-profile', compact(
            'seller',
            'sellerProfile',
            'harvests',
            'activeHarvest',
        ));
    }
}
