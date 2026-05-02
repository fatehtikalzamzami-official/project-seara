@extends('layouts.app')

@section('title', ($sellerProfile->nama_toko ?? 'Toko Petani') . ' — SEARA')

@push('styles')
<style>
/* ═══════════════════════════════════════
   SELLER PROFILE — BUYER VIEW
   ═══════════════════════════════════════ */

/* ── Hero Banner ── */
.sp-hero {
    position: relative;
    background: linear-gradient(135deg, #1b4332 0%, #2d6a4f 40%, #40916c 80%, #52b788 100%);
    padding: 0;
    overflow: hidden;
    min-height: 240px;
    display: flex;
    align-items: flex-end;
}
.sp-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background:
        radial-gradient(ellipse 80% 60% at 80% 30%, rgba(82,183,136,.25) 0%, transparent 60%),
        radial-gradient(ellipse 40% 40% at 10% 80%, rgba(27,67,50,.4) 0%, transparent 60%);
}
.sp-hero-pattern {
    position: absolute;
    inset: 0;
    background-image:
        repeating-linear-gradient(45deg, rgba(255,255,255,.03) 0px, rgba(255,255,255,.03) 1px, transparent 1px, transparent 40px),
        repeating-linear-gradient(-45deg, rgba(255,255,255,.03) 0px, rgba(255,255,255,.03) 1px, transparent 1px, transparent 40px);
}
.sp-hero-leaves {
    position: absolute;
    right: -20px; top: -20px;
    font-size: 200px;
    opacity: .06;
    transform: rotate(20deg);
    line-height: 1;
    pointer-events: none;
    user-select: none;
}
.sp-hero-content {
    position: relative;
    z-index: 2;
    width: 100%;
    max-width: 1100px;
    margin: 0 auto;
    padding: 0 28px 28px;
    display: flex;
    align-items: flex-end;
    gap: 24px;
}

/* Foto toko */
.sp-shop-photo {
    width: 100px; height: 100px;
    border-radius: 20px;
    border: 4px solid rgba(255,255,255,.25);
    background: rgba(255,255,255,.1);
    display: flex; align-items: center; justify-content: center;
    font-size: 48px;
    flex-shrink: 0;
    margin-bottom: 4px;
    backdrop-filter: blur(8px);
    overflow: hidden;
}
.sp-shop-photo img { width: 100%; height: 100%; object-fit: cover; }

