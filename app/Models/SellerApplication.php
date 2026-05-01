<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SellerApplication extends Model
{
    protected $fillable = [
        'user_id',
        'nama_toko',
        'slug_toko',
        'deskripsi_toko',
        'kategori_utama',
        'provinsi',
        'kota_kabupaten',
        'alamat_toko',
        'no_ktp',
        'foto_ktp',
        'foto_selfie_ktp',
        'no_rekening',
        'nama_bank',
        'atas_nama_rekening',
        'status',
        'catatan_penolakan',
        'reviewed_by',
        'reviewed_at',
        'submitted_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function sellerProfile()
    {
        return $this->hasOne(SellerProfile::class, 'application_id');
    }
}