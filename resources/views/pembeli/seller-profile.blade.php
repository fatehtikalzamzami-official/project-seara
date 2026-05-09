@extends('layouts.app')

@section('title', ($sellerProfile->nama_toko ?? 'Profil Toko') . ' — SEARA')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
<style>
*, *::before, *::after { box-sizing: border-box; }

.buyer-shell { max-width: 1200px; margin: 0 auto; padding: 28px 24px 60px; }

/* ── PAGE HEADER ── */
.page-header {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 24px; flex-wrap: wrap; gap: 12px;
}
.page-header h1 {
    font-family: 'Playfair Display', serif; font-size: 24px;
    font-weight: 700; color: var(--text-dark); display: flex; align-items: center; gap: 8px;
}
.page-header p { font-size: 13px; color: var(--text-muted); margin-top: 3px; font-weight: 600; }

/* ── PROFILE BANNER ── */
.profile-banner {
    width: 100%; height: 180px;
    background: linear-gradient(135deg, var(--green-dark), var(--green-main));
    border-radius: 16px 16px 0 0; overflow: hidden;
    display: flex; align-items: center; justify-content: center;
    font-size: 60px; position: relative;
}
.profile-banner img { width: 100%; height: 100%; object-fit: cover; }

/* ── PROFILE CARD ── */
.profile-card {
    background: white; border: 1px solid var(--border);
    border-radius: 16px; margin-bottom: 20px;
    box-shadow: 0 1px 4px rgba(0,0,0,0.06);
}
.profile-card-body { padding: 0 28px 24px; }

.avatar-wrap {
    display: flex; align-items: flex-end;
    justify-content: space-between;
    margin-top: -48px; margin-bottom: 16px;
    position: relative; z-index: 5;
}
.profile-avatar {
    width: 88px; height: 88px; border-radius: 50%;
    border: 4px solid white; background: var(--green-mid);
    display: flex; align-items: center; justify-content: center;
    font-family: 'Playfair Display', serif; font-size: 28px;
    font-weight: 700; color: white; overflow: hidden; flex-shrink: 0;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}
.profile-avatar img { width: 100%; height: 100%; object-fit: cover; }

