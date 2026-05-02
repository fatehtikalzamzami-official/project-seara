<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = [
        'user_id',
        'harvest_id',
        'quantity',
    ];

    // ── Relasi ──────────────────────────────────────────────────────────

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function harvest()
    {
        return $this->belongsTo(Harvest::class);
    }

    // ── Accessor ────────────────────────────────────────────────────────

    /**
     * Total harga item ini (qty × price_per_unit).
     */
    public function getSubtotalAttribute(): float
    {
        return $this->quantity * ($this->harvest->price_per_unit ?? 0);
    }
}
