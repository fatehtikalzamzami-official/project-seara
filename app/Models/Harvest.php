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
        'is_organic'
    ];

    public function product()
{
    return $this->belongsTo(Product::class);
}

public function seller()
{
    return $this->belongsTo(SellerProfile::class);
}
}
