<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * Tabel products tidak memiliki kolom created_at / updated_at.
     * Jika Anda ingin timestamps, tambahkan $table->timestamps() di migration
     * dan set $timestamps = true (default).
     *
     * Saat ini timestamps = false agar tidak error saat insert.
     */
    public $timestamps = false;

    protected $fillable = [
        'name',
        'category_id',
        'unit',
        'description',
        'status',
        'photo',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function harvests()
    {
        return $this->hasMany(Harvest::class);
    }
}