.sp-hero-info { flex: 1; }
.sp-shop-name {
    font-family: 'Playfair Display', serif;
    font-size: 28px; font-weight: 700;
    color: white; line-height: 1.2;
    margin-bottom: 6px;
    text-shadow: 0 2px 12px rgba(0,0,0,.2);
}
.sp-shop-category {
    display: inline-flex; align-items: center; gap: 6px;
    font-size: 12px; font-weight: 700;
    background: rgba(255,255,255,.15);
    color: rgba(255,255,255,.9);
    padding: 4px 12px; border-radius: 20px;
    backdrop-filter: blur(4px);
    border: 1px solid rgba(255,255,255,.2);
    margin-bottom: 10px;
}
.sp-badges-row {
    display: flex; align-items: center; gap: 8px; flex-wrap: wrap;
}
.sp-badge {
    display: inline-flex; align-items: center; gap: 5px;
    font-size: 11px; font-weight: 800;
    padding: 4px 10px; border-radius: 20px;
    border: 1.5px solid;
}
.sp-badge.verified  { background: rgba(34,197,94,.15); color: #86efac; border-color: rgba(134,239,172,.3); }
.sp-badge.open      { background: rgba(74,222,128,.15); color: #4ade80; border-color: rgba(74,222,128,.3); }
.sp-badge.closed    { background: rgba(248,113,113,.15); color: #fca5a5; border-color: rgba(252,165,165,.3); }
.sp-badge.loc       { background: rgba(255,255,255,.1); color: rgba(255,255,255,.8); border-color: rgba(255,255,255,.2); }

.sp-hero-actions {
    display: flex; flex-direction: column; gap: 8px;
    align-self: flex-end; flex-shrink: 0;
}
.sp-action-btn {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 10px 18px; border-radius: 12px;
    font-family: 'Nunito', sans-serif;
    font-size: 13px; font-weight: 800;
    cursor: pointer; border: none;
    transition: all .2s; text-decoration: none;
    white-space: nowrap;
}
.sp-action-btn.primary { background: var(--accent); color: white; }
.sp-action-btn.primary:hover { background: #e0521f; transform: translateY(-1px); }
.sp-action-btn.ghost  { background: rgba(255,255,255,.15); color: white; border: 1.5px solid rgba(255,255,255,.3); backdrop-filter: blur(4px); }
.sp-action-btn.ghost:hover { background: rgba(255,255,255,.25); }

/* ── Body layout ── */
.sp-body {
    max-width: 1100px;
    margin: 0 auto;
    padding: 28px 28px 60px;
    display: grid;
    grid-template-columns: 1fr 340px;
    gap: 24px;
    align-items: start;
}

/* ── Card base ── */
.sp-card {
    background: white;
    border-radius: 18px;
    border: 1.5px solid var(--border);
    overflow: hidden;
    box-shadow: 0 2px 12px rgba(0,0,0,.04);
    margin-bottom: 20px;
}
.sp-card-head {
    padding: 16px 20px;
    border-bottom: 1px solid var(--border);
    font-size: 14px; font-weight: 800;
    color: var(--text-dark);
    display: flex; align-items: center; gap: 8px;
}
.sp-card-body { padding: 20px; }

/* ── Stats strip ── */
.sp-stats-strip {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    border-bottom: 1.5px solid var(--border);
}
.sp-stat {
    padding: 20px 16px;
    text-align: center;
    border-right: 1px solid var(--border);
}
.sp-stat:last-child { border-right: none; }
.sp-stat-val {
    font-size: 24px; font-weight: 900;
    color: var(--green-dark);
    line-height: 1;
    margin-bottom: 5px;
    font-family: 'Playfair Display', serif;
}
.sp-stat-lbl {
    font-size: 11px; color: var(--text-muted);
    font-weight: 700; text-transform: uppercase; letter-spacing: .5px;
}

/* ── Star rating ── */
.star-row { display: flex; align-items: center; gap: 3px; }
.star { font-size: 14px; }
.star.full { color: #f59e0b; }
.star.half { color: #f59e0b; }
.star.empty { color: #d1d5db; }

/* ── Produk grid ── */
.sp-products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 16px;
    padding: 20px;
}
.sp-prod-card {
    border-radius: 14px;
    border: 1.5px solid var(--border);
    overflow: hidden;
    transition: all .22s;
    text-decoration: none;
    color: inherit;
    display: block;
    background: white;
}
.sp-prod-card:hover { transform: translateY(-3px); box-shadow: 0 12px 28px rgba(0,0,0,.1); border-color: var(--green-main); }
.sp-prod-img {
    height: 130px;
    background: linear-gradient(135deg, var(--green-pale), #e8f5e9);
    display: flex; align-items: center; justify-content: center;
    font-size: 52px;
    position: relative;
}
.sp-prod-img img { width: 100%; height: 100%; object-fit: cover; }
.sp-prod-badge {
    position: absolute; top: 8px; right: 8px;
    background: var(--green-main); color: white;
    font-size: 10px; font-weight: 800;
    padding: 2px 8px; border-radius: 20px;
}
.sp-prod-info { padding: 12px; }
.sp-prod-name { font-size: 13px; font-weight: 800; color: var(--text-dark); margin-bottom: 3px; }
.sp-prod-price { font-size: 14px; font-weight: 900; color: var(--accent); }
.sp-prod-unit  { font-size: 11px; color: var(--text-muted); }
.sp-prod-stock { font-size: 11px; color: var(--green-main); font-weight: 700; margin-top: 4px; }

/* ── Info rows ── */
.sp-info-row {
    display: flex; align-items: flex-start; gap: 12px;
    padding: 12px 0;
    border-bottom: 1px solid var(--border);
    font-size: 13px;
}
.sp-info-row:last-child { border-bottom: none; }
.sp-info-icon { font-size: 18px; width: 28px; flex-shrink: 0; text-align: center; }
.sp-info-label { color: var(--text-muted); font-weight: 700; font-size: 11px; text-transform: uppercase; letter-spacing: .5px; margin-bottom: 2px; }
.sp-info-val   { color: var(--text-dark); font-weight: 600; }

/* ── Jam operasional ── */
.jam-table { width: 100%; font-size: 12px; }
.jam-table tr td { padding: 4px 0; }
.jam-table tr td:first-child { color: var(--text-muted); font-weight: 700; width: 90px; }
.jam-table tr td:last-child { color: var(--text-dark); font-weight: 600; }
.jam-today td { color: var(--green-dark) !important; font-weight: 800 !important; }

/* ── Pengiriman chips ── */
.ship-chips { display: flex; flex-wrap: wrap; gap: 6px; margin-top: 4px; }
.ship-chip {
    display: inline-flex; align-items: center; gap: 5px;
    font-size: 12px; font-weight: 700;
    background: var(--green-pale); color: var(--green-dark);
    padding: 4px 12px; border-radius: 20px;
    border: 1px solid var(--border);
}

/* ── Tentang toko ── */
.sp-about-text {
    font-size: 13px; line-height: 1.8;
    color: var(--text-mid);
    white-space: pre-line;
}

/* ── Empty state ── */
.sp-empty {
    text-align: center; padding: 48px 20px;
    color: var(--text-muted);
}
.sp-empty .ico { font-size: 48px; margin-bottom: 10px; }
.sp-empty p { font-size: 13px; }

/* ── Back link ── */
.sp-hero-content {
    position: relative;
}

.sp-back {
    position: absolute;
    top: -70px; /* naik ke atas banner */
    left: 0;
    margin-left: 2.6%;
    margin-bottom: 5%

    background: rgba(0,0,0,0.4);
    color: #fff;
    padding: 8px 14px;
    border-radius: 8px;
    text-decoration: none;
    backdrop-filter: blur(4px);
}
.sp-back:hover { border-color: var(--green-main); color: var(--green-main); background: var(--green-pale); }

/* ── Animasi ── */
@keyframes fadeUp {
    from { opacity:0; transform:translateY(18px); }
    to   { opacity:1; transform:translateY(0); }
}
.anim-1 { animation: fadeUp .4s .05s both; }
.anim-2 { animation: fadeUp .4s .12s both; }
.anim-3 { animation: fadeUp .4s .20s both; }

/* Mobile */
@media (max-width: 768px) {
    .sp-body { grid-template-columns: 1fr; padding: 16px; }
    .sp-hero-content { flex-direction: column; align-items: flex-start; gap: 16px; padding: 16px 16px 20px; position: relative;}
    .sp-hero-actions { flex-direction: row; align-self: auto; }
    .sp-stats-strip { grid-template-columns: repeat(2, 1fr); }
    .sp-products-grid { grid-template-columns: repeat(2, 1fr); }
    .sp-shop-name { font-size: 22px; }
}
</style>
@endpush

@section('content')

{{-- ══ HERO BANNER ══ --}}
<div class="sp-hero anim-1"
     style="
        background: 
        linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)),
        url('{{ $sellerProfile->banner ? asset('storage/' . $sellerProfile->banner) : asset('images/default-banner.jpg') }}');
        background-size: cover;
        background-position: center;
     ">


    <div class="sp-hero-pattern"></div>
    <div class="sp-hero-leaves">🌿</div>
    <div class="sp-hero-content">
             {{-- Back link --}}
<a href="{{ url()->previous() }}" class="sp-back">←</a>
        {{-- Foto toko --}}
        <div class="sp-shop-photo">
            @if($sellerProfile->foto_toko)
                <img src="{{ asset('storage/' . $sellerProfile->foto_toko) }}" alt="{{ $sellerProfile->nama_toko }}">
            @else
                🌾
            @endif
        </div>

        {{-- Info utama --}}
        <div class="sp-hero-info">
            <div class="sp-shop-name">{{ $sellerProfile->nama_toko }}</div>
            <div class="sp-shop-category">🌱 {{ $sellerProfile->kategori_utama }}</div>
            <div class="sp-badges-row">
                @if($sellerProfile->is_verified)
                    <span class="sp-badge verified">✓ Terverifikasi SEARA</span>
                @endif
                @if($sellerProfile->is_open)
                    <span class="sp-badge open">● Buka Sekarang</span>
                @else
                    <span class="sp-badge closed">● Tutup</span>
                @endif
                @if($sellerProfile->kota_kabupaten)
                    <span class="sp-badge loc">📍 {{ $sellerProfile->kota_kabupaten }}, {{ $sellerProfile->provinsi }}</span>
                @endif
            </div>
        </div>

        {{-- Tombol aksi --}}
        <div class="sp-hero-actions">
            @if($activeHarvest)
                <form method="POST" action="{{ route('chat.open') }}" style="display:inline;">
                    @csrf
                    <input type="hidden" name="seller_user_id" value="{{ $seller->user_id }}">
                    <input type="hidden" name="harvest_id" value="{{ $activeHarvest->id }}">
                    <button type="submit" class="sp-action-btn primary">💬 Chat Petani</button>
                </form>
            @endif
            @if($seller->user->no_whatsapp)
                <a href="https://wa.me/{{ preg_replace('/\D/', '', $seller->user->no_whatsapp) }}?text=Halo%20{{ urlencode($sellerProfile->nama_toko) }}%2C%20saya%20melihat%20toko%20Anda%20di%20SEARA"
                   target="_blank" class="sp-action-btn ghost">📱 WhatsApp</a>
            @endif
        </div>
    </div>
</div>

{{-- ══ STATS STRIP ══ --}}
<div style="max-width:1100px;margin:0 auto;padding:0 28px;" class="anim-2">
    <div class="sp-card" style="margin-top:20px;">
        <div class="sp-stats-strip">
            <div class="sp-stat">
                <div class="sp-stat-val">
                    @if($sellerProfile->rating > 0)
                        {{ number_format($sellerProfile->rating, 1) }}★
                    @else
                        —
                    @endif
                </div>
                <div class="sp-stat-lbl">Rating Toko</div>
                @if($sellerProfile->total_ulasan > 0)
                    <div style="font-size:11px;color:var(--text-muted);margin-top:4px;">{{ $sellerProfile->total_ulasan }} ulasan</div>
                @endif
            </div>
            <div class="sp-stat">
                <div class="sp-stat-val">{{ $sellerProfile->total_produk ?: $harvests->count() }}</div>
                <div class="sp-stat-lbl">Produk Aktif</div>
            </div>
            <div class="sp-stat">
                <div class="sp-stat-val">
                    @if($sellerProfile->total_transaksi >= 1000)
                        {{ number_format($sellerProfile->total_transaksi / 1000, 1) }}rb
                    @else
                        {{ $sellerProfile->total_transaksi }}
                    @endif
                </div>
                <div class="sp-stat-lbl">Transaksi</div>
            </div>
            <div class="sp-stat">
                <div class="sp-stat-val">
                    {{ $sellerProfile->verified_at ? $sellerProfile->verified_at->diffForHumans(null, true) : '—' }}
                </div>
                <div class="sp-stat-lbl">Bergabung</div>
            </div>
        </div>
    </div>
</div>

{{-- ══ BODY GRID ══ --}}
<div class="sp-body anim-3">

    {{-- ── KOLOM KIRI: Produk & Deskripsi ── --}}
    <div>

        {{-- Deskripsi Toko --}}
        @if($sellerProfile->deskripsi_toko)
        <div class="sp-card">
            <div class="sp-card-head">🌿 Tentang Toko</div>
            <div class="sp-card-body">
                <p class="sp-about-text">{{ $sellerProfile->deskripsi_toko }}</p>
            </div>
        </div>
        @endif

        {{-- Produk/Panen Tersedia --}}
        <div class="sp-card">
            <div class="sp-card-head">
                🌾 Produk Tersedia
                <span style="margin-left:auto;font-size:12px;font-weight:600;color:var(--text-muted);">{{ $harvests->count() }} item</span>
            </div>

            @if($harvests->isEmpty())
                <div class="sp-empty">
                    <div class="ico">📭</div>
                    <p>Belum ada produk tersedia saat ini.<br>Cek lagi nanti ya!</p>
                </div>
            @else
                <div class="sp-products-grid">
                    @foreach($harvests as $harvest)
                        <a href="{{ route('buyer.product.show', $harvest->id) }}" class="sp-prod-card">
                            <div class="sp-prod-img">
                                @if($harvest->product->image_path ?? false)
                                    <img src="{{ asset('storage/' . $harvest->product->image_path) }}" alt="{{ $harvest->product->name }}">
                                @else
                                    {{ $harvest->product->emoji ?? '🌾' }}
                                @endif
                                @if($harvest->remaining_stock > 0)
                                    <span class="sp-prod-badge">Tersedia</span>
                                @endif
                            </div>
                            <div class="sp-prod-info">
                                <div class="sp-prod-name">{{ $harvest->product->name }}</div>
                                <div class="sp-prod-price">
                                    Rp {{ number_format($harvest->price_per_unit, 0, ',', '.') }}
                                    <span class="sp-prod-unit">/ {{ $harvest->product->unit ?? 'kg' }}</span>
                                </div>
                                @if($harvest->remaining_stock)
                                    <div class="sp-prod-stock">🟢 Stok: {{ number_format($harvest->remaining_stock, 0, ',', '.') }} {{ $harvest->product->unit ?? 'kg' }}</div>
                                @endif
                                @if($harvest->harvest_date)
                                    <div style="font-size:11px;color:var(--text-muted);margin-top:3px;">
                                        🗓 Panen {{ \Carbon\Carbon::parse($harvest->harvest_date)->format('d M Y') }}
                                    </div>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>

    </div>

    {{-- ── KOLOM KANAN: Info & Operasional ── --}}
    <div>

        {{-- Info Petani --}}
        <div class="sp-card">
            <div class="sp-card-head">👨‍🌾 Info Petani</div>
            <div class="sp-card-body">
                {{-- Identitas --}}
                <div style="display:flex;align-items:center;gap:14px;margin-bottom:16px;padding-bottom:16px;border-bottom:1px solid var(--border);">
                    <div style="width:52px;height:52px;border-radius:14px;background:linear-gradient(135deg,var(--green-pale),var(--green-light));display:flex;align-items:center;justify-content:center;font-size:24px;flex-shrink:0;">
                        {{ $seller->user->avatar ? '📸' : '👤' }}
                    </div>
                    <div>
                        <div style="font-size:15px;font-weight:800;color:var(--text-dark);">{{ $seller->user->nama_lengkap ?? $seller->user->name }}</div>
                        <div style="font-size:12px;color:var(--text-muted);margin-top:2px;">Pemilik Toko</div>
                        @if($seller->user->isOnline())
                            <div style="font-size:11px;font-weight:700;color:#16a34a;margin-top:3px;display:flex;align-items:center;gap:5px;">
                                <span style="width:7px;height:7px;border-radius:50%;background:#22c55e;display:inline-block;"></span>
                                Online Sekarang
                            </div>
                        @else
                            <div style="font-size:11px;color:var(--text-muted);margin-top:3px;">
                                Terakhir aktif {{ $seller->user->onlineLabel() }}
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Detail info --}}
                @if($sellerProfile->kota_kabupaten)
                <div class="sp-info-row">
                    <div class="sp-info-icon">📍</div>
                    <div>
                        <div class="sp-info-label">Lokasi</div>
                        <div class="sp-info-val">{{ $sellerProfile->kota_kabupaten }}, {{ $sellerProfile->provinsi }}</div>
                        @if($sellerProfile->alamat_toko)
                            <div style="font-size:12px;color:var(--text-muted);margin-top:2px;">{{ $sellerProfile->alamat_toko }}</div>
                        @endif
                    </div>
                </div>
                @endif

                @if($seller->user->no_whatsapp)
                <div class="sp-info-row">
                    <div class="sp-info-icon">📱</div>
                    <div>
                        <div class="sp-info-label">WhatsApp</div>
                        <a href="https://wa.me/{{ preg_replace('/\D/', '', $seller->user->no_whatsapp) }}"
                           target="_blank"
                           style="color:var(--green-main);font-weight:700;font-size:13px;text-decoration:none;">
                            {{ $seller->user->no_whatsapp }}
                        </a>
                    </div>
                </div>
                @endif

                @if($sellerProfile->is_verified && $sellerProfile->verified_at)
                <div class="sp-info-row">
                    <div class="sp-info-icon">✅</div>
                    <div>
                        <div class="sp-info-label">Verifikasi SEARA</div>
                        <div class="sp-info-val" style="color:var(--green-main);">Terverifikasi {{ $sellerProfile->verified_at->format('d M Y') }}</div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        {{-- Jam Operasional --}}
        @if($sellerProfile->jam_operasional)
        <div class="sp-card">
            <div class="sp-card-head">🕐 Jam Operasional</div>
            <div class="sp-card-body" style="padding:12px 20px;">
                @php
                    $hariMap = [
                        'senin'  => 'Senin',
                        'selasa' => 'Selasa',
                        'rabu'   => 'Rabu',
                        'kamis'  => 'Kamis',
                        'jumat'  => 'Jumat',
                        'sabtu'  => 'Sabtu',
                        'minggu' => 'Minggu',
                    ];
                    $hariIni = strtolower(\Carbon\Carbon::now()->locale('id')->dayName);
                    // fallback ke inggris jika locale belum di-set
                    $hariIngMap = ['monday'=>'senin','tuesday'=>'selasa','wednesday'=>'rabu','thursday'=>'kamis','friday'=>'jumat','saturday'=>'sabtu','sunday'=>'minggu'];
                    $hariIniEn = strtolower(now()->format('l'));
                    $hariIniKey = $hariIngMap[$hariIniEn] ?? '';
                @endphp
                <table class="jam-table">
                    @foreach($hariMap as $key => $label)
                        @if(isset($sellerProfile->jam_operasional[$key]))
                        <tr class="{{ $hariIniKey === $key ? 'jam-today' : '' }}">
                            <td>
                                {{ $label }}
                                @if($hariIniKey === $key)
                                    <span style="font-size:10px;background:var(--green-main);color:white;padding:1px 5px;border-radius:5px;margin-left:4px;">Hari ini</span>
                                @endif
                            </td>
                            <td>{{ $sellerProfile->jam_operasional[$key] }}</td>
                        </tr>
                        @endif
                    @endforeach
                </table>
            </div>
        </div>
        @endif

        {{-- Metode Pengiriman --}}
        @php $metode = is_array($sellerProfile->metode_pengiriman) ? $sellerProfile->metode_pengiriman : json_decode($sellerProfile->metode_pengiriman ?? '[]', true); @endphp
        @if(!empty($metode))
        <div class="sp-card">
            <div class="sp-card-head">🚚 Layanan Pengiriman</div>
            <div class="sp-card-body">
                <div class="ship-chips">
                    @foreach($metode as $mitra)
                        <span class="ship-chip">✓ {{ $mitra }}</span>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        {{-- CTA Chat --}}
        @if($activeHarvest)
        <div class="sp-card" style="background:linear-gradient(135deg,var(--green-pale),#e8f5e9);border-color:var(--green-light);">
            <div class="sp-card-body" style="text-align:center;padding:24px;">
                <div style="font-size:32px;margin-bottom:8px;">💬</div>
                <div style="font-size:15px;font-weight:800;color:var(--green-dark);margin-bottom:6px;">Ada yang mau ditanyakan?</div>
                <div style="font-size:12px;color:var(--text-muted);margin-bottom:16px;">Chat langsung dengan petani untuk nego harga atau tanya stok</div>
                <form method="POST" action="{{ route('chat.open') }}" style="display:inline;">
                    @csrf
                    <input type="hidden" name="seller_user_id" value="{{ $seller->user_id }}">
                    <input type="hidden" name="harvest_id" value="{{ $activeHarvest->id }}">
                    <button type="submit"
                        style="display:inline-flex;align-items:center;gap:8px;padding:11px 24px;background:var(--green-main);color:white;border-radius:12px;font-family:'Nunito',sans-serif;font-size:14px;font-weight:800;border:none;cursor:pointer;transition:background .2s;"
                        onmouseover="this.style.background='var(--green-dark)'"
                        onmouseout="this.style.background='var(--green-main)'">
                        💬 Mulai Chat
                    </button>
                </form>
            </div>
        </div>
        @endif

    </div>
</div>

@endsection