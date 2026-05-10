<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class HarvestSchedule extends Model
{
    use HasFactory;

    protected $table = 'harvest_schedules';

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
        'tanggal_tanam'      => 'date',
        'estimasi_panen'     => 'date',
        'estimasi_kuantitas' => 'decimal:2',
        'luas_lahan'         => 'decimal:2',
        'is_organic'         => 'boolean',
    ];

    /* ── Status labels & colors ────────────────────────────── */

    public static function statusOptions(): array
    {
        return [
            'direncanakan'  => ['label' => 'Direncanakan',  'color' => '#3b82f6', 'bg' => '#dbeafe', 'icon' => '📋'],
            'sedang_tumbuh' => ['label' => 'Sedang Tumbuh', 'color' => '#16a34a', 'bg' => '#dcfce7', 'icon' => '🌱'],
            'siap_panen'    => ['label' => 'Siap Panen',    'color' => '#ca8a04', 'bg' => '#fef9c3', 'icon' => '🌾'],
            'selesai'       => ['label' => 'Selesai',       'color' => '#6b7280', 'bg' => '#f3f4f6', 'icon' => '✅'],
            'gagal'         => ['label' => 'Gagal',         'color' => '#dc2626', 'bg' => '#fee2e2', 'icon' => '❌'],
        ];
    }

    public function getStatusInfoAttribute(): array
    {
        return self::statusOptions()[$this->status]
            ?? ['label' => $this->status, 'color' => '#6b7280', 'bg' => '#f3f4f6', 'icon' => '❓'];
    }

    public function getStatusLabelAttribute(): string
    {
        return self::statusOptions()[$this->status]['label'] ?? $this->status;
    }

    /* ── Computed attributes ───────────────────────────────── */

    /**
     * Sisa hari hingga estimasi panen (negatif = sudah lewat)
     */
    public function getSisaHariAttribute(): int
    {
        return (int) now()->startOfDay()->diffInDays(
            $this->estimasi_panen->copy()->startOfDay(),
            false
        );
    }

    /**
     * Progress tanam → panen (0–100%)
     */
    public function getProgressAttribute(): int
    {
        if (!$this->tanggal_tanam) return 0;

        $total = $this->tanggal_tanam->diffInDays($this->estimasi_panen);
        if ($total <= 0) return 100;

        $elapsed = $this->tanggal_tanam->diffInDays(now());
        return min(100, (int) round(($elapsed / $total) * 100));
    }

    /* ── Relationships ─────────────────────────────────────── */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /* ── Scopes ────────────────────────────────────────────── */

    /**
     * Filter by seller user_id.
     * $userId is optional — falls back to the authenticated user.
     */
    public function scopeForSeller($q, $userId = null)
    {
        return $q->where('user_id', $userId ?? Auth::id());
    }

    public function scopeActive($q)
    {
        return $q->whereIn('status', ['direncanakan', 'sedang_tumbuh', 'siap_panen']);
    }

    public function scopeUpcoming($q, int $days = 7)
    {
        return $q->where('estimasi_panen', '<=', now()->addDays($days))
                 ->where('estimasi_panen', '>=', now())
                 ->whereNotIn('status', ['selesai', 'gagal']);
    }
}