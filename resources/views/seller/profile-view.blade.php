<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Toko – SEARA</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Nunito:wght@400;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('assets/LOGO_FIKS_LIGHT.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        :root {
            --green-dark: #1a4731;
            --green-main: #2d8653;
            --green-mid: #3dba7e;
            --green-light: #52dda0;
            --green-pale: #f0fdf6;
            --green-bg: #f5f9f6;
            --accent: #e05c2e;
            --accent-soft: #fff0eb;
            --yellow: #f5a623;
            --yellow-soft: #fffbeb;
            --blue: #2563eb;
            --blue-soft: #eff6ff;
            --text-dark: #0f2419;
            --text-mid: #3d5c49;
            --text-muted: #7a9585;
            --border: #e2ece7;
            --white: #ffffff;
            --bg: #f5f9f6;
            --r: 14px;
            --shadow-sm: 0 1px 4px rgba(0, 0, 0, .06);
            --shadow-md: 0 4px 18px rgba(0, 0, 0, .09);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background: var(--bg);
            font-family: 'Nunito', sans-serif;
            color: var(--text-dark);
        }

        /* ── LAYOUT ── */
        .seller-wrap {
            display: flex;
            min-height: 100vh;
        }

        .seller-main {
            flex: 1;
            padding: 24px;
            overflow-x: hidden;
        }

        /* ── PAGE HEADER ── */
        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 22px;
        }

        .page-header-left h1 {
            font-family: 'Playfair Display', serif;
            font-size: 26px;
            font-weight: 700;
            color: var(--text-dark);
        }

        .page-header-left p {
            font-size: 13px;
            color: var(--text-muted);
            margin-top: 3px;
            font-weight: 600;
        }

        .page-header-right {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        /* ── BUTTONS ── */
        .btn-green {
            padding: 9px 18px;
            background: linear-gradient(135deg, var(--green-mid), var(--green-main));
            border: none;
            border-radius: 10px;
            font-family: 'Nunito', sans-serif;
            font-weight: 800;
            font-size: 13px;
            color: white;
            cursor: pointer;
            transition: all .2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 4px 12px rgba(61, 186, 126, .25);
            text-decoration: none;
        }

        .btn-green:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(61, 186, 126, .3);
        }

        .btn-outline {
            padding: 9px 18px;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            background: white;
            font-family: 'Nunito', sans-serif;
            font-weight: 700;
            font-size: 13px;
            color: var(--text-mid);
            cursor: pointer;
            transition: all .2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
        }

        .btn-outline:hover {
            border-color: var(--green-main);
            color: var(--green-dark);
        }

        .btn-danger {
            padding: 9px 18px;
            background: #fef2f2;
            border: 1.5px solid #fecaca;
            border-radius: 10px;
            font-family: 'Nunito', sans-serif;
            font-weight: 800;
            font-size: 13px;
            color: #991b1b;
            cursor: pointer;
            transition: all .2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-danger:hover {
            background: #fee2e2;
        }

        /* ── ALERT ── */
        .alert {
            padding: 12px 18px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: var(--green-dark);
        }

        /* ── HERO BANNER ── */
        .profile-banner {
            width: 100%;
            height: 160px;
            border-radius: 16px 16px 0 0;
            overflow: hidden;
            background: linear-gradient(135deg, var(--green-dark), var(--green-main));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 48px;
            position: relative;
        }

        .profile-banner img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* ── PROFILE CARD ── */
        .profile-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 16px;
            margin-bottom: 20px;
            box-shadow: var(--shadow-sm);
        }

        .profile-card-body {
            padding: 0 28px 24px;
        }

        .avatar-wrap {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            margin-top: -44px;
            margin-bottom: 16px;
            position: relative;
            z-index: 5;
        }

        .profile-avatar {
            width: 88px;
            height: 88px;
            border-radius: 50%;
            border: 4px solid white;
            background: var(--green-mid);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            font-weight: 700;
            color: white;
            overflow: hidden;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(0, 0, 0, .15);
        }

        .profile-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-name {
            font-family: 'Playfair Display', serif;
            font-size: 22px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 6px;
        }

        .profile-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-bottom: 10px;
        }

        .pbadge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 11px;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 100px;
        }

        .pbadge-verified {
            background: #fffbeb;
            color: #92400e;
            border: 1px solid #fde68a;
        }

        .pbadge-cat {
            background: var(--green-pale);
            color: var(--green-dark);
            border: 1px solid var(--border);
        }

        .pbadge-open {
            background: #f0fdf4;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .pbadge-closed {
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .profile-desc {
            font-size: 14px;
            color: var(--text-mid);
            line-height: 1.7;
            margin-bottom: 14px;
        }

        .profile-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
        }

        .pmeta-item {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            color: var(--text-muted);
            font-weight: 600;
        }

        .pmeta-item i {
            color: var(--green-main);
        }

        /* ── STATS BAR ── */
        .stats-bar {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
            margin-bottom: 22px;
        }

        .stat-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: var(--r);
            padding: 16px 18px;
        }

        .stat-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            margin-bottom: 10px;
        }

        .stat-icon.green {
            background: var(--green-pale);
            color: var(--green-dark);
        }

        .stat-icon.orange {
            background: var(--accent-soft);
            color: var(--accent);
        }

        .stat-icon.blue {
            background: var(--blue-soft);
            color: var(--blue);
        }

        .stat-icon.yellow {
            background: var(--yellow-soft);
            color: #b45309;
        }

        .stat-label {
            font-size: 10px;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: .8px;
            margin-bottom: 3px;
        }

        .stat-value {
            font-size: 20px;
            font-weight: 900;
            color: var(--text-dark);
        }

        /* ── SECTION CARD ── */
        .section-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: var(--r);
            overflow: hidden;
            margin-bottom: 16px;
        }

        .section-head {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .section-head h2 {
            font-size: 14px;
            font-weight: 900;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .section-head h2 i {
            color: var(--green-main);
        }

        .section-body {
            padding: 20px;
        }

        /* ── INFO LIST ── */
        .info-list {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .info-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 10px 0;
            border-bottom: 1px solid var(--green-pale);
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-icon-wrap {
            width: 36px;
            height: 36px;
            border-radius: 9px;
            background: var(--green-pale);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .info-icon-wrap i {
            color: var(--green-dark);
            font-size: 14px;
        }

        .info-content {
            flex: 1;
        }

        .info-lbl {
            font-size: 11px;
            color: var(--text-muted);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .4px;
            margin-bottom: 2px;
        }

        .info-val {
            font-size: 13px;
            color: var(--text-dark);
            font-weight: 700;
        }

        .info-sub {
            font-size: 12px;
            color: var(--text-muted);
            margin-top: 2px;
        }

        /* ── TWO-COL GRID ── */
        .two-col {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 0;
        }

        /* ── PRODUCT GRID ── */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
            gap: 10px;
        }

        .prod-card {
            background: var(--green-bg);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 12px;
            display: block;
            color: inherit;
            text-decoration: none;
            transition: transform .15s, box-shadow .15s;
        }

        .prod-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .prod-thumb {
            width: 100%;
            aspect-ratio: 1;
            background: var(--green-pale);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            margin-bottom: 8px;
            overflow: hidden;
        }

        .prod-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .prod-name {
            font-size: 12px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 3px;
            line-height: 1.3;
        }

        .prod-price {
            font-size: 12px;
            color: var(--accent);
            font-weight: 800;
        }

        .prod-stock {
            font-size: 11px;
            color: var(--text-muted);
            margin-top: 3px;
        }

        .prod-organic {
            display: inline-flex;
            align-items: center;
            gap: 3px;
            font-size: 10px;
            font-weight: 700;
            background: var(--green-pale);
            color: var(--green-dark);
            padding: 2px 7px;
            border-radius: 100px;
            margin-top: 5px;
        }

        /* ── HOURS GRID ── */
        .hours-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
            gap: 8px;
        }

        .hour-item {
            background: var(--green-bg);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 10px 12px;
        }

        .hour-item.today {
            background: var(--green-pale);
            border-color: var(--green-light);
        }

        .hour-day {
            font-size: 12px;
            font-weight: 800;
            color: var(--text-mid);
            margin-bottom: 2px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .hour-item.today .hour-day {
            color: var(--green-dark);
        }

        .today-pip {
            font-size: 9px;
            background: var(--green-main);
            color: #fff;
            padding: 1px 6px;
            border-radius: 100px;
            font-weight: 700;
        }

        .hour-time {
            font-size: 12px;
            color: var(--text-muted);
            font-weight: 600;
        }

        .hour-badge {
            display: inline-block;
            font-size: 10px;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 100px;
            margin-top: 5px;
        }

        .hour-open {
            background: var(--green-pale);
            color: var(--green-dark);
        }

        .hour-closed {
            background: #f4f4f4;
            color: var(--text-muted);
        }

        /* ── SHIP CHIPS ── */
        .ship-chips {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .ship-chip {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 12px;
            font-weight: 700;
            background: var(--green-pale);
            color: var(--green-dark);
            padding: 6px 14px;
            border-radius: 100px;
            border: 1px solid var(--border);
        }

        /* ── ANIMATIONS ── */
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(14px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .anim-1 {
            animation: fadeUp .45s ease both;
        }

        .anim-2 {
            animation: fadeUp .45s .07s ease both;
        }

        .anim-3 {
            animation: fadeUp .45s .14s ease both;
        }

        @media (max-width: 768px) {
            .seller-main {
                padding: 16px;
            }

            .stats-bar {
                grid-template-columns: repeat(2, 1fr);
            }

            .two-col {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    <div class="seller-wrap">

        {{-- ══ SIDEBAR ══ --}}
        @include('partials.seller_sidebar')

        {{-- ══ MAIN ══ --}}
        <main class="seller-main">

            @if(session('success'))
                <div class="alert alert-success anim-1">
                    <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
                </div>
            @endif

            {{-- Page Header --}}
            <div class="page-header anim-1">
                <div class="page-header-left">
                    <h1>Profil Toko <i class="fa-solid fa-store" style="font-size:22px;color:var(--green-main)"></i>
                    </h1>
                    <p>Tampilan publik toko Anda di SEARA</p>
                </div>
                <div class="page-header-right">
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
                    <a href="{{ route('seller.profile.edit') }}" class="btn-outline">
                        <i class="fa-solid fa-pen"></i> Edit Profil
                    </a>
                </div>
            </div>

            {{-- Profile Card --}}
            <div class="profile-card anim-2">
                {{-- Banner --}}
                <div class="profile-banner">
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
                                <img src="{{ asset('storage/' . $sellerProfile->foto_toko) }}"
                                    alt="{{ $sellerProfile->nama_toko }}">
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
                            <span class="pbadge pbadge-cat"><i class="fa-solid fa-tag" style="font-size:10px"></i>
                                {{ $sellerProfile->kategori_utama }}</span>
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
                        <p class="profile-desc" style="color:var(--text-muted);font-style:italic">
                            Belum ada deskripsi toko.
                            <a href="{{ route('seller.profile.edit') }}" style="color:var(--green-main)">Tambahkan sekarang
                                →</a>
                        </p>
                    @endif

                    <div class="profile-meta">
                        @if($sellerProfile->kota_kabupaten)
                            <span class="pmeta-item">
                                <i class="fa-solid fa-map-pin"></i>
                                {{ $sellerProfile->kota_kabupaten }}@if($sellerProfile->provinsi),
                                {{ $sellerProfile->provinsi }}@endif
                            </span>
                        @endif
                        @if($sellerProfile->created_at)
                            <span class="pmeta-item">
                                <i class="fa-solid fa-calendar"></i>
                                Bergabung {{ $sellerProfile->created_at->translatedFormat('M Y') }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Stats Bar --}}
            <div class="stats-bar anim-2">
                <div class="stat-card">
                    <div class="stat-icon green"><i class="fa-solid fa-boxes-stacked"></i></div>
                    <div class="stat-label">Produk Aktif</div>
                    <div class="stat-value">{{ $harvests->count() }}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon blue"><i class="fa-solid fa-bag-shopping"></i></div>
                    <div class="stat-label">Total Pesanan</div>
                    <div class="stat-value">{{ $sellerProfile->total_transaksi ?? 0 }}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon yellow"><i class="fa-solid fa-star"></i></div>
                    <div class="stat-label">Rating Toko</div>
                    <div class="stat-value">{{ number_format($sellerProfile->rating ?? 0, 1) }}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon {{ $sellerProfile->is_open ? 'green' : 'orange' }}">
                        <i class="fa-solid fa-power-off"></i>
                    </div>
                    <div class="stat-label">Status Toko</div>
                    <div class="stat-value"
                        style="font-size:16px;color:{{ $sellerProfile->is_open ? '#16a34a' : '#dc2626' }}">
                        {{ $sellerProfile->is_open ? 'Buka' : 'Tutup' }}
                    </div>
                </div>
            </div>

            {{-- Info Toko + Jam Operasional --}}
            <div class="two-col anim-3" style="margin-bottom:16px;">

                {{-- Info Toko --}}
                <div class="section-card" style="margin-bottom:0;">
                    <div class="section-head">
                        <h2><i class="fa-solid fa-circle-info"></i> Informasi Toko</h2>
                        <a href="{{ route('seller.profile.edit') }}"
                            style="font-size:12px;color:var(--green-main);font-weight:700;text-decoration:none;">Edit
                            →</a>
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
                    <div class="section-card" style="margin-bottom:0;">
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
            <div class="section-card anim-3">
                <div class="section-head">
                    <h2><i class="fa-solid fa-basket-shopping"></i> Produk Aktif</h2>
                    <a href="{{ route('seller.products.index') }}"
                        style="font-size:12px;color:var(--green-main);font-weight:700;text-decoration:none;">Kelola
                        Produk →</a>
                </div>
                <div class="section-body">
                    @if($harvests->isEmpty())
                        <div style="text-align:center;padding:24px 0;color:var(--text-muted);">
                            <i class="fa-solid fa-seedling"
                                style="font-size:32px;margin-bottom:10px;display:block;color:var(--border)"></i>
                            <p style="font-size:13px;font-weight:700;">Belum ada produk aktif.</p>
                            <a href="{{ route('seller.products.index') }}"
                                style="font-size:13px;color:var(--green-main);font-weight:700;">Tambah produk sekarang →</a>
                        </div>
                    @else
                        <div class="product-grid">
                            @foreach($harvests->take(6) as $harvest)
                                <div class="prod-card">
                                    <div class="prod-thumb">
                                        @if($harvest->product->foto ?? null)
                                            <img src="{{ asset('storage/' . $harvest->product->foto) }}"
                                                alt="{{ $harvest->product->nama_produk }}">
                                        @else
                                            {{ $harvest->product->emoji ?? '🌿' }}
                                        @endif
                                    </div>
                                    <div class="prod-name">{{ $harvest->product->nama_produk ?? '-' }}</div>
                                    <div class="prod-price">Rp
                                        {{ number_format($harvest->price_per_unit, 0, ',', '.') }}/{{ $harvest->product->satuan ?? 'kg' }}
                                    </div>
                                    <div class="prod-stock">Stok: {{ $harvest->remaining_stock }}
                                        {{ $harvest->product->satuan ?? 'kg' }}</div>
                                    @if($harvest->is_organic ?? false)
                                        <span class="prod-organic"><i class="fa-solid fa-leaf" style="font-size:9px"></i>
                                            Organik</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        @if($harvests->count() > 6)
                            <div style="text-align:center;margin-top:16px;">
                                <a href="{{ route('seller.products.index') }}"
                                    style="font-size:13px;color:var(--green-main);font-weight:700;text-decoration:none;">
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
                <div class="section-card anim-3">
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

            {{-- Auto dismiss alert --}}
            @if(session('success'))
                <script>
                    setTimeout(() => {
                        document.querySelectorAll('.alert').forEach(el => {
                            el.style.transition = 'opacity .5s';
                            el.style.opacity = '0';
                        });
                    }, 4000);
                </script>
            @endif

        </main>
    </div>

</body>

</html>