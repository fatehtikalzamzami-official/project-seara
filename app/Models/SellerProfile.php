<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SellerProfile extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'application_id',
        'nama_toko',
        'slug_toko',
        'deskripsi_toko',
        'kategori_utama',
        'foto_toko',
        'rating',
        'total_ulasan',
        'total_produk',
        'total_transaksi',
        'provinsi',
        'kota_kabupaten',
        'alamat_toko',
        'jam_operasional',
        'metode_pengiriman',
        'no_rekening',
        'nama_bank',
        'atas_nama_rekening',
        'is_open',
        'is_verified',
        'verified_at',
    ];

    protected $casts = [
        'jam_operasional' => 'array',
        'metode_pengiriman' => 'array',
        'is_open' => 'boolean',
        'is_verified' => 'boolean',
        'verified_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function application()
    {
        return $this->belongsTo(SellerApplication::class, 'application_id');
    }
}