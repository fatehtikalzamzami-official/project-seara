<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Report extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'reporter_id',
        'reported_user_id',
        'harvest_id',
        'type',
        'subject',
        'description',
        'evidence_urls',
        'status',
        'admin_note',
        'handled_by',
        'handled_at',
        'priority',
    ];

    protected $casts = [
        'evidence_urls' => 'array',
        'handled_at'    => 'datetime',
    ];

    /* ── Label helpers ─────────────────────────────────────── */

    public static function typeLabels(): array
    {
        return [
            'produk_palsu'           => 'Produk Palsu',
            'harga_tidak_wajar'      => 'Harga Tidak Wajar',
            'penipuan'               => 'Penipuan',
            'konten_tidak_pantas'    => 'Konten Tidak Pantas',
            'penjual_tidak_responsif'=> 'Penjual Tidak Responsif',
            'lainnya'                => 'Lainnya',
        ];
    }

    public static function statusLabels(): array
    {
        return [
            'pending'   => 'Menunggu',
            'reviewing' => 'Sedang Ditinjau',
            'resolved'  => 'Diselesaikan',
            'dismissed' => 'Ditolak',
        ];
    }

    public static function priorityLabels(): array
    {
        return [
            'low'      => 'Rendah',
            'medium'   => 'Sedang',
            'high'     => 'Tinggi',
            'critical' => 'Kritis',
        ];
    }

    public function getTypeLabelAttribute(): string
    {
        return self::typeLabels()[$this->type] ?? $this->type;
    }

    public function getStatusLabelAttribute(): string
    {
        return self::statusLabels()[$this->status] ?? $this->status;
    }

    public function getPriorityLabelAttribute(): string
    {
        return self::priorityLabels()[$this->priority] ?? $this->priority;
    }

    /* ── Relationships ─────────────────────────────────────── */

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    public function reportedUser()
    {
        return $this->belongsTo(User::class, 'reported_user_id');
    }

    public function harvest()
    {
        return $this->belongsTo(Harvest::class);
    }

    public function handler()
    {
        return $this->belongsTo(User::class, 'handled_by');
    }

    /* ── Scopes ────────────────────────────────────────────── */

    public function scopePending($q)   { return $q->where('status', 'pending'); }
    public function scopeReviewing($q) { return $q->where('status', 'reviewing'); }
    public function scopeResolved($q)  { return $q->where('status', 'resolved'); }
    public function scopeDismissed($q) { return $q->where('status', 'dismissed'); }
    public function scopeActive($q)    { return $q->whereIn('status', ['pending', 'reviewing']); }
}