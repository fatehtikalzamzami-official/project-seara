<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Withdrawal extends Model
{
    protected $fillable = [
        'seller_user_id',
        'jumlah',
        'biaya_admin',
        'diterima',
        'nama_bank',
        'no_rekening',
        'atas_nama',
        'status',
        'catatan',
        'admin_note',
        'handled_by',
        'handled_at',
        'transferred_at',
    ];

    protected $casts = [
        'jumlah'        => 'decimal:2',
        'biaya_admin'   => 'decimal:2',
        'diterima'      => 'decimal:2',
        'handled_at'    => 'datetime',
        'transferred_at'=> 'datetime',
    ];

    /* ── Status helpers ─────────────────────────────────────── */

    public static function statusLabels(): array
    {
        return [
            'pending'     => 'Menunggu Persetujuan',
            'approved'    => 'Disetujui',
            'rejected'    => 'Ditolak',
            'transferred' => 'Sudah Ditransfer',
        ];
    }

    public static function statusColors(): array
    {
        return [
            'pending'     => '#f59e0b',
            'approved'    => '#3b82f6',
            'rejected'    => '#ef4444',
            'transferred' => '#10b981',
        ];
    }

    public function getStatusLabelAttribute(): string
    {
        return self::statusLabels()[$this->status] ?? $this->status;
    }

    public function getStatusColorAttribute(): string
    {
        return self::statusColors()[$this->status] ?? '#6b7280';
    }

    /* ── Relationships ──────────────────────────────────────── */

    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'seller_user_id');
    }

    public function handler(): BelongsTo
    {
        return $this->belongsTo(User::class, 'handled_by');
    }

    /* ── Scopes ─────────────────────────────────────────────── */

    public function scopePending($q)    { return $q->where('status', 'pending'); }
    public function scopeApproved($q)   { return $q->where('status', 'approved'); }
    public function scopeTransferred($q){ return $q->where('status', 'transferred'); }
    public function scopeRejected($q)   { return $q->where('status', 'rejected'); }

    public function scopeForSeller($q, $userId = null)
    {
        return $q->where('seller_user_id', $userId ?? auth()->id());
    }

    /* ── Helpers ─────────────────────────────────────────────── */

    /**
     * Total yang sudah dicairkan (transferred) untuk seller tertentu.
     */
    public static function totalDicairkan(int $sellerUserId): float
    {
        return (float) self::where('seller_user_id', $sellerUserId)
            ->whereIn('status', ['approved', 'transferred'])
            ->sum('jumlah');
    }
}