.profile-name {
    font-family: 'Playfair Display', serif; font-size: 22px;
    font-weight: 700; color: var(--text-dark); margin-bottom: 6px;
}
.profile-badges { display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 10px; }
.pbadge {
    display: inline-flex; align-items: center; gap: 4px;
    font-size: 11px; font-weight: 700; padding: 4px 10px; border-radius: 100px;
}
.pbadge-verified { background: #fffbeb; color: #92400e; border: 1px solid #fde68a; }
.pbadge-cat { background: var(--green-pale); color: var(--green-dark); border: 1px solid var(--border); }
.pbadge-open { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }
.pbadge-closed { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }

.profile-desc { font-size: 14px; color: var(--text-mid); line-height: 1.7; margin-bottom: 14px; }
.profile-meta { display: flex; flex-wrap: wrap; gap: 16px; }
.pmeta-item { display: flex; align-items: center; gap: 6px; font-size: 13px; color: var(--text-muted); font-weight: 600; }
.pmeta-item i { color: var(--green-main); }

/* ── CTA BUTTONS (buyer) ── */
.buyer-cta-row { display: flex; gap: 10px; align-items: center; flex-wrap: wrap; }
.btn-chat-green {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 10px 20px; border-radius: 10px;
    background: var(--green-main); border: none; color: white;
    font-family: 'Nunito', sans-serif; font-size: 13px; font-weight: 700;
    cursor: pointer; text-decoration: none; transition: all .2s;
}
.btn-chat-green:hover { background: var(--green-dark); color: white; }
.btn-wa-green {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 10px 20px; border-radius: 10px;
    background: #22c55e; border: none; color: white;
    font-family: 'Nunito', sans-serif; font-size: 13px; font-weight: 700;
    cursor: pointer; text-decoration: none; transition: all .2s;
}
.btn-wa-green:hover { opacity: 0.88; color: white; }

/* ── STATS ROW ── */
.stats-row {
    display: grid; grid-template-columns: repeat(4, 1fr);
    gap: 14px; margin-bottom: 20px;
}
.stat-card {
    background: white; border: 1px solid var(--border);
    border-radius: 12px; padding: 18px 16px; text-align: center;
    box-shadow: 0 1px 4px rgba(0,0,0,0.06);
}
.stat-card-val {
    font-family: 'Playfair Display', serif; font-size: 26px;
    font-weight: 700; color: var(--green-dark); line-height: 1; margin-bottom: 4px;
}
.stat-card-lbl { font-size: 11px; color: var(--text-muted); font-weight: 700; text-transform: uppercase; letter-spacing: .5px; }

/* ── SECTION CARD ── */
.section-card { background: white; border: 1px solid var(--border); border-radius: 14px; overflow: hidden; margin-bottom: 16px; }
.section-head { padding: 16px 20px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; }
.section-head h2 { font-size: 14px; font-weight: 900; color: var(--text-dark); display: flex; align-items: center; gap: 8px; margin: 0; }
.section-head h2 i { color: var(--green-main); }
.section-body { padding: 20px; }
.section-count { font-size: 11px; font-weight: 600; background: var(--green-pale); color: var(--green-dark); padding: 3px 10px; border-radius: 100px; }

/* ── INFO LIST ── */
.info-list { display: flex; flex-direction: column; gap: 2px; }
.info-item { display: flex; align-items: flex-start; gap: 12px; padding: 10px 0; border-bottom: 1px solid var(--green-pale); }
.info-item:last-child { border-bottom: none; }
.info-icon-wrap { width: 36px; height: 36px; border-radius: 9px; background: var(--green-pale); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.info-icon-wrap i { color: var(--green-dark); font-size: 15px; }
.info-content { flex: 1; }
.info-lbl { font-size: 11px; color: var(--text-muted); font-weight: 700; text-transform: uppercase; letter-spacing: .4px; margin-bottom: 2px; }
.info-val { font-size: 13px; color: var(--text-dark); font-weight: 700; }
.info-sub { font-size: 12px; color: var(--text-muted); margin-top: 2px; }

/* ── PRODUCT GRID ── */
.product-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(130px, 1fr)); gap: 10px; }
.prod-card {
    background: var(--green-bg); border: 1px solid var(--border); border-radius: 10px;
    padding: 12px; display: block; color: inherit; text-decoration: none;
    transition: transform .15s, box-shadow .15s, border-color .15s;
}
.prod-card:hover { transform: translateY(-2px); box-shadow: 0 6px 16px rgba(0,0,0,0.09); border-color: var(--green-light); }
.prod-thumb { width: 100%; aspect-ratio: 1; background: var(--green-pale); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 32px; margin-bottom: 8px; overflow: hidden; }
.prod-thumb img { width: 100%; height: 100%; object-fit: cover; }
.prod-name { font-size: 12px; font-weight: 700; color: var(--text-dark); margin-bottom: 3px; line-height: 1.3; }
.prod-price { font-size: 12px; color: var(--accent); font-weight: 800; }
.prod-stock { font-size: 11px; color: var(--text-muted); margin-top: 3px; }
.prod-organic { display: inline-flex; align-items: center; gap: 3px; font-size: 10px; font-weight: 700; background: var(--green-pale); color: var(--green-dark); padding: 2px 7px; border-radius: 100px; margin-top: 5px; }

