<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id', 'harvest_id',
        'product_name', 'product_unit', 'seller_name', 'seller_user_id',
        'quantity', 'price_per_unit', 'subtotal',
        'price_offer_id', 'is_offer_price',
    ];

    protected $casts = [
        'price_per_unit'  => 'decimal:2',
        'subtotal'        => 'decimal:2',
        'is_offer_price'  => 'boolean',
    ];

    public function order(): BelongsTo      { return $this->belongsTo(Order::class); }
    public function harvest(): BelongsTo    { return $this->belongsTo(Harvest::class); }
    public function priceOffer(): BelongsTo { return $this->belongsTo(PriceOffer::class); }
    public function seller(): BelongsTo     { return $this->belongsTo(User::class, 'seller_user_id'); }
}
