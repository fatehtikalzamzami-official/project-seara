<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'order_number', 'buyer_id',
        'recipient_name', 'recipient_phone', 'shipping_address',
        'province', 'city', 'postal_code',
        'subtotal', 'shipping_cost', 'discount_amount', 'total_amount',
        'status', 'payment_method', 'payment_proof', 'paid_at',
        'buyer_notes', 'cancel_reason',
    ];

    protected $casts = [
        'subtotal'        => 'decimal:2',
        'shipping_cost'   => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total_amount'    => 'decimal:2',
        'paid_at'         => 'datetime',
    ];

    // ── Relasi ────────────────────────────────────────────────────────────

    public function buyer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    // ── Helper Status ─────────────────────────────────────────────────────

    public function isPendingPayment(): bool { return $this->status === 'pending_payment'; }
    public function isPaid(): bool           { return $this->status === 'paid'; }
    public function isCancelled(): bool      { return $this->status === 'cancelled'; }
    public function isDelivered(): bool      { return $this->status === 'delivered'; }

    public function statusLabel(): string
    {
        return match($this->status) {
            'pending_payment' => '⏳ Menunggu Pembayaran',
            'paid'            => '💳 Sudah Dibayar',
            'processing'      => '📦 Diproses',
            'shipped'         => '🚚 Dikirim',
            'delivered'       => '✅ Diterima',
            'cancelled'       => '❌ Dibatalkan',
            'refunded'        => '↩️ Dikembalikan',
            default           => $this->status,
        };
    }

    public function statusColor(): string
    {
        return match($this->status) {
            'pending_payment' => '#f59e0b',
            'paid'            => '#3b82f6',
            'processing'      => '#8b5cf6',
            'shipped'         => '#06b6d4',
            'delivered'       => '#10b981',
            'cancelled'       => '#ef4444',
            'refunded'        => '#6b7280',
            default           => '#6b7280',
        };
    }

    // ── Generate nomor order ──────────────────────────────────────────────

    public static function generateOrderNumber(): string
    {
        $date   = now()->format('Ymd');
        $random = strtoupper(substr(uniqid(), -5));
        return "SEARA-{$date}-{$random}";
    }
}