.prod-more {
    background: var(--green-pale); border: 1.5px dashed var(--border);
    display: flex; flex-direction: column; align-items: center; justify-content: center;
    gap: 6px; border-radius: 10px; padding: 12px; text-decoration: none;
    transition: background .18s, border-color .18s; color: var(--green-dark);
    aspect-ratio: 1;
}
.prod-more:hover { background: #d1fae5; border-color: var(--green-main); }
.prod-more i { font-size: 22px; color: var(--green-main); }
.prod-more span { font-size: 11px; font-weight: 800; text-align: center; }

/* ── HOURS GRID ── */
.hours-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(130px, 1fr)); gap: 8px; }
.hour-item { background: var(--green-bg); border: 1px solid var(--border); border-radius: 10px; padding: 10px 12px; }
.hour-item.today { background: var(--green-pale); border-color: var(--green-light); }
.hour-day { font-size: 12px; font-weight: 800; color: var(--text-mid); margin-bottom: 2px; display: flex; align-items: center; gap: 5px; }
.hour-item.today .hour-day { color: var(--green-dark); }
.today-pip { font-size: 9px; background: var(--green-main); color: #fff; padding: 1px 6px; border-radius: 100px; font-weight: 700; }
.hour-time { font-size: 12px; color: var(--text-muted); font-weight: 600; }
.hour-badge { display: inline-block; font-size: 10px; font-weight: 700; padding: 2px 8px; border-radius: 100px; margin-top: 5px; }
.hour-open { background: var(--green-pale); color: var(--green-dark); }
.hour-closed { background: #f4f4f4; color: var(--text-muted); }

/* ── SHIP CHIPS ── */
.ship-chips { display: flex; flex-wrap: wrap; gap: 8px; }
.ship-chip { display: inline-flex; align-items: center; gap: 5px; font-size: 12px; font-weight: 700; background: var(--green-pale); color: var(--green-dark); padding: 6px 14px; border-radius: 100px; border: 1px solid var(--border); }

/* ── RATING ── */
.rating-summary { display: flex; align-items: center; gap: 16px; padding-bottom: 12px; border-bottom: 1px solid var(--border); margin-bottom: 12px; }
.rating-score { font-family: 'Playfair Display', serif; font-size: 44px; font-weight: 800; color: var(--text-dark); line-height: 1; }
.rating-stars { color: #f59e0b; font-size: 18px; margin-bottom: 4px; letter-spacing: 1px; }
.rating-count { font-size: 12px; color: var(--text-muted); }
.rating-empty { text-align: center; padding: 16px 0; color: var(--text-muted); }
.rating-empty i { font-size: 28px; display: block; margin-bottom: 8px; color: var(--border); }

@media (max-width: 768px) {
    .buyer-shell { padding: 16px; }
    .stats-row { grid-template-columns: repeat(2,1fr); }
    .profile-card-body { padding: 0 16px 20px; }
    .two-col { grid-template-columns: 1fr !important; }
}
</style>
@endpush

@section('content')
<div class="buyer-shell">

    {{-- Page Header --}}
    <div class="page-header">
        <div>
            <h1><i class="ti ti-store" style="font-size:22px;color:var(--green-main)"></i> Profil Toko</h1>
            <p>{{ $sellerProfile->nama_toko ?? 'Toko' }} · SEARA</p>
        </div>
        <div class="buyer-cta-row">
            @auth
                <a href="{{ route('chat.show', $seller->user_id) }}" class="btn-chat-green">
                    <i class="ti ti-message-circle"></i> Chat Petani
                </a>
            @else
                <a href="{{ route('login') }}" class="btn-chat-green">
                    <i class="ti ti-message-circle"></i> Chat Petani
                </a>
            @endauth

            @if($seller->user->no_whatsapp ?? null)
                <a href="https://wa.me/62{{ ltrim($seller->user->no_whatsapp, '0') }}?text=Halo%20{{ urlencode($sellerProfile->nama_toko) }}%2C%20saya%20melihat%20toko%20Anda%20di%20SEARA"
                   target="_blank" class="btn-wa-green">
                    <i class="ti ti-brand-whatsapp"></i> WhatsApp
                </a>
            @endif
        </div>
    </div>

    {{-- Profile Card (Banner + Avatar + Info) --}}
    <div class="profile-card">
        <div class="profile-banner">
            @if($sellerProfile->banner_toko ?? null)
                <img src="{{ asset('storage/' . $sellerProfile->banner_toko) }}" alt="Banner {{ $sellerProfile->nama_toko }}">
            @else
                🌿
            @endif
        </div>

        <div class="profile-card-body">
            <div class="avatar-wrap">
                <div class="profile-avatar">
                    @if($sellerProfile->foto_toko)
                        <img src="{{ asset('storage/' . $sellerProfile->foto_toko) }}" alt="{{ $sellerProfile->nama_toko }}">
                    @else
                        {{ strtoupper(substr($sellerProfile->nama_toko ?? 'T', 0, 2)) }}
                    @endif
                </div>
            </div>

            <div class="profile-name">{{ $sellerProfile->nama_toko ?? 'Nama Toko' }}</div>

            <div class="profile-badges">
                @if($sellerProfile->is_verified ?? false)
                    <span class="pbadge pbadge-verified">⭐ Petani Terverifikasi</span>
                @endif
                @if($sellerProfile->kategori_utama)
                    <span class="pbadge pbadge-cat"><i class="ti ti-tag" style="font-size:10px"></i> {{ $sellerProfile->kategori_utama }}</span>
                @endif
                @if($sellerProfile->is_open)
                    <span class="pbadge pbadge-open">● Toko Buka</span>
                @else
                    <span class="pbadge pbadge-closed">● Toko Tutup</span>
                @endif
            </div>

            @if($sellerProfile->deskripsi_toko)
                <p class="profile-desc">{{ $sellerProfile->deskripsi_toko }}</p>
            @endif

            <div class="profile-meta">
                @if($sellerProfile->kota_kabupaten)
                    <span class="pmeta-item">
                        <i class="ti ti-map-pin"></i>
                        {{ $sellerProfile->kota_kabupaten }}@if($sellerProfile->provinsi), {{ $sellerProfile->provinsi }}@endif
                    </span>
                @endif
                @if($sellerProfile->created_at)
                    <span class="pmeta-item">
                        <i class="ti ti-calendar"></i>
                        Bergabung {{ $sellerProfile->created_at->translatedFormat('M Y') }}
                    </span>
                @endif
            </div>
        </div>
    </div>

    {{-- Stats Row --}}
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-card-val">{{ $harvests->count() }}</div>
            <div class="stat-card-lbl">Produk Aktif</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-val">{{ $sellerProfile->total_transaksi ?? 0 }}</div>
            <div class="stat-card-lbl">Total Pesanan</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-val">{{ number_format($sellerProfile->rating ?? 0, 1) }}</div>
            <div class="stat-card-lbl">Rating Toko</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-val">
                @if($sellerProfile->is_open)
                    <span style="color:#16a34a">Buka</span>
                @else
                    <span style="color:#dc2626">Tutup</span>
                @endif
            </div>
            <div class="stat-card-lbl">Status Toko</div>
        </div>
    </div>

    {{-- Informasi Toko + Jam Operasional (2 kolom) --}}
    <div class="two-col" style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px;">

        {{-- Informasi Toko --}}
        <div class="section-card" style="margin-bottom:0">
            <div class="section-head">
                <h2><i class="ti ti-info-circle"></i> Informasi Toko</h2>
            </div>
            <div class="section-body">
                <div class="info-list">
                    <div class="info-item">
                        <div class="info-icon-wrap"><i class="ti ti-store"></i></div>
                        <div class="info-content">
                            <div class="info-lbl">Nama Toko</div>
                            <div class="info-val">{{ $sellerProfile->nama_toko ?? '-' }}</div>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-icon-wrap"><i class="ti ti-user"></i></div>
                        <div class="info-content">
                            <div class="info-lbl">Nama Petani</div>
                            <div class="info-val">{{ $seller->user->nama_lengkap ?? '-' }}</div>
                        </div>
                    </div>
                    @if($seller->user->no_whatsapp ?? null)
                    <div class="info-item">
                        <div class="info-icon-wrap"><i class="ti ti-brand-whatsapp"></i></div>
                        <div class="info-content">
                            <div class="info-lbl">WhatsApp</div>
                            <div class="info-val">{{ $seller->user->no_whatsapp }}</div>
                        </div>
                    </div>
                    @endif
                    @if($sellerProfile->kota_kabupaten || $sellerProfile->alamat_toko)
                    <div class="info-item">
                        <div class="info-icon-wrap"><i class="ti ti-map-pin"></i></div>
                        <div class="info-content">
                            <div class="info-lbl">Lokasi</div>
                            <div class="info-val">{{ $sellerProfile->kota_kabupaten ?? '' }}@if($sellerProfile->provinsi), {{ $sellerProfile->provinsi }}@endif</div>
                            @if($sellerProfile->alamat_toko)
                                <div class="info-sub">{{ $sellerProfile->alamat_toko }}</div>
                            @endif
                        </div>
                    </div>
                    @endif
                    @if($sellerProfile->verified_at ?? null)
                    <div class="info-item">
                        <div class="info-icon-wrap"><i class="ti ti-shield-check"></i></div>
                        <div class="info-content">
                            <div class="info-lbl">Verifikasi SEARA</div>
                            <div class="info-val" style="color:#16a34a">Terverifikasi {{ $sellerProfile->verified_at->translatedFormat('d M Y') }}</div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Jam Operasional --}}
        @if($sellerProfile->jam_operasional ?? null)
        @php
            $jamOps = is_array($sellerProfile->jam_operasional)
                ? $sellerProfile->jam_operasional
                : json_decode($sellerProfile->jam_operasional, true);
            $hariIni = strtolower(now()->locale('id')->dayName);
        @endphp
        <div class="section-card" style="margin-bottom:0">
            <div class="section-head">
                <h2><i class="ti ti-clock"></i> Jam Operasional</h2>
            </div>
            <div class="section-body">
                <div class="hours-grid">
                    @foreach($jamOps as $hari => $jam)
                        @php $isToday = $hari === $hariIni; @endphp
                        <div class="hour-item {{ $isToday ? 'today' : '' }}">
                            <div class="hour-day">
                                {{ ucfirst($hari) }}
                                @if($isToday)<span class="today-pip">Hari ini</span>@endif
                            </div>
                            <div class="hour-time">{{ $jam === 'Tutup' ? '-' : $jam }}</div>
                            <span class="hour-badge {{ $jam === 'Tutup' ? 'hour-closed' : 'hour-open' }}">
                                {{ $jam === 'Tutup' ? 'Tutup' : 'Buka' }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

    </div>

    {{-- Produk Tersedia --}}
    <div class="section-card">
        <div class="section-head">
            <h2><i class="ti ti-basket"></i> Produk Tersedia</h2>
            <span class="section-count">{{ $harvests->count() }} item</span>
        </div>
        <div class="section-body">
            @if($harvests->isEmpty())
                <div style="text-align:center;padding:28px 0;color:var(--text-muted);">
                    <i class="ti ti-seedling" style="font-size:36px;display:block;margin-bottom:10px;color:var(--border)"></i>
                    <p style="font-size:13px;font-weight:700;">Belum ada produk tersedia.</p>
                </div>
            @else
                <div class="product-grid">
                    @foreach($harvests->take(8) as $harvest)
                        <a href="{{ route('buyer.product.show', $harvest->id) }}" class="prod-card">
                            <div class="prod-thumb">
                                @if($harvest->product->foto ?? null)
                                    <img src="{{ asset('storage/' . $harvest->product->foto) }}" alt="{{ $harvest->product->nama_produk }}">
                                @else
                                    {{ $harvest->product->emoji ?? '🌿' }}
                                @endif
                            </div>
                            <div class="prod-name">{{ $harvest->product->nama_produk ?? '-' }}</div>
                            <div class="prod-price">Rp {{ number_format($harvest->price_per_unit, 0, ',', '.') }}/{{ $harvest->product->satuan ?? 'kg' }}</div>
                            <div class="prod-stock">Stok: {{ $harvest->remaining_stock }} {{ $harvest->product->satuan ?? 'kg' }}</div>
                            @if($harvest->is_organic ?? false)
                                <span class="prod-organic"><i class="ti ti-leaf" style="font-size:9px"></i> Organik</span>
                            @endif
                        </a>
                    @endforeach

                    @if($harvests->count() > 8)
                        <a href="{{ route('explore', ['q' => $sellerProfile->nama_toko]) }}" class="prod-more">
                            <i class="ti ti-dots"></i>
                            <span>+{{ $harvests->count() - 8 }} produk lagi</span>
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>

    {{-- Ulasan --}}
    <div class="section-card">
        <div class="section-head">
            <h2><i class="ti ti-star"></i> Ulasan Pembeli</h2>
            <span class="section-count">{{ $sellerProfile->total_ulasan ?? 0 }} ulasan</span>
        </div>
        <div class="section-body">
            @if(($sellerProfile->rating ?? 0) > 0)
                <div class="rating-summary">
                    <div class="rating-score">{{ number_format($sellerProfile->rating, 1) }}</div>
                    <div>
                        <div class="rating-stars">
                            @for($i = 1; $i <= 5; $i++)
                                {{ $i <= round($sellerProfile->rating) ? '★' : '☆' }}
                            @endfor
                        </div>
                        <div class="rating-count">Berdasarkan {{ $sellerProfile->total_ulasan ?? 0 }} ulasan pembeli</div>
                    </div>
                </div>
            @endif
            <div class="rating-empty">
                <i class="ti ti-message-circle"></i>
                <p style="font-size:13px;">Detail ulasan belum tersedia. Periksa kembali nanti.</p>
            </div>
        </div>
    </div>

    {{-- Layanan Pengiriman --}}
    @if($sellerProfile->metode_pengiriman ?? null)
    @php
        $metode = is_array($sellerProfile->metode_pengiriman)
            ? $sellerProfile->metode_pengiriman
            : json_decode($sellerProfile->metode_pengiriman, true);
    @endphp
    <div class="section-card">
        <div class="section-head">
            <h2><i class="ti ti-truck"></i> Layanan Pengiriman</h2>
        </div>
        <div class="section-body">
            <div class="ship-chips">
                @foreach($metode as $m)
                    <span class="ship-chip"><i class="ti ti-check"></i> {{ $m }}</span>
                @endforeach
            </div>
        </div>
    </div>
    @endif

</div>
@endsection