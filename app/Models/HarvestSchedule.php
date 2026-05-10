<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class HarvestSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'nama_tanaman',
        'tanggal_tanam',
        'estimasi_panen',
        'estimasi_kuantitas',
        'satuan',
        'kebun_lokasi',
        'metode_tanam',
        'status',
        'catatan',
        'luas_lahan',
        'is_organic',
    ];

    protected $casts = [
        'tanggal_tanam' => 'date',
        'estimasi_panen' => 'date',
        'estimasi_kuantitas' => 'decimal:2',
        'luas_lahan' => 'decimal:2',
        'is_organic' => 'boolean',
    ];

    /* ── Relationships ── */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /* ── Accessors ── */

    /**
     * Hitung berapa hari tersisa hingga estimasi panen.
     */
    public function getSisaHariAttribute(): int
    {
        return (int) now()->startOfDay()->diffInDays(
            Carbon::parse($this->estimasi_panen)->startOfDay(),
            false
        );
    }

    /**
     * Label warna status untuk UI.
     * Returns: ['bg', 'text', 'label', 'icon']
     */
    public function getStatusBadgeAttribute(): array
    {
        return match ($this->status) {
            'direncanakan' => ['#ede9fe', '#5b21b6', 'Direncanakan', 'fa-calendar-plus'],
            'sedang_tumbuh' => ['#d1fae5', '#065f46', 'Sedang Tumbuh', 'fa-seedling'],
            'siap_panen' => ['#fef9c3', '#92400e', 'Siap Panen', 'fa-tractor'],
            'selesai' => ['#f0fdf4', '#166534', 'Selesai', 'fa-circle-check'],
            'gagal' => ['#fef2f2', '#991b1b', 'Gagal', 'fa-circle-xmark'],
            default => ['#f3f4f6', '#374151', $this->status, 'fa-circle'],
        };
    }

    /* ── Scopes ── */

    public function scopeForSeller($query)
    {
        return $query->where('user_id', auth()->id());
    }

    public function scopeUpcoming($query)
    {
        return $query->where('estimasi_panen', '>=', now()->toDateString());
    }

    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }
}