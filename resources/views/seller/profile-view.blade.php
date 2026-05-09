@extends('layouts.app')

@section('title', 'Profil Toko — SEARA')

@section('hide-footer')@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<style>
    .seller-wrap { display: flex; min-height: calc(100vh - 60px); }
    .seller-main { flex: 1; padding: 28px; overflow-x: hidden; background: var(--green-bg); }

    /* ── PAGE HEADER ── */
    .page-header {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 24px;
    }
    .page-header h1 {
        font-family: 'Playfair Display', serif; font-size: 24px;
        font-weight: 700; color: var(--text-dark);
    }
    .page-header p { font-size: 13px; color: var(--text-muted); margin-top: 3px; font-weight: 600; }

    /* ── HERO BANNER ── */
    .profile-banner {
        width: 100%; height: 160px; 
        object-fit: cover; background: linear-gradient(135deg, var(--green-dark), var(--green-main));
        display: flex; align-items: center; justify-content: center; font-size: 48px;
        overflow: hidden; position: relative;
    }
    .profile-banner img { width: 100%; height: 100%; object-fit: cover; }

    /* ── PROFILE CARD ── */
    .profile-card {
        background: white; border: 1px solid var(--border);
        border-radius: 16px; margin-bottom: 20px; margin-top: 20px;
        box-shadow: var(--shadow-sm);
    }
    .profile-card-body { padding: 0 28px 24px; }

    .avatar-wrap {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    margin-top: -52px;
    margin-bottom: 16px;
    position: relative;
    z-index: 5;
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

    .profile-edit-btn {
        display: inline-flex; align-items: center; gap: 7px;
        padding: 9px 18px; border-radius: 10px;
        background: var(--green-pale); border: 1.5px solid var(--border);
        font-family: 'Nunito', sans-serif; font-size: 13px; font-weight: 700;
        color: var(--green-dark); text-decoration: none; cursor: pointer;
        transition: all .2s; margin-bottom: 4px;
    }
    .profile-edit-btn:hover { background: #d1fae5; border-color: var(--green-main); }

    .profile-name {
        font-family: 'Playfair Display', serif; font-size: 22px;
        font-weight: 700; color: var(--text-dark); margin-bottom: 6px;
    }
    .profile-badges { display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 10px; }
    .pbadge {
        display: inline-flex; align-items: center; gap: 4px;
        font-size: 11px; font-weight: 700; padding: 4px 10px;
        border-radius: 100px;
    }
    .pbadge-verified { background: #fffbeb; color: #92400e; border: 1px solid #fde68a; }
    .pbadge-cat { background: var(--green-pale); color: var(--green-dark); border: 1px solid var(--border); }
    .pbadge-open { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }
    .pbadge-closed { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }

    .profile-desc { font-size: 14px; color: var(--text-mid); line-height: 1.7; margin-bottom: 14px; }
    .profile-meta { display: flex; flex-wrap: wrap; gap: 16px; }
    .pmeta-item { display: flex; align-items: center; gap: 6px; font-size: 13px; color: var(--text-muted); font-weight: 600; }
    .pmeta-item i { color: var(--green-main); }

    /* ── STATS ROW ── */
    .stats-row {
        display: grid; grid-template-columns: repeat(4, 1fr);
        gap: 14px; margin-bottom: 20px;
    }
    .stat-card {
        background: white; border: 1px solid var(--border);
        border-radius: 12px; padding: 18px 16px; text-align: center;
        box-shadow: var(--shadow-sm);
    }
    .stat-card-val {
        font-family: 'Playfair Display', serif; font-size: 26px;
        font-weight: 700; color: var(--green-dark); line-height: 1;
        margin-bottom: 4px;
    }
    .stat-card-lbl { font-size: 11px; color: var(--text-muted); font-weight: 700; text-transform: uppercase; letter-spacing: .5px; }

    /* ── SECTION CARD ── */
    .section-card { background: white; border: 1px solid var(--border); border-radius: 14px; overflow: hidden; margin-bottom: 16px; }
    .section-head { padding: 16px 20px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; }
    .section-head h2 { font-size: 14px; font-weight: 900; color: var(--text-dark); display: flex; align-items: center; gap: 8px; }
    .section-head h2 i { color: var(--green-main); }
    .section-body { padding: 20px; }

    /* ── INFO LIST ── */
    .info-list { display: flex; flex-direction: column; gap: 2px; }
    .info-item { display: flex; align-items: flex-start; gap: 12px; padding: 10px 0; border-bottom: 1px solid var(--green-pale); }
    .info-item:last-child { border-bottom: none; }
    .info-icon-wrap { width: 36px; height: 36px; border-radius: 9px; background: var(--green-pale); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .info-icon-wrap i { color: var(--green-dark); font-size: 14px; }
    .info-content { flex: 1; }
    .info-lbl { font-size: 11px; color: var(--text-muted); font-weight: 700; text-transform: uppercase; letter-spacing: .4px; margin-bottom: 2px; }
    .info-val { font-size: 13px; color: var(--text-dark); font-weight: 700; }
    .info-sub { font-size: 12px; color: var(--text-muted); margin-top: 2px; }

    /* ── PRODUCT GRID ── */
    .product-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(130px, 1fr)); gap: 10px; }
    .prod-card { background: var(--green-bg); border: 1px solid var(--border); border-radius: 10px; padding: 12px; display: block; color: inherit; text-decoration: none; transition: transform .15s, box-shadow .15s; }
    .prod-card:hover { transform: translateY(-2px); box-shadow: var(--shadow-md); }
    .prod-thumb { width: 100%; aspect-ratio: 1; background: var(--green-pale); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 32px; margin-bottom: 8px; overflow: hidden; }
    .prod-thumb img { width: 100%; height: 100%; object-fit: cover; }
    .prod-name { font-size: 12px; font-weight: 700; color: var(--text-dark); margin-bottom: 3px; line-height: 1.3; }
    .prod-price { font-size: 12px; color: var(--accent); font-weight: 800; }
    .prod-stock { font-size: 11px; color: var(--text-muted); margin-top: 3px; }
    .prod-organic { display: inline-flex; align-items: center; gap: 3px; font-size: 10px; font-weight: 700; background: var(--green-pale); color: var(--green-dark); padding: 2px 7px; border-radius: 100px; margin-top: 5px; }

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

    /* ── ALERT ── */
    .alert { padding: 12px 18px; border-radius: 10px; font-size: 13px; font-weight: 700; margin-bottom: 18px; display: flex; align-items: center; gap: 10px; }
    .alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: var(--green-dark); }

    /* ── STATUS TOGGLE BTN ── */
    .btn-green { padding: 9px 20px; background: linear-gradient(135deg, var(--green-mid), var(--green-main)); border: none; border-radius: 10px; font-family: 'Nunito', sans-serif; font-weight: 800; font-size: 13px; color: white; cursor: pointer; transition: all .2s; display: inline-flex; align-items: center; gap: 7px; }
    .btn-green:hover { transform: translateY(-1px); box-shadow: var(--shadow-md); }
    .btn-danger { padding: 9px 20px; background: #fef2f2; border: 1.5px solid #fecaca; border-radius: 10px; font-family: 'Nunito', sans-serif; font-weight: 800; font-size: 13px; color: #991b1b; cursor: pointer; transition: all .2s; display: inline-flex; align-items: center; gap: 7px; }
    .btn-danger:hover { background: #fee2e2; }

    @media(max-width: 768px) {
        .seller-main { padding: 16px; }
        .stats-row { grid-template-columns: repeat(2,1fr); }
    }
</style>
@endpush

@section('content')
<div class="seller-wrap">
    @include('partials.seller_sidebar')

    <main class="seller-main">

        @if(session('success'))
            <div class="alert alert-success"><i class="fa-solid fa-circle-check"></i> {{ session('success') }}</div>
        @endif

        {{-- Page Header --}}
        <div class="page-header">
            <div>
                <h1>Profil Toko <i class="fa-solid fa-store" style="font-size:20px;color:var(--green-main)"></i></h1>
                <p>Tampilan publik toko Anda di SEARA</p>
            </div>
            <div style="display:flex;gap:10px;align-items:center">
                {{-- Toggle buka/tutup --}}
                <form method="POST" action="{{ route('seller.profile.toggle') }}">
                    @csrf
                    @if($sellerProfile->is_open)
                        <button type="submit" class="btn-danger">
                            <i class="fa-solid fa-power-off"></i> Tutup Toko
                        </button>
                    @else
                        <button type="submit" class="btn-green">
                            <i class="fa-solid fa-power-off"></i> Buka Toko
                        </button>
                    @endif
                </form>
                <a href="{{ route('seller.profile.edit') }}" class="profile-edit-btn">
                    <i class="fa-solid fa-pen"></i> Edit Profil
                </a>
            </div>
        </div>

        {{-- Profile Card --}}
        <div class="profile-card">
            {{-- Banner --}}
            <div class="profile-banner" style="border-radius:16px 16px 0 0;overflow:hidden;">
                @if($sellerProfile->banner_toko)
                    <img src="{{ asset('storage/' . $sellerProfile->banner_toko) }}" alt="Banner">
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
                    @if($sellerProfile->slug_toko)
                        <a href="{{ route('store.show', $sellerProfile->slug_toko) }}" target="_blank"
                           style="font-size:12px;color:var(--green-main);font-weight:700;display:flex;align-items:center;gap:5px;text-decoration:none;margin-bottom:4px;">
                            <i class="fa-solid fa-arrow-up-right-from-square"></i> Lihat sebagai pembeli
                        </a>
                    @endif
                </div>

                <div class="profile-name">{{ $sellerProfile->nama_toko ?? 'Nama Toko' }}</div>

                <div class="profile-badges">
                    @if($sellerProfile->is_verified)
                        <span class="pbadge pbadge-verified">⭐ Petani Terverifikasi</span>
                    @endif
                    @if($sellerProfile->kategori_utama)
                        <span class="pbadge pbadge-cat"><i class="fa-solid fa-tag" style="font-size:10px"></i> {{ $sellerProfile->kategori_utama }}</span>
                    @endif
                    @if($sellerProfile->is_open)
                        <span class="pbadge pbadge-open">● Toko Buka</span>
                    @else
                        <span class="pbadge pbadge-closed">● Toko Tutup</span>
                    @endif
                </div>

                @if($sellerProfile->deskripsi_toko)
                    <p class="profile-desc">{{ $sellerProfile->deskripsi_toko }}</p>
                @else
                    <p class="profile-desc" style="color:var(--text-muted);font-style:italic">Belum ada deskripsi toko. <a href="{{ route('seller.profile.edit') }}" style="color:var(--green-main)">Tambahkan sekarang →</a></p>
                @endif

                <div class="profile-meta">
                    @if($sellerProfile->kota_kabupaten)
                        <span class="pmeta-item"><i class="fa-solid fa-map-pin"></i> {{ $sellerProfile->kota_kabupaten }}@if($sellerProfile->provinsi), {{ $sellerProfile->provinsi }}@endif</span>
                    @endif
                    @if($sellerProfile->created_at)
                        <span class="pmeta-item"><i class="fa-solid fa-calendar"></i> Bergabung {{ $sellerProfile->created_at->translatedFormat('M Y') }}</span>
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

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">

            {{-- Info Toko --}}
            <div class="section-card">
                <div class="section-head">
                    <h2><i class="fa-solid fa-circle-info"></i> Informasi Toko</h2>
                    <a href="{{ route('seller.profile.edit') }}" style="font-size:12px;color:var(--green-main);font-weight:700;text-decoration:none;">Edit →</a>
                </div>
                <div class="section-body">
                    <div class="info-list">
                        <div class="info-item">
                            <div class="info-icon-wrap"><i class="fa-solid fa-store"></i></div>
                            <div class="info-content">
                                <div class="info-lbl">Nama Toko</div>
                                <div class="info-val">{{ $sellerProfile->nama_toko ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-icon-wrap"><i class="fa-solid fa-user"></i></div>
                            <div class="info-content">
                                <div class="info-lbl">Nama Petani</div>
                                <div class="info-val">{{ auth()->user()->nama_lengkap ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-icon-wrap"><i class="fa-solid fa-envelope"></i></div>
                            <div class="info-content">
                                <div class="info-lbl">Email</div>
                                <div class="info-val">{{ auth()->user()->email ?? '-' }}</div>
                            </div>
                        </div>
                        @if(auth()->user()->no_whatsapp ?? null)
                        <div class="info-item">
                            <div class="info-icon-wrap"><i class="fa-brands fa-whatsapp"></i></div>
                            <div class="info-content">
                                <div class="info-lbl">WhatsApp</div>
                                <div class="info-val">{{ auth()->user()->no_whatsapp }}</div>
                            </div>
                        </div>
                        @endif
                        <div class="info-item">
                            <div class="info-icon-wrap"><i class="fa-solid fa-map-pin"></i></div>
                            <div class="info-content">
                                <div class="info-lbl">Lokasi</div>
                                <div class="info-val">{{ $sellerProfile->kota_kabupaten ?? '-' }}</div>
                                @if($sellerProfile->provinsi)
                                    <div class="info-sub">{{ $sellerProfile->provinsi }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Jam Operasional --}}
            @if($sellerProfile->jam_operasional)
            @php
                $jamOps = is_array($sellerProfile->jam_operasional)
                    ? $sellerProfile->jam_operasional
                    : json_decode($sellerProfile->jam_operasional, true);
                $hariIni = strtolower(now()->locale('id')->dayName);
            @endphp
            <div class="section-card">
                <div class="section-head">
                    <h2><i class="fa-solid fa-clock"></i> Jam Operasional</h2>
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

        {{-- Produk Aktif --}}
        <div class="section-card">
            <div class="section-head">
                <h2><i class="fa-solid fa-basket-shopping"></i> Produk Aktif</h2>
                <a href="{{ route('seller.products.index') }}" style="font-size:12px;color:var(--green-main);font-weight:700;text-decoration:none;">Kelola Produk →</a>
            </div>
            <div class="section-body">
                @if($harvests->isEmpty())
                    <div style="text-align:center;padding:24px 0;color:var(--text-muted);">
                        <i class="fa-solid fa-seedling" style="font-size:32px;margin-bottom:10px;display:block;color:var(--border)"></i>
                        <p style="font-size:13px;font-weight:700;">Belum ada produk aktif.</p>
                        <a href="{{ route('seller.products.index') }}" style="font-size:13px;color:var(--green-main);font-weight:700;">Tambah produk sekarang →</a>
                    </div>
                @else
                    <div class="product-grid">
                        @foreach($harvests->take(6) as $harvest)
                            <div class="prod-card">
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
                                    <span class="prod-organic"><i class="fa-solid fa-leaf" style="font-size:9px"></i> Organik</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                    @if($harvests->count() > 6)
                        <div style="text-align:center;margin-top:16px;">
                            <a href="{{ route('seller.products.index') }}" style="font-size:13px;color:var(--green-main);font-weight:700;text-decoration:none;">
                                Lihat semua {{ $harvests->count() }} produk →
                            </a>
                        </div>
                    @endif
                @endif
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
                <h2><i class="fa-solid fa-truck"></i> Layanan Pengiriman</h2>
            </div>
            <div class="section-body">
                <div class="ship-chips">
                    @foreach($metode as $m)
                        <span class="ship-chip"><i class="fa-solid fa-check"></i> {{ $m }}</span>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

    </main>
</div>
@endsection