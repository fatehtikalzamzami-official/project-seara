@php
    $activeTab         = $activeTab         ?? 'ringkasan';
    $statusDistribusi  = $statusDistribusi  ?? collect();
    $pelangganTerbaik  = $pelangganTerbaik  ?? collect();
    $kategoryBreakdown = $kategoryBreakdown ?? collect();
    $grafikHarianData  = $grafikHarianData  ?? [];
    $totalDibatalkan   = $totalDibatalkan   ?? 0;
    $prevPendapatan    = $prevPendapatan    ?? 0;
    $growthPersen      = $growthPersen      ?? 0;
    $grafikData        = $grafikData        ?? [];
    $produkTerlaris    = $produkTerlaris    ?? collect();
    $totalPendapatan   = $totalPendapatan   ?? 0;
    $totalOrder        = $totalOrder        ?? 0;
    $totalItemTerjual  = $totalItemTerjual  ?? 0;
    $rataRataOrder     = $rataRataOrder     ?? 0;
    $periode           = $periode           ?? 'bulan_ini';
    $filterStatus      = $filterStatus      ?? '';
    $startDate         = $startDate         ?? now()->startOfMonth();
    $endDate           = $endDate           ?? now();
    $riwayat           = $riwayat           ?? collect();
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan – SEARA</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('assets/LOGO_FIKS_LIGHT.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        :root {
            --green-dark:  #1a4731;
            --green-main:  #2d8653;
            --green-mid:   #3dba7e;
            --green-light: #52dda0;
            --green-pale:  #f0fdf6;
            --accent:      #e05c2e;
            --accent-soft: #fff0eb;
            --yellow:      #f5a623;
            --yellow-soft: #fffbeb;
            --blue:        #2563eb;
            --blue-soft:   #eff6ff;
            --purple:      #7c3aed;
            --purple-soft: #f5f3ff;
            --red:         #dc2626;
            --red-soft:    #fef2f2;
            --teal:        #0d9488;
            --teal-soft:   #f0fdfa;
            --text-dark:   #0f2419;
            --text-mid:    #3d5c49;
            --text-muted:  #7a9585;
            --border:      #e2ece7;
            --white:       #ffffff;
            --bg:          #f5f9f6;
            --r:           14px;
            --shadow-sm:   0 1px 4px rgba(0,0,0,.06);
            --shadow-md:   0 4px 18px rgba(0,0,0,.09);
        }
        *{box-sizing:border-box;margin:0;padding:0}
        body{background:var(--bg);font-family:'Nunito',sans-serif;color:var(--text-dark)}
        .seller-wrap{display:flex;min-height:100vh}
        .seller-main{flex:1;padding:24px;overflow-x:hidden}

        /* ── Page header ─────────────────────────────────────────────── */
        .page-header{display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:22px;gap:16px;flex-wrap:wrap}
        .page-header-left h1{font-family:'Playfair Display',serif;font-size:26px;font-weight:700;color:var(--text-dark)}
        .page-header-left p{font-size:13px;color:var(--text-muted);margin-top:3px;font-weight:600}
        .page-header-right{display:flex;gap:10px;align-items:center;flex-wrap:wrap}
        .btn-green{padding:9px 18px;background:linear-gradient(135deg,var(--green-mid),var(--green-main));border:none;border-radius:10px;font-family:'Nunito',sans-serif;font-weight:800;font-size:13px;color:white;cursor:pointer;transition:all .2s;display:inline-flex;align-items:center;gap:6px;box-shadow:0 4px 12px rgba(61,186,126,.25);text-decoration:none}
        .btn-green:hover{transform:translateY(-1px);box-shadow:0 8px 20px rgba(61,186,126,.3)}
        .btn-outline{padding:9px 18px;border:1.5px solid var(--border);border-radius:10px;background:white;font-family:'Nunito',sans-serif;font-weight:700;font-size:13px;color:var(--text-mid);cursor:pointer;transition:all .2s;display:inline-flex;align-items:center;gap:6px;text-decoration:none}
        .btn-outline:hover{border-color:var(--green-main);color:var(--green-dark)}
        .btn-blue{padding:9px 18px;background:linear-gradient(135deg,#60a5fa,var(--blue));border:none;border-radius:10px;font-family:'Nunito',sans-serif;font-weight:800;font-size:13px;color:white;cursor:pointer;transition:all .2s;display:inline-flex;align-items:center;gap:6px;text-decoration:none}
        .btn-blue:hover{transform:translateY(-1px)}

        /* ── Filter bar ───────────────────────────────────────────────── */
        .filter-card{background:white;border:1px solid var(--border);border-radius:var(--r);padding:16px 20px;margin-bottom:22px;display:flex;gap:12px;flex-wrap:wrap;align-items:flex-end}
        .filter-group{display:flex;flex-direction:column;gap:5px;min-width:140px}
        .filter-label{font-size:11px;font-weight:800;color:var(--text-muted);text-transform:uppercase;letter-spacing:.8px}
        .filter-select,.filter-input{padding:8px 12px;border:1.5px solid var(--border);border-radius:9px;font-family:'Nunito',sans-serif;font-size:13px;color:var(--text-mid);background:white;outline:none;cursor:pointer;transition:border-color .2s}
        .filter-select:focus,.filter-input:focus{border-color:var(--green-main)}
        .custom-range{display:none;gap:8px;align-items:flex-end}
        .custom-range.show{display:flex}

        /* ── Stats grid ───────────────────────────────────────────────── */
        .stats-bar{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:22px}
        .stat-card{background:white;border:1px solid var(--border);border-radius:var(--r);padding:18px;position:relative;overflow:hidden;transition:transform .2s,box-shadow .2s}
        .stat-card:hover{transform:translateY(-2px);box-shadow:var(--shadow-md)}
        .stat-card::after{content:'';position:absolute;right:-14px;top:-14px;width:80px;height:80px;border-radius:50%;opacity:.07}
        .stat-card.green::after{background:var(--green-main)}
        .stat-card.blue::after{background:var(--blue)}
        .stat-card.purple::after{background:var(--purple)}
        .stat-card.orange::after{background:var(--accent)}
        .stat-card.red::after{background:var(--red)}
        .stat-icon{width:40px;height:40px;border-radius:11px;display:flex;align-items:center;justify-content:center;font-size:17px;margin-bottom:12px}
        .stat-icon.green{background:var(--green-pale);color:var(--green-dark)}
        .stat-icon.blue{background:var(--blue-soft);color:var(--blue)}
        .stat-icon.purple{background:var(--purple-soft);color:var(--purple)}
        .stat-icon.orange{background:var(--accent-soft);color:var(--accent)}
        .stat-icon.red{background:var(--red-soft);color:var(--red)}
        .stat-label{font-size:10px;font-weight:800;color:var(--text-muted);text-transform:uppercase;letter-spacing:.8px;margin-bottom:4px}
        .stat-value{font-size:22px;font-weight:900;color:var(--text-dark);line-height:1.1}
        .stat-value.small{font-size:16px}
        .stat-sub{font-size:11px;font-weight:700;margin-top:5px;display:flex;align-items:center;gap:4px}
        .stat-sub.up{color:#16a34a} .stat-sub.down{color:#dc2626} .stat-sub.neutral{color:var(--text-muted)}

        /* ── Tab navigation ──────────────────────────────────────────── */
        .tab-nav{display:flex;gap:4px;background:white;border:1px solid var(--border);border-radius:var(--r);padding:6px;margin-bottom:22px;flex-wrap:wrap}
        .tab-btn{padding:9px 18px;border-radius:10px;font-family:'Nunito',sans-serif;font-size:13px;font-weight:800;color:var(--text-muted);border:none;background:transparent;cursor:pointer;transition:all .2s;display:flex;align-items:center;gap:7px;text-decoration:none}
        .tab-btn:hover{color:var(--green-dark);background:var(--green-pale)}
        .tab-btn.active{background:var(--green-main);color:white;box-shadow:0 3px 10px rgba(45,134,83,.3)}

        /* ── Card ────────────────────────────────────────────────────── */
        .card{background:white;border:1px solid var(--border);border-radius:var(--r);margin-bottom:20px}
        .card-header{padding:16px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap}
        .card-title{font-size:14px;font-weight:900;color:var(--text-dark);display:flex;align-items:center;gap:8px}
        .card-title i{color:var(--green-main)}
        .card-body{padding:20px}

        /* ── Two-column layout ───────────────────────────────────────── */
        .two-col{display:grid;grid-template-columns:1fr 320px;gap:16px;margin-bottom:20px}
        .three-col{display:grid;grid-template-columns:1fr 1fr 1fr;gap:14px;margin-bottom:20px}

        /* ── Chart ────────────────────────────────────────────────────── */
        .chart-container{position:relative;height:220px;width:100%}
        canvas{display:block}

        /* ── Top list ─────────────────────────────────────────────────── */
        .top-list{display:flex;flex-direction:column;gap:10px}
        .top-item{display:flex;align-items:center;gap:12px;padding:10px 12px;border-radius:10px;background:var(--bg);border:1px solid var(--border)}
        .top-rank{width:26px;height:26px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:900;flex-shrink:0}
        .top-rank.r1{background:#fef9c3;color:#854d0e} .top-rank.r2{background:#f1f5f9;color:#475569}
        .top-rank.r3{background:#fef3c7;color:#92400e} .top-rank.rn{background:var(--green-pale);color:var(--green-dark)}
        .top-info{flex:1;min-width:0}
        .top-name{font-size:13px;font-weight:800;color:var(--text-dark);white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
        .top-qty{font-size:11px;font-weight:700;color:var(--text-muted)}
        .top-rev{font-size:12px;font-weight:900;color:var(--green-dark);white-space:nowrap}
        .top-bar-wrap{margin-top:4px;height:4px;background:var(--border);border-radius:3px;overflow:hidden}
        .top-bar-fill{height:100%;border-radius:3px;background:linear-gradient(90deg,var(--green-mid),var(--green-main))}

        /* ── Status donut ring list ────────────────────────────────────── */
        .status-ring-list{display:flex;flex-direction:column;gap:8px;margin-top:16px}
        .status-ring-item{display:flex;align-items:center;gap:10px}
        .status-dot{width:10px;height:10px;border-radius:50%;flex-shrink:0}
        .status-ring-label{font-size:12px;font-weight:700;color:var(--text-mid);flex:1}
        .status-ring-count{font-size:12px;font-weight:800;color:var(--text-dark)}

        /* ── Tabel ────────────────────────────────────────────────────── */
        .table-scroll{overflow-x:auto}
        table{width:100%;border-collapse:collapse;font-size:13px}
        thead th{background:var(--green-pale);color:var(--green-dark);font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:.8px;padding:11px 16px;text-align:left;white-space:nowrap}
        tbody tr{border-bottom:1px solid var(--border);transition:background .15s}
        tbody tr:hover{background:var(--green-pale)}
        tbody tr:last-child{border-bottom:none}
        td{padding:11px 16px;color:var(--text-dark);vertical-align:middle}
        .td-product{font-weight:800} .td-order{font-size:11px;font-weight:700;color:var(--text-muted)}
        .td-price{font-weight:800;color:var(--green-dark)} .td-qty{font-weight:700;text-align:center}
        .status-badge{display:inline-flex;align-items:center;gap:5px;font-size:11px;font-weight:800;padding:3px 10px;border-radius:20px;white-space:nowrap}
        .status-badge.delivered{background:#dcfce7;color:#166534}
        .status-badge.paid{background:#dbeafe;color:#1e40af}
        .status-badge.processing{background:#fef9c3;color:#854d0e}
        .status-badge.shipped{background:#e0f2fe;color:#0369a1}
        .status-badge.cancelled{background:#fee2e2;color:#b91c1c}
        .status-badge.refunded{background:#fce7f3;color:#9d174d}
        .status-badge.pending_payment{background:#f3f4f6;color:#374151}
        .offer-tag{font-size:10px;font-weight:700;background:var(--purple-soft);color:var(--purple);padding:2px 7px;border-radius:10px;margin-left:4px}

        /* ── Category progress bars ───────────────────────────────────── */
        .kat-item{padding:12px 0;border-bottom:1px solid var(--border)}
        .kat-item:last-child{border-bottom:none}
        .kat-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:6px}
        .kat-name{font-size:13px;font-weight:800;color:var(--text-dark)}
        .kat-rev{font-size:13px;font-weight:900;color:var(--green-dark)}
        .kat-bar-bg{height:6px;background:var(--border);border-radius:4px;overflow:hidden}
        .kat-bar-fill{height:100%;border-radius:4px;background:linear-gradient(90deg,var(--green-mid),var(--green-main));transition:width .6s ease}
        .kat-sub{font-size:11px;font-weight:700;color:var(--text-muted);margin-top:3px}

        /* ── Pelanggan terbaik ────────────────────────────────────────── */
        .customer-item{display:flex;align-items:center;gap:12px;padding:12px 0;border-bottom:1px solid var(--border)}
        .customer-item:last-child{border-bottom:none}
        .customer-avatar{width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,var(--green-mid),var(--green-main));display:flex;align-items:center;justify-content:center;font-size:14px;font-weight:900;color:white;flex-shrink:0}
        .customer-name{font-size:13px;font-weight:800;color:var(--text-dark)}
        .customer-meta{font-size:11px;font-weight:700;color:var(--text-muted)}
        .customer-total{font-size:13px;font-weight:900;color:var(--green-dark);text-align:right;white-space:nowrap}
        .customer-orders{font-size:11px;font-weight:700;color:var(--text-muted);text-align:right}

        /* ── Empty state ──────────────────────────────────────────────── */
        .empty-state{text-align:center;padding:40px 20px}
        .empty-state i{font-size:40px;color:var(--border);margin-bottom:12px;display:block}
        .empty-state h3{font-size:15px;font-weight:800;color:var(--text-mid);margin-bottom:5px}
        .empty-state p{font-size:13px;color:var(--text-muted);font-weight:600}

        /* ── Pagination ───────────────────────────────────────────────── */
        .pagination-wrap{display:flex;justify-content:center;gap:6px;padding:16px 20px;border-top:1px solid var(--border)}
        .pagination-wrap a,.pagination-wrap span{padding:7px 13px;border-radius:8px;font-size:13px;font-weight:700;border:1.5px solid var(--border);text-decoration:none;color:var(--text-mid);background:white;transition:all .18s}
        .pagination-wrap a:hover{border-color:var(--green-main);color:var(--green-dark)}
        .pagination-wrap span.active-page,.pagination-wrap .page-item.active .page-link{background:var(--green-main);color:white;border-color:var(--green-main)}

        /* ── Periode info banner ───────────────────────────────────────── */
        .periode-info{background:linear-gradient(135deg,var(--green-pale),#e8f9f0);border:1px solid #b6edce;border-radius:10px;padding:10px 16px;display:flex;align-items:center;gap:10px;font-size:12px;font-weight:700;color:var(--green-dark);margin-bottom:16px}
        .periode-info i{color:var(--green-main)}

        /* ── Growth badge ─────────────────────────────────────────────── */
        .growth-badge{display:inline-flex;align-items:center;gap:4px;font-size:11px;font-weight:800;padding:3px 9px;border-radius:20px}
        .growth-badge.up{background:#dcfce7;color:#166534}
        .growth-badge.down{background:#fee2e2;color:#b91c1c}
        .growth-badge.neutral{background:#f3f4f6;color:#374151}

        /* ── Animations ───────────────────────────────────────────────── */
        @keyframes fadeUp{from{opacity:0;transform:translateY(14px)}to{opacity:1;transform:translateY(0)}}
        .anim-1{animation:fadeUp .45s ease both}
        .anim-2{animation:fadeUp .45s .07s ease both}
        .anim-3{animation:fadeUp .45s .14s ease both}
        .anim-4{animation:fadeUp .45s .21s ease both}

        @media(max-width:1200px){.three-col{grid-template-columns:1fr 1fr}}
        @media(max-width:1100px){.two-col{grid-template-columns:1fr}.three-col{grid-template-columns:1fr}}
        @media(max-width:768px){.seller-sidebar{display:none}.seller-main{padding:16px}.stats-bar{grid-template-columns:1fr 1fr}}
        @media(max-width:480px){.stats-bar{grid-template-columns:1fr}}
    </style>
</head>
<body>

<div class="seller-wrap">
    @include('partials.seller_sidebar')

    <main class="seller-main">

        {{-- ── Page Header ──────────────────────────────────────────────── --}}
        <div class="page-header anim-1">
            <div class="page-header-left">
                <h1>Laporan Penjualan <i class="fa-solid fa-chart-line" style="font-size:22px;color:var(--green-main)"></i></h1>
                <p>Pantau performa penjualan, tren pendapatan, dan analitik toko Anda secara lengkap.</p>
            </div>
            <div class="page-header-right">
                <a href="{{ route('seller.laporan.export', request()->query()) }}" class="btn-outline">
                    <i class="fa-solid fa-file-csv"></i> Export CSV
                </a>
                <a href="{{ route('seller.laporan.index') }}" class="btn-green">
                    <i class="fa-solid fa-rotate-right"></i> Refresh
                </a>
            </div>
        </div>

        {{-- ── Filter Bar ────────────────────────────────────────────────── --}}
        {{--
            PERBAIKAN BUG TAB #1:
            Input hidden "tab" di dalam form filter memastikan saat filter disubmit
            (misal ganti periode/status), tab yang aktif tetap terbawa ke request berikutnya.
            Sebelumnya tidak ada sinkronisasi antara tab aktif dan form filter.
        --}}
        <form method="GET" action="{{ route('seller.laporan.index') }}" id="filterForm">
            {{-- Kirim tab aktif saat ini bersama setiap submit filter --}}
            <input type="hidden" name="tab" id="activeTabInput" value="{{ $activeTab }}">
            <div class="filter-card anim-2">
                <div class="filter-group">
                    <span class="filter-label">Periode</span>
                    <select name="periode" class="filter-select" id="periodeSelect" onchange="toggleCustom(); this.form.submit()">
                        @foreach(['hari_ini'=>'Hari Ini','minggu_ini'=>'Minggu Ini','bulan_ini'=>'Bulan Ini','bulan_lalu'=>'Bulan Lalu','tahun_ini'=>'Tahun Ini','custom'=>'Kustom'] as $val => $label)
                        <option value="{{ $val }}" {{ $periode === $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="custom-range {{ $periode === 'custom' ? 'show' : '' }}" id="customRange">
                    <div class="filter-group">
                        <span class="filter-label">Dari</span>
                        <input type="date" name="start_date" class="filter-input"
                               value="{{ $periode === 'custom' ? request('start_date') : '' }}">
                    </div>
                    <div class="filter-group">
                        <span class="filter-label">Sampai</span>
                        <input type="date" name="end_date" class="filter-input"
                               value="{{ $periode === 'custom' ? request('end_date') : '' }}">
                    </div>
                    <button type="submit" class="btn-green" style="height:38px">Terapkan</button>
                </div>

                <div class="filter-group">
                    <span class="filter-label">Status</span>
                    <select name="status" class="filter-select" onchange="this.form.submit()">
                        <option value="" {{ !$filterStatus ? 'selected' : '' }}>Semua Status</option>
                        @foreach(['pending_payment'=>'Menunggu Bayar','paid'=>'Sudah Dibayar','processing'=>'Diproses','shipped'=>'Dikirim','delivered'=>'Selesai','cancelled'=>'Dibatalkan','refunded'=>'Direfund'] as $val => $label)
                        <option value="{{ $val }}" {{ $filterStatus === $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>

        {{-- ── Periode info ──────────────────────────────────────────────── --}}
        <div class="periode-info anim-2">
            <i class="fa-solid fa-calendar-range"></i>
            Menampilkan data: <strong>{{ $startDate->isoFormat('D MMMM YYYY') }}</strong> — <strong>{{ $endDate->isoFormat('D MMMM YYYY') }}</strong>
            @if($filterStatus)
            &nbsp;·&nbsp; Status: <strong>{{ ['pending_payment'=>'Menunggu Bayar','paid'=>'Sudah Dibayar','processing'=>'Diproses','shipped'=>'Dikirim','delivered'=>'Selesai','cancelled'=>'Dibatalkan','refunded'=>'Direfund'][$filterStatus] ?? $filterStatus }}</strong>
            @endif
        </div>

        {{-- ── Stats Cards ───────────────────────────────────────────────── --}}
        <div class="stats-bar anim-3">
            <div class="stat-card green">
                <div class="stat-icon green"><i class="fa-solid fa-circle-dollar-to-slot"></i></div>
                <div class="stat-label">Total Pendapatan</div>
                <div class="stat-value small">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
                <div class="stat-sub {{ $growthPersen >= 0 ? 'up' : 'down' }}">
                    @if($growthPersen >= 0)
                        <i class="fa-solid fa-arrow-trend-up"></i> +{{ $growthPersen }}%
                    @else
                        <i class="fa-solid fa-arrow-trend-down"></i> {{ $growthPersen }}%
                    @endif
                    vs periode sebelumnya
                </div>
            </div>

            <div class="stat-card blue">
                <div class="stat-icon blue"><i class="fa-solid fa-box-open"></i></div>
                <div class="stat-label">Total Order</div>
                <div class="stat-value">{{ number_format($totalOrder) }}</div>
                <div class="stat-sub neutral"><i class="fa-solid fa-check-circle"></i> Order valid terbayar</div>
            </div>

            <div class="stat-card purple">
                <div class="stat-icon purple"><i class="fa-solid fa-wheat-awn"></i></div>
                <div class="stat-label">Item Terjual</div>
                <div class="stat-value">{{ number_format($totalItemTerjual) }}</div>
                <div class="stat-sub neutral"><i class="fa-solid fa-scale-balanced"></i> Total kuantitas</div>
            </div>

            <div class="stat-card orange">
                <div class="stat-icon orange"><i class="fa-solid fa-receipt"></i></div>
                <div class="stat-label">Rata-rata / Order</div>
                <div class="stat-value small">Rp {{ number_format($rataRataOrder, 0, ',', '.') }}</div>
                <div class="stat-sub neutral"><i class="fa-solid fa-chart-pie"></i> Nilai rata-rata</div>
            </div>
        </div>

        {{-- ── Tab Navigation ────────────────────────────────────────────── --}}
        {{--
            Build URL tab secara eksplisit menggunakan http_build_query.
            Ini cara paling reliable di Laravel karena tidak bergantung pada
            route() untuk membawa query string — route() hanya untuk path,
            query string dibangun manual dan di-append ke URL.
        --}}
{{-- ── Tab Navigation ────────────────────────────────────────────── --}}
@php
    $activeTab = request('tab', $activeTab ?? 'ringkasan');
@endphp

<div class="tab-nav anim-3">

    @foreach([
        'ringkasan'  => ['fa-chart-area', 'Ringkasan'],
        'produk'     => ['fa-wheat-awn', 'Produk & Kategori'],
        'pelanggan'  => ['fa-users', 'Pelanggan'],
        'transaksi'  => ['fa-list-ul', 'Riwayat Transaksi'],
    ] as $tabKey => [$icon, $label])

        <a href="{{ route('seller.laporan.index', array_merge(request()->query(), ['tab' => $tabKey])) }}"
           class="tab-btn {{ $activeTab === $tabKey ? 'active' : '' }}">

            <i class="fa-solid fa-{{ $icon }}"></i>
            {{ $label }}

        </a>

    @endforeach

</div>

        {{-- ══════════════════════════════════════════════════════════════════ --}}
        {{--  TAB: RINGKASAN                                                   --}}
        {{-- ══════════════════════════════════════════════════════════════════ --}}
        @if($activeTab === 'ringkasan')

        <div class="two-col anim-3">

            {{-- Grafik Tren Harian --}}
            <div class="card">
                <div class="card-header">
                    <div class="card-title"><i class="fa-solid fa-chart-area"></i> Tren Pendapatan Periode Ini</div>
                    <span style="font-size:11px;font-weight:700;color:var(--text-muted)">Per hari (transaksi valid)</span>
                </div>
                <div class="card-body">
                    @if(count($grafikHarianData) === 0)
                    <div class="empty-state" style="padding:30px 10px">
                        <i class="fa-solid fa-chart-area" style="font-size:32px"></i>
                        <h3 style="font-size:14px">Belum ada data tren</h3>
                        <p style="font-size:12px">Tidak ada transaksi valid di periode ini</p>
                    </div>
                    @else
                    <div class="chart-container">
                        <canvas id="chartHarian"></canvas>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Distribusi Status --}}
            <div class="card">
                <div class="card-header">
                    <div class="card-title"><i class="fa-solid fa-chart-pie"></i> Status Order</div>
                </div>
                <div class="card-body" style="padding-bottom:12px">
                    @php
                        $totalAllOrder = $statusDistribusi->sum('total');
                        $statusConfig = [
                            'delivered'       => ['label'=>'Selesai',          'color'=>'#16a34a'],
                            'paid'            => ['label'=>'Sudah Dibayar',    'color'=>'#2563eb'],
                            'processing'      => ['label'=>'Diproses',         'color'=>'#d97706'],
                            'shipped'         => ['label'=>'Dikirim',          'color'=>'#0891b2'],
                            'pending_payment' => ['label'=>'Menunggu Bayar',   'color'=>'#9ca3af'],
                            'cancelled'       => ['label'=>'Dibatalkan',       'color'=>'#dc2626'],
                            'refunded'        => ['label'=>'Direfund',         'color'=>'#db2777'],
                        ];
                    @endphp
                    @if($totalAllOrder > 0)
                    <div style="position:relative;height:160px;display:flex;justify-content:center">
                        <canvas id="chartDonut" style="max-width:160px"></canvas>
                    </div>
                    <div class="status-ring-list">
                        @foreach($statusConfig as $sKey => $sCfg)
                        @if(isset($statusDistribusi[$sKey]))
                        @php $pct = $totalAllOrder > 0 ? round(($statusDistribusi[$sKey]->total / $totalAllOrder) * 100) : 0; @endphp
                        <div class="status-ring-item">
                            <div class="status-dot" style="background:{{ $sCfg['color'] }}"></div>
                            <span class="status-ring-label">{{ $sCfg['label'] }}</span>
                            <span class="status-ring-count">{{ $statusDistribusi[$sKey]->total }} ({{ $pct }}%)</span>
                        </div>
                        @endif
                        @endforeach
                    </div>
                    @else
                    <div class="empty-state" style="padding:30px 10px">
                        <i class="fa-solid fa-chart-pie" style="font-size:28px"></i>
                        <h3 style="font-size:13px">Belum ada data</h3>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Grafik Bulanan 12 bulan --}}
        <div class="card anim-4">
            <div class="card-header">
                <div class="card-title"><i class="fa-solid fa-chart-bar"></i> Pendapatan 12 Bulan Terakhir</div>
                <span style="font-size:11px;font-weight:700;color:var(--text-muted)">
                    Puncak: <strong style="color:var(--green-dark)">Rp {{ number_format(collect($grafikData)->max('total'), 0, ',', '.') }}</strong>
                </span>
            </div>
            <div class="card-body">
                @if(count($grafikData) === 0)
                <div class="empty-state" style="padding:30px 10px">
                    <i class="fa-solid fa-chart-bar" style="font-size:32px"></i>
                    <h3 style="font-size:14px">Belum ada data bulanan</h3>
                    <p style="font-size:12px">Belum ada transaksi dalam 12 bulan terakhir</p>
                </div>
                @else
                <div class="chart-container" style="height:200px">
                    <canvas id="chartBulanan"></canvas>
                </div>
                @endif
            </div>
        </div>

        {{-- Info pembanding periode sebelumnya --}}
        @if($prevPendapatan > 0 || $totalPendapatan > 0)
        <div class="card anim-4">
            <div class="card-header">
                <div class="card-title"><i class="fa-solid fa-scale-unbalanced"></i> Perbandingan Periode</div>
            </div>
            <div class="card-body">
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px">
                    <div>
                        <div style="font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:.8px;color:var(--text-muted);margin-bottom:6px">Periode Sebelumnya</div>
                        <div style="font-size:20px;font-weight:900;color:var(--text-dark)">Rp {{ number_format($prevPendapatan, 0, ',', '.') }}</div>
                        <div style="font-size:11px;font-weight:700;color:var(--text-muted);margin-top:4px">
                            {{ $startDate->copy()->subDays($startDate->diffInDays($endDate)+1)->isoFormat('D MMM') }}
                            — {{ $startDate->copy()->subDay()->isoFormat('D MMM YYYY') }}
                        </div>
                    </div>
                    <div>
                        <div style="font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:.8px;color:var(--text-muted);margin-bottom:6px">Periode Ini</div>
                        <div style="font-size:20px;font-weight:900;color:var(--green-dark)">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
                        <div style="margin-top:6px">
                            <span class="growth-badge {{ $growthPersen > 0 ? 'up' : ($growthPersen < 0 ? 'down' : 'neutral') }}">
                                @if($growthPersen > 0)<i class="fa-solid fa-arrow-up"></i> +{{ $growthPersen }}%
                                @elseif($growthPersen < 0)<i class="fa-solid fa-arrow-down"></i> {{ $growthPersen }}%
                                @else<i class="fa-solid fa-minus"></i> 0%
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
                @if($totalDibatalkan > 0)
                <div style="margin-top:14px;padding-top:14px;border-top:1px solid var(--border);display:flex;align-items:center;gap:8px">
                    <i class="fa-solid fa-circle-xmark" style="color:var(--red)"></i>
                    <span style="font-size:13px;font-weight:700;color:var(--text-mid)">Potensi hilang (cancel/refund): </span>
                    <span style="font-size:13px;font-weight:900;color:var(--red)">Rp {{ number_format($totalDibatalkan, 0, ',', '.') }}</span>
                </div>
                @endif
            </div>
        </div>
        @endif

        @endif {{-- END TAB: RINGKASAN --}}

        {{-- ══════════════════════════════════════════════════════════════════ --}}
        {{--  TAB: PRODUK & KATEGORI                                           --}}
        {{-- ══════════════════════════════════════════════════════════════════ --}}
        @if($activeTab === 'produk')

        <div class="two-col anim-3">
            <div class="card">
                <div class="card-header">
                    <div class="card-title"><i class="fa-solid fa-trophy"></i> Produk Terlaris</div>
                    <span style="font-size:11px;font-weight:700;color:var(--text-muted)">Top 5 berdasarkan qty</span>
                </div>
                <div class="card-body">
                    @if($produkTerlaris->isEmpty())
                    <div class="empty-state" style="padding:30px 10px">
                        <i class="fa-solid fa-seedling" style="font-size:32px"></i>
                        <h3 style="font-size:14px">Belum ada data</h3>
                        <p style="font-size:12px">Tidak ada transaksi di periode ini</p>
                    </div>
                    @else
                    @php $maxQty = $produkTerlaris->max('total_qty'); @endphp
                    <div class="top-list">
                        @foreach($produkTerlaris as $i => $prod)
                        @php $rankClass = match($i) { 0=>'r1', 1=>'r2', 2=>'r3', default=>'rn' }; @endphp
                        <div class="top-item">
                            <div class="top-rank {{ $rankClass }}">{{ $i + 1 }}</div>
                            <div class="top-info">
                                <div class="top-name">{{ $prod->product_name }}</div>
                                <div class="top-bar-wrap">
                                    <div class="top-bar-fill" style="width:{{ $maxQty > 0 ? round(($prod->total_qty / $maxQty) * 100) : 0 }}%"></div>
                                </div>
                                <div class="top-qty">{{ number_format($prod->total_qty) }} unit · {{ $prod->total_orders }} order</div>
                            </div>
                            <div class="top-rev">Rp {{ number_format($prod->total_revenue, 0, ',', '.') }}</div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="card-title"><i class="fa-solid fa-chart-pie"></i> Komposisi Pendapatan Produk</div>
                </div>
                <div class="card-body">
                    @if($produkTerlaris->isNotEmpty())
                    <div style="position:relative;height:180px;display:flex;justify-content:center">
                        <canvas id="chartProdukDonut"></canvas>
                    </div>
                    @else
                    <div class="empty-state" style="padding:30px 10px">
                        <i class="fa-solid fa-chart-pie" style="font-size:28px"></i>
                        <h3 style="font-size:13px">Belum ada data</h3>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="card anim-4">
            <div class="card-header">
                <div class="card-title"><i class="fa-solid fa-layer-group"></i> Breakdown per Kategori</div>
            </div>
            <div class="card-body">
                @if($kategoryBreakdown->isEmpty())
                <div class="empty-state">
                    <i class="fa-solid fa-layer-group"></i>
                    <h3>Belum ada data kategori</h3>
                    <p>Tidak ada transaksi di periode ini</p>
                </div>
                @else
                @php $maxKatRev = $kategoryBreakdown->max('total_revenue'); @endphp
                @foreach($kategoryBreakdown as $kat)
                <div class="kat-item">
                    <div class="kat-header">
                        <div class="kat-name"><i class="fa-solid fa-tag" style="color:var(--green-main);margin-right:6px"></i>{{ $kat->kategori }}</div>
                        <div class="kat-rev">Rp {{ number_format($kat->total_revenue, 0, ',', '.') }}</div>
                    </div>
                    <div class="kat-bar-bg">
                        <div class="kat-bar-fill" style="width:{{ $maxKatRev > 0 ? round(($kat->total_revenue / $maxKatRev) * 100) : 0 }}%"></div>
                    </div>
                    <div class="kat-sub">{{ number_format($kat->total_qty) }} unit terjual
                        · {{ $kategoryBreakdown->sum('total_revenue') > 0 ? round(($kat->total_revenue / $kategoryBreakdown->sum('total_revenue')) * 100) : 0 }}% dari total
                    </div>
                </div>
                @endforeach
                @endif
            </div>
        </div>

        @endif {{-- END TAB: PRODUK --}}

        {{-- ══════════════════════════════════════════════════════════════════ --}}
        {{--  TAB: PELANGGAN                                                   --}}
        {{-- ══════════════════════════════════════════════════════════════════ --}}
        @if($activeTab === 'pelanggan')

        <div class="card anim-3">
            <div class="card-header">
                <div class="card-title"><i class="fa-solid fa-crown"></i> Pelanggan Terbaik</div>
                <span style="font-size:11px;font-weight:700;color:var(--text-muted)">Top 5 berdasarkan total belanja</span>
            </div>
            <div class="card-body">
                @if($pelangganTerbaik->isEmpty())
                <div class="empty-state">
                    <i class="fa-solid fa-users"></i>
                    <h3>Belum ada data pelanggan</h3>
                    <p>Tidak ada transaksi di periode ini</p>
                </div>
                @else
                @php $maxBelanja = $pelangganTerbaik->max('total_belanja'); @endphp
                @foreach($pelangganTerbaik as $i => $cust)
                <div class="customer-item">
                    @php $initials = collect(explode(' ', $cust->nama_lengkap))->take(2)->map(fn($w) => strtoupper(substr($w,0,1)))->join(''); @endphp
                    <div class="customer-avatar">{{ $initials }}</div>
                    <div style="flex:1;min-width:0">
                        <div class="customer-name">{{ $cust->nama_lengkap }}</div>
                        <div class="customer-meta">{{ $cust->total_orders }} order · {{ number_format($cust->total_item) }} item</div>
                        <div style="margin-top:5px;height:4px;background:var(--border);border-radius:3px;overflow:hidden">
                            <div style="height:100%;background:linear-gradient(90deg,var(--green-mid),var(--green-main));width:{{ $maxBelanja > 0 ? round(($cust->total_belanja / $maxBelanja)*100) : 0 }}%;border-radius:3px"></div>
                        </div>
                    </div>
                    <div style="text-align:right;flex-shrink:0">
                        <div class="customer-total">Rp {{ number_format($cust->total_belanja, 0, ',', '.') }}</div>
                        <div class="customer-orders">Peringkat #{{ $i + 1 }}</div>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
        </div>

        @endif {{-- END TAB: PELANGGAN --}}

        {{-- ══════════════════════════════════════════════════════════════════ --}}
        {{--  TAB: RIWAYAT TRANSAKSI                                           --}}
        {{-- ══════════════════════════════════════════════════════════════════ --}}
        @if($activeTab === 'transaksi')

        <div class="card anim-3">
            <div class="card-header">
                <div class="card-title">
                    <i class="fa-solid fa-list-ul"></i> Riwayat Transaksi
                    <span style="font-size:12px;font-weight:700;color:var(--text-muted);margin-left:4px">({{ $riwayat->total() }} item)</span>
                </div>
                <a href="{{ route('seller.laporan.export', request()->query()) }}" class="btn-outline" style="font-size:12px;padding:6px 13px">
                    <i class="fa-solid fa-download"></i> Export CSV
                </a>
            </div>

            @if($riwayat->isEmpty())
            <div class="empty-state">
                <i class="fa-solid fa-receipt"></i>
                <h3>Belum ada transaksi</h3>
                <p>Tidak ada data penjualan untuk periode dan filter yang dipilih.</p>
            </div>
            @else
            <div class="table-scroll">
                <table>
                    <thead>
                        <tr>
                            <th>No. Order</th>
                            <th>Tanggal</th>
                            <th>Pembeli</th>
                            <th>Produk</th>
                            <th style="text-align:center">Qty</th>
                            <th>Harga Satuan</th>
                            <th>Subtotal</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($riwayat as $item)
                        @php
                            $order = $item->order;
                            $statusClass = match($order->status ?? '') {
                                'delivered'       => 'delivered',
                                'paid'            => 'paid',
                                'processing'      => 'processing',
                                'shipped'         => 'shipped',
                                'cancelled'       => 'cancelled',
                                'refunded'        => 'refunded',
                                'pending_payment' => 'pending_payment',
                                default           => 'pending_payment',
                            };
                            $statusLabel = match($order->status ?? '') {
                                'delivered'       => '✅ Selesai',
                                'paid'            => '💰 Dibayar',
                                'processing'      => '⚙️ Diproses',
                                'shipped'         => '🚚 Dikirim',
                                'cancelled'       => '❌ Dibatalkan',
                                'refunded'        => '↩️ Dikembalikan',
                                'pending_payment' => '⏳ Menunggu',
                                default           => ucfirst($order->status ?? '-'),
                            };
                        @endphp
                        <tr>
                            <td>
                                <div style="font-size:12px;font-weight:800;color:var(--green-dark)">#{{ $order->order_number ?? '-' }}</div>
                            </td>
                            <td>
                                <div style="font-size:13px;font-weight:700">{{ optional($item->created_at)->isoFormat('D MMM YYYY') }}</div>
                                <div class="td-order">{{ optional($item->created_at)->format('H:i') }} WIB</div>
                            </td>
                            <td>
                                @if($order && $order->buyer)
                                <div style="font-size:13px;font-weight:700">{{ $order->buyer->nama_lengkap ?? '-' }}</div>
                                @else
                                <span class="td-order">–</span>
                                @endif
                            </td>
                            <td>
                                <div class="td-product">{{ $item->product_name }}</div>
                                <div class="td-order">{{ $item->product_unit }}</div>
                                @if($item->is_offer_price)
                                <span class="offer-tag"><i class="fa-solid fa-handshake"></i> Harga Tawar</span>
                                @endif
                            </td>
                            <td class="td-qty">
                                <span style="background:var(--green-pale);color:var(--green-dark);padding:3px 10px;border-radius:20px;font-weight:800;font-size:12px">
                                    {{ number_format($item->quantity) }}
                                </span>
                            </td>
                            <td class="td-price">Rp {{ number_format($item->price_per_unit, 0, ',', '.') }}</td>
                            <td>
                                <div class="td-price" style="font-size:14px">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</div>
                            </td>
                            <td>
                                <span class="status-badge {{ $statusClass }}">{{ $statusLabel }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($riwayat->hasPages())
            <div class="pagination-wrap">
                {{ $riwayat->links() }}
            </div>
            @endif
            @endif
        </div>

        @endif {{-- END TAB: TRANSAKSI --}}

    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    // ── Filter helpers ────────────────────────────────────────────────────
    function toggleCustom() {
        const val = document.getElementById('periodeSelect').value;
        const el  = document.getElementById('customRange');
        el.classList.toggle('show', val === 'custom');
    }

    // ── Chart defaults ────────────────────────────────────────────────────
    Chart.defaults.font.family = "'Nunito', sans-serif";
    Chart.defaults.font.size   = 11;

    const GREEN_MAIN  = '#2d8653';
    const GREEN_MID   = '#3dba7e';
    const GREEN_LIGHT = '#52dda0';
    const GREEN_PALE  = '#f0fdf6';

    // ════════════════════════════════════════════════════════════════════════
    // TAB: RINGKASAN — Charts
    // ════════════════════════════════════════════════════════════════════════
    @if($activeTab === 'ringkasan')

    {{--
        PERBAIKAN BUG GRAFIK:
        Data `total` dari DB query SUM() dikembalikan sebagai string oleh PHP.
        Chart.js menginterpretasikan string numerik sebagai nilai kecil (desimal 0–1).
        Solusi: cast ke (float) di PHP sebelum di-encode ke JSON.
        Hasilnya: [150000, 300000, ...] bukan ["150000", "300000", ...]
    --}}
    const harianLabels = @json(collect($grafikHarianData)->pluck('tanggal')->values());
    const harianData   = @json(collect($grafikHarianData)->pluck('total')->map(fn($v) => (float) $v)->values());

    const ctxHarian = document.getElementById('chartHarian');
    if (ctxHarian && harianData.length > 0) {
        new Chart(ctxHarian, {
            type: 'line',
            data: {
                labels: harianLabels,
                datasets: [{
                    label: 'Pendapatan',
                    data: harianData,
                    borderColor: GREEN_MAIN,
                    backgroundColor: 'rgba(45,134,83,.12)',
                    borderWidth: 2.5,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: GREEN_MAIN,
                    pointRadius: 3,
                    pointHoverRadius: 6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: ctx => 'Rp ' + ctx.raw.toLocaleString('id-ID')
                        }
                    }
                },
                scales: {
                    x: { grid: { display: false }, ticks: { maxTicksLimit: 10 } },
                    y: {
                        beginAtZero: true,
                        grid: { color: '#f0fdf6' },
                        ticks: {
                            callback: v => {
                                if (v >= 1000000) return 'Rp ' + (v/1000000).toFixed(1) + 'jt';
                                if (v >= 1000)    return 'Rp ' + (v/1000).toFixed(0) + 'rb';
                                return 'Rp ' + v;
                            }
                        }
                    }
                }
            }
        });
    }

    // ── Donut Status ───────────────────────────────────────────────────────
    @php
        $donutLabels = [];
        $donutData   = [];
        $donutColors = [];
        $statusColorMap = [
            'delivered'       => '#16a34a',
            'paid'            => '#2563eb',
            'processing'      => '#d97706',
            'shipped'         => '#0891b2',
            'pending_payment' => '#9ca3af',
            'cancelled'       => '#dc2626',
            'refunded'        => '#db2777',
        ];
        $statusLabelMap = [
            'delivered'       => 'Selesai',
            'paid'            => 'Dibayar',
            'processing'      => 'Diproses',
            'shipped'         => 'Dikirim',
            'pending_payment' => 'Menunggu',
            'cancelled'       => 'Dibatalkan',
            'refunded'        => 'Direfund',
        ];
        foreach ($statusDistribusi as $sKey => $sItem) {
            $donutLabels[] = $statusLabelMap[$sKey] ?? $sKey;
            $donutData[]   = (int) $sItem->total;
            $donutColors[] = $statusColorMap[$sKey] ?? '#6b7280';
        }
    @endphp
    const ctxDonut = document.getElementById('chartDonut');
    if (ctxDonut && {{ count($donutData) }} > 0) {
        new Chart(ctxDonut, {
            type: 'doughnut',
            data: {
                labels: @json($donutLabels),
                datasets: [{
                    data: @json($donutData),
                    backgroundColor: @json($donutColors),
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: { callbacks: { label: ctx => ctx.label + ': ' + ctx.raw } }
                },
                cutout: '65%'
            }
        });
    }

    // ── Grafik Bulanan ─────────────────────────────────────────────────────
    {{-- PERBAIKAN SAMA: cast total ke float agar tidak terbaca sebagai string desimal --}}
    const bulananLabels = @json(collect($grafikData)->pluck('bulan')->values());
    const bulananData   = @json(collect($grafikData)->pluck('total')->map(fn($v) => (float) $v)->values());
    const ctxBulanan    = document.getElementById('chartBulanan');
    if (ctxBulanan && bulananData.length > 0) {
        new Chart(ctxBulanan, {
            type: 'bar',
            data: {
                labels: bulananLabels,
                datasets: [{
                    label: 'Pendapatan',
                    data: bulananData,
                    backgroundColor: bulananData.map(v => {
                        const maxV = Math.max(...bulananData);
                        return v === maxV ? GREEN_MAIN : 'rgba(61,186,126,.5)';
                    }),
                    borderRadius: 6,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: { callbacks: { label: ctx => 'Rp ' + ctx.raw.toLocaleString('id-ID') } }
                },
                scales: {
                    x: { grid: { display: false } },
                    y: {
                        beginAtZero: true,
                        grid: { color: '#f0fdf6' },
                        ticks: {
                            callback: v => {
                                if (v >= 1000000) return (v/1000000).toFixed(1) + 'jt';
                                if (v >= 1000)    return (v/1000).toFixed(0) + 'rb';
                                return v;
                            }
                        }
                    }
                }
            }
        });
    }
    @endif {{-- END ringkasan charts --}}

    // ════════════════════════════════════════════════════════════════════════
    // TAB: PRODUK — Donut Chart
    // ════════════════════════════════════════════════════════════════════════
    @if($activeTab === 'produk')
    @php
        $produkDonutLabels = $produkTerlaris->pluck('product_name')->toArray();
        $produkDonutData   = $produkTerlaris->pluck('total_revenue')->map(fn($v) => (float) $v)->toArray();
        $produkDonutColors = ['#2d8653','#3dba7e','#52dda0','#86efac','#bbf7d0'];
    @endphp
    const ctxProdukDonut = document.getElementById('chartProdukDonut');
    if (ctxProdukDonut && {{ count($produkDonutData) }} > 0) {
        new Chart(ctxProdukDonut, {
            type: 'doughnut',
            data: {
                labels: @json($produkDonutLabels),
                datasets: [{
                    data: @json($produkDonutData),
                    backgroundColor: @json($produkDonutColors),
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom', labels: { font: { size: 11, family: "'Nunito', sans-serif" }, padding: 8 } },
                    tooltip: { callbacks: { label: ctx => ctx.label + ': Rp ' + ctx.raw.toLocaleString('id-ID') } }
                },
                cutout: '55%'
            }
        });
    }
    @endif {{-- END produk charts --}}
</script>

</body>
</html>