<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Harvest extends Model
{
    protected $fillable = [
        'seller_id',
        'product_id',
        'harvest_date',
        'remaining_stock',
        'price_per_unit',
        'is_organic',
        'kebun_lokasi',
        'metode_tanam',
        'masa_simpan_hari',
        'kondisi_produk',
        'berat_bersih',
        'minimal_pembelian',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Sebelumnya menunjuk ke Seller (tabel sellers) yang tidak pernah diisi.
     * Sekarang menunjuk ke SellerProfile (tabel seller_profiles).
     */
    public function seller()
    {
        return $this->belongsTo(SellerProfile::class, 'seller_id');
    }
}