<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PriceOffer extends Model
{
    protected $fillable = [
        'harvest_id', 'buyer_id', 'seller_user_id', 'chat_room_id',
        'original_price', 'offer_price', 'counter_price', 'quantity',
        'status', 'buyer_note', 'seller_note', 'expires_at',
    ];

    protected $casts = [
        'original_price' => 'decimal:2',
        'offer_price'    => 'decimal:2',
        'counter_price'  => 'decimal:2',
        'expires_at'     => 'datetime',
    ];

    public function harvest(): BelongsTo  { return $this->belongsTo(Harvest::class); }
    public function buyer(): BelongsTo    { return $this->belongsTo(User::class, 'buyer_id'); }
    public function seller(): BelongsTo   { return $this->belongsTo(User::class, 'seller_user_id'); }
    public function chatRoom(): BelongsTo { return $this->belongsTo(ChatRoom::class); }

    public function isPending(): bool    { return $this->status === 'pending'; }
    public function isAccepted(): bool   { return $this->status === 'accepted'; }
    public function isCountered(): bool  { return $this->status === 'countered'; }
    public function isExpired(): bool    { return $this->expires_at && $this->expires_at->isPast(); }

    public function discountPct(): float
    {
        return round((1 - $this->offer_price / $this->original_price) * 100, 1);
    }

    // Label badge status
    public function statusLabel(): string
    {
        return match($this->status) {
            'pending'   => '⏳ Menunggu',
            'accepted'  => '✅ Diterima',
            'rejected'  => '❌ Ditolak',
            'countered' => '🔄 Ditawar Balik',
            'cancelled' => '🚫 Dibatalkan',
            default     => $this->status,
        };
    }
}
