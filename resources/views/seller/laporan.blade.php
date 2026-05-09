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

        .btn-green{padding:9px 18px;background:linear-gradient(135deg,var(--green-mid),var(--green-main));border:none;border-radius:10px;font-family:'Nunito',sans-serif;font-weight:800;font-size:13px;color:white;cursor:pointer;transition:all .2s;display:flex;align-items:center;gap:6px;box-shadow:0 4px 12px rgba(61,186,126,.25);text-decoration:none}
        .btn-green:hover{transform:translateY(-1px);box-shadow:0 8px 20px rgba(61,186,126,.3)}
        .btn-outline{padding:9px 18px;border:1.5px solid var(--border);border-radius:10px;background:white;font-family:'Nunito',sans-serif;font-weight:700;font-size:13px;color:var(--text-mid);cursor:pointer;transition:all .2s;display:flex;align-items:center;gap:6px;text-decoration:none}
        .btn-outline:hover{border-color:var(--green-main);color:var(--green-dark)}

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
        .stat-card{background:white;border:1px solid var(--border);border-radius:var(--r);padding:18px;position:relative;overflow:hidden}
        .stat-card::after{content:'';position:absolute;right:-14px;top:-14px;width:80px;height:80px;border-radius:50%;opacity:.07}
        .stat-card.green::after{background:var(--green-main)}
        .stat-card.blue::after{background:var(--blue)}
        .stat-card.purple::after{background:var(--purple)}
        .stat-card.orange::after{background:var(--accent)}
        .stat-icon{width:40px;height:40px;border-radius:11px;display:flex;align-items:center;justify-content:center;font-size:17px;margin-bottom:12px}
        .stat-icon.green{background:var(--green-pale);color:var(--green-dark)}
        .stat-icon.blue{background:var(--blue-soft);color:var(--blue)}
        .stat-icon.purple{background:var(--purple-soft);color:var(--purple)}
        .stat-icon.orange{background:var(--accent-soft);color:var(--accent)}
        .stat-label{font-size:10px;font-weight:800;color:var(--text-muted);text-transform:uppercase;letter-spacing:.8px;margin-bottom:4px}
        .stat-value{font-size:22px;font-weight:900;color:var(--text-dark);line-height:1.1}
        .stat-value.small{font-size:16px}
        .stat-sub{font-size:11px;font-weight:700;margin-top:5px;display:flex;align-items:center;gap:4px}
        .stat-sub.up{color:#16a34a}
        .stat-sub.down{color:#dc2626}
        .stat-sub.neutral{color:var(--text-muted)}

        /* ── Two-column layout ────────────────────────────────────────── */
        .two-col{display:grid;grid-template-columns:1fr 340px;gap:16px;margin-bottom:22px}

        /* ── Chart card ───────────────────────────────────────────────── */
        .chart-card{background:white;border:1px solid var(--border);border-radius:var(--r);padding:20px}
        .card-title{font-size:14px;font-weight:900;color:var(--text-dark);margin-bottom:16px;display:flex;align-items:center;gap:8px}
        .card-title i{color:var(--green-main)}
        .chart-wrap{position:relative;height:200px}
        .bar-chart{display:flex;align-items:flex-end;gap:6px;height:100%;padding-bottom:24px}
        .bar-col{flex:1;display:flex;flex-direction:column;align-items:center;gap:4px;height:100%;position:relative}
        .bar-fill{width:100%;border-radius:5px 5px 0 0;background:linear-gradient(180deg,var(--green-mid),var(--green-main));min-height:3px;transition:height .5s ease;position:relative;cursor:pointer}
        .bar-fill:hover::after{content:attr(data-tooltip);position:absolute;bottom:calc(100% + 6px);left:50%;transform:translateX(-50%);background:var(--green-dark);color:white;font-size:11px;font-weight:700;padding:4px 8px;border-radius:6px;white-space:nowrap;z-index:10}
        .bar-label{font-size:9px;font-weight:700;color:var(--text-muted);text-align:center;position:absolute;bottom:0;width:100%;letter-spacing:.3px}

        /* ── Produk terlaris ──────────────────────────────────────────── */
        .top-list{display:flex;flex-direction:column;gap:10px}
        .top-item{display:flex;align-items:center;gap:12px;padding:10px 12px;border-radius:10px;background:var(--bg);border:1px solid var(--border)}
        .top-rank{width:26px;height:26px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:900;flex-shrink:0}
        .top-rank.r1{background:#fef9c3;color:#854d0e}
        .top-rank.r2{background:#f1f5f9;color:#475569}
        .top-rank.r3{background:#fef3c7;color:#92400e}
        .top-rank.rn{background:var(--green-pale);color:var(--green-dark)}
        .top-info{flex:1;min-width:0}
        .top-name{font-size:13px;font-weight:800;color:var(--text-dark);white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
        .top-qty{font-size:11px;font-weight:700;color:var(--text-muted)}
        .top-rev{font-size:12px;font-weight:900;color:var(--green-dark);white-space:nowrap}
        .top-bar-wrap{margin-top:4px;height:4px;background:var(--border);border-radius:3px;overflow:hidden}
        .top-bar-fill{height:100%;border-radius:3px;background:linear-gradient(90deg,var(--green-mid),var(--green-main))}

        /* ── Tabel riwayat ────────────────────────────────────────────── */
        .table-card{background:white;border:1px solid var(--border);border-radius:var(--r);overflow:hidden;margin-bottom:22px}
        .table-head-bar{display:flex;align-items:center;justify-content:space-between;padding:16px 20px;border-bottom:1px solid var(--border)}
        .table-scroll{overflow-x:auto}
        table{width:100%;border-collapse:collapse;font-size:13px}
        thead th{background:var(--green-pale);color:var(--green-dark);font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:.8px;padding:11px 16px;text-align:left;white-space:nowrap}
        tbody tr{border-bottom:1px solid var(--border);transition:background .15s}
        tbody tr:hover{background:var(--green-pale)}
        tbody tr:last-child{border-bottom:none}
        td{padding:11px 16px;color:var(--text-dark);vertical-align:middle}
        .td-product{font-weight:800}
        .td-order{font-size:11px;font-weight:700;color:var(--text-muted)}
        .td-price{font-weight:800;color:var(--green-dark)}
        .td-qty{font-weight:700;text-align:center}

        /* Status badge */
        .status-badge{display:inline-flex;align-items:center;gap:5px;font-size:11px;font-weight:800;padding:3px 10px;border-radius:20px;white-space:nowrap}
        .status-badge.delivered{background:#dcfce7;color:#166534}
        .status-badge.paid{background:#dbeafe;color:#1e40af}
        .status-badge.processing{background:#fef9c3;color:#854d0e}
        .status-badge.shipped{background:#e0f2fe;color:#0369a1}
        .status-badge.cancelled{background:#fee2e2;color:#b91c1c}
        .status-badge.refunded{background:#fce7f3;color:#9d174d}
        .status-badge.pending_payment{background:#f3f4f6;color:#374151}
        .offer-tag{font-size:10px;font-weight:700;background:var(--purple-soft);color:var(--purple);padding:2px 7px;border-radius:10px;margin-left:4px}

        /* ── Empty state ──────────────────────────────────────────────── */
        .empty-state{text-align:center;padding:50px 20px}
        .empty-state i{font-size:48px;color:var(--border);margin-bottom:12px;display:block}
        .empty-state h3{font-size:16px;font-weight:800;color:var(--text-mid);margin-bottom:5px}
        .empty-state p{font-size:13px;color:var(--text-muted);font-weight:600}

        /* ── Pagination ───────────────────────────────────────────────── */
        .pagination-wrap{display:flex;justify-content:center;gap:6px;padding:16px 20px;border-top:1px solid var(--border)}
        .pagination-wrap a,.pagination-wrap span{padding:7px 13px;border-radius:8px;font-size:13px;font-weight:700;border:1.5px solid var(--border);text-decoration:none;color:var(--text-mid);background:white;transition:all .18s}
        .pagination-wrap a:hover{border-color:var(--green-main);color:var(--green-dark)}
        .pagination-wrap span.active-page{background:var(--green-main);color:white;border-color:var(--green-main)}

        /* ── Animations ───────────────────────────────────────────────── */
        @keyframes fadeUp{from{opacity:0;transform:translateY(14px)}to{opacity:1;transform:translateY(0)}}
        .anim-1{animation:fadeUp .45s ease both}
        .anim-2{animation:fadeUp .45s .07s ease both}
        .anim-3{animation:fadeUp .45s .14s ease both}
        .anim-4{animation:fadeUp .45s .21s ease both}

        @media(max-width:1100px){.two-col{grid-template-columns:1fr}}
        @media(max-width:768px){
            .seller-sidebar{display:none}
            .seller-main{padding:16px}
            .stats-bar{grid-template-columns:1fr 1fr}
        }
        @media(max-width:480px){.stats-bar{grid-template-columns:1fr}}
    </style>
</head>
<body>

<div class="seller-wrap">

    {{-- ══ SIDEBAR ══ --}}
    @include('partials.seller_sidebar')

    {{-- ══ MAIN ══ --}}
    <main class="seller-main">

        {{-- ── Page Header ──────────────────────────────────────────────── --}}
        <div class="page-header anim-1">
            <div class="page-header-left">
                <h1>Laporan Penjualan <i class="fa-solid fa-chart-line" style="font-size:22px;color:var(--green-main)"></i></h1>
                <p>Pantau performa penjualan dan pendapatan toko Anda secara real-time.</p>
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
        <form method="GET" action="{{ route('seller.laporan.index') }}" id="filterForm">
            <div class="filter-card anim-2">
                <div class="filter-group">
                    <span class="filter-label">Periode</span>
                    <select name="periode" class="filter-select" id="periodeSelect" onchange="toggleCustom(); this.form.submit()">
                        @foreach([
                            'hari_ini'   => 'Hari Ini',
                            'minggu_ini' => 'Minggu Ini',
                            'bulan_ini'  => 'Bulan Ini',
                            'bulan_lalu' => 'Bulan Lalu',
                            'tahun_ini'  => 'Tahun Ini',
                            'custom'     => 'Rentang Kustom',
                        ] as $val => $label)
                        <option value="{{ $val }}" {{ $periode === $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Rentang kustom --}}
                <div class="custom-range {{ $periode === 'custom' ? 'show' : '' }}" id="customRange">
                    <div class="filter-group">
                        <span class="filter-label">Dari</span>
                        <input type="date" name="start_date" class="filter-input"
                            value="{{ $periode === 'custom' ? $startDate->format('Y-m-d') : '' }}">
                    </div>
                    <div class="filter-group">
                        <span class="filter-label">Sampai</span>
                        <input type="date" name="end_date" class="filter-input"
                            value="{{ $periode === 'custom' ? $endDate->format('Y-m-d') : '' }}">
                    </div>
                    <button type="submit" class="btn-green" style="height:38px;white-space:nowrap">
                        <i class="fa-solid fa-filter"></i> Terapkan
                    </button>
                </div>

                <div class="filter-group">
                    <span class="filter-label">Status Order</span>
                    <select name="status" class="filter-select" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        @foreach([
                            'paid'            => '💰 Dibayar',
                            'processing'      => '⚙️ Diproses',
                            'shipped'         => '🚚 Dikirim',
                            'delivered'       => '✅ Selesai',
                            'cancelled'       => '❌ Dibatalkan',
                        ] as $val => $label)
                        <option value="{{ $val }}" {{ $filterStatus === $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div style="margin-left:auto;display:flex;align-items:flex-end">
                    <span style="font-size:12px;font-weight:700;color:var(--text-muted);padding-bottom:9px">
                        <i class="fa-regular fa-calendar-days"></i>
                        {{ $startDate->isoFormat('D MMM YYYY') }} – {{ $endDate->isoFormat('D MMM YYYY') }}
                    </span>
                </div>
            </div>
        </form>

        {{-- ── Stats Bar ─────────────────────────────────────────────────── --}}
        <div class="stats-bar anim-2">
            {{-- Total Pendapatan --}}
            <div class="stat-card green">
                <div class="stat-icon green"><i class="fa-solid fa-wallet"></i></div>
                <div class="stat-label">Total Pendapatan</div>
                <div class="stat-value">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
                <div class="stat-sub {{ $growthPersen >= 0 ? 'up' : 'down' }}">
                    <i class="fa-solid fa-arrow-{{ $growthPersen >= 0 ? 'up' : 'down' }}-right"></i>
                    {{ abs($growthPersen) }}% vs periode sebelumnya
                </div>
            </div>

            {{-- Total Order --}}
            <div class="stat-card blue">
                <div class="stat-icon blue"><i class="fa-solid fa-bag-shopping"></i></div>
                <div class="stat-label">Total Order</div>
                <div class="stat-value">{{ number_format($totalOrder) }}</div>
                <div class="stat-sub neutral">
                    <i class="fa-solid fa-box"></i> Transaksi berhasil
                </div>
            </div>

            {{-- Item Terjual --}}
            <div class="stat-card purple">
                <div class="stat-icon purple"><i class="fa-solid fa-scale-balanced"></i></div>
                <div class="stat-label">Item Terjual</div>
                <div class="stat-value">{{ number_format($totalItemTerjual) }}</div>
                <div class="stat-sub neutral">
                    <i class="fa-solid fa-wheat-awn"></i> Unit produk
                </div>
            </div>

            {{-- Rata-rata Order --}}
            <div class="stat-card orange">
                <div class="stat-icon orange"><i class="fa-solid fa-calculator"></i></div>
                <div class="stat-label">Rata-rata / Order</div>
                <div class="stat-value small">Rp {{ number_format($rataRataOrder, 0, ',', '.') }}</div>
                <div class="stat-sub neutral">
                    <i class="fa-solid fa-chart-pie"></i> Nilai rata-rata
                </div>
            </div>
        </div>

        {{-- ── Grafik + Produk Terlaris ─────────────────────────────────── --}}
        <div class="two-col anim-3">

            {{-- Grafik Bulanan --}}
            <div class="chart-card">
                <div class="card-title">
                    <i class="fa-solid fa-chart-area"></i> Pendapatan 12 Bulan Terakhir
                </div>
                @php
                    $maxVal = collect($grafikData)->max('total');
                    $maxVal = $maxVal > 0 ? $maxVal : 1;
                @endphp
                <div class="chart-wrap">
                    <div class="bar-chart" id="barChart">
                        @foreach($grafikData as $g)
                        @php $pct = round(($g['total'] / $maxVal) * 100); @endphp
                        <div class="bar-col">
                            <div class="bar-fill"
                                style="height: {{ max($pct, $g['total'] > 0 ? 3 : 0) }}%"
                                data-tooltip="Rp {{ number_format($g['total'], 0, ',', '.') }}"
                                title="{{ $g['bulan'] }}: Rp {{ number_format($g['total'], 0, ',', '.') }}">
                            </div>
                            <span class="bar-label">{{ $g['bulan'] }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                {{-- Legenda nilai maks --}}
                <div style="margin-top:8px;display:flex;justify-content:flex-end">
                    <span style="font-size:11px;font-weight:700;color:var(--text-muted)">
                        Puncak: <strong style="color:var(--green-dark)">Rp {{ number_format($maxVal, 0, ',', '.') }}</strong>
                    </span>
                </div>
            </div>

            {{-- Produk Terlaris --}}
            <div class="chart-card">
                <div class="card-title">
                    <i class="fa-solid fa-trophy"></i> Produk Terlaris
                </div>
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
                    @php
                        $rankClass = match($i) { 0=>'r1', 1=>'r2', 2=>'r3', default=>'rn' };
                        $barPct = $maxQty > 0 ? round(($prod->total_qty / $maxQty) * 100) : 0;
                    @endphp
                    <div class="top-item">
                        <div class="top-rank {{ $rankClass }}">{{ $i + 1 }}</div>
                        <div class="top-info">
                            <div class="top-name">{{ $prod->product_name }}</div>
                            <div class="top-bar-wrap">
                                <div class="top-bar-fill" style="width:{{ $barPct }}%"></div>
                            </div>
                            <div class="top-qty">{{ number_format($prod->total_qty) }} unit terjual</div>
                        </div>
                        <div class="top-rev">Rp {{ number_format($prod->total_revenue, 0, ',', '.') }}</div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>

        {{-- ── Tabel Riwayat Transaksi ───────────────────────────────────── --}}
        <div class="table-card anim-4">
            <div class="table-head-bar">
                <div class="card-title" style="margin-bottom:0">
                    <i class="fa-solid fa-list-ul"></i> Riwayat Transaksi
                    <span style="font-size:12px;font-weight:700;color:var(--text-muted);margin-left:4px">({{ $riwayat->total() }} item)</span>
                </div>
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
                            $order       = $item->order;
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
                                @if($order->buyer)
                                <div class="td-order"><i class="fa-solid fa-user" style="font-size:10px"></i> {{ $order->buyer->nama_lengkap ?? '-' }}</div>
                                @endif
                            </td>
                            <td>
                                <div style="font-size:13px;font-weight:700">{{ optional($item->created_at)->isoFormat('D MMM YYYY') }}</div>
                                <div class="td-order">{{ optional($item->created_at)->format('H:i') }} WIB</div>
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

            {{-- Pagination --}}
            @if($riwayat->hasPages())
            <div class="pagination-wrap">
                {{ $riwayat->links() }}
            </div>
            @endif
            @endif
        </div>

    </main>
</div>

<script>
    // Toggle rentang kustom
    function toggleCustom() {
        const val = document.getElementById('periodeSelect').value;
        const el  = document.getElementById('customRange');
        el.classList.toggle('show', val === 'custom');
    }

    // Animasi bar saat load
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.bar-fill').forEach(bar => {
            const target = bar.style.height;
            bar.style.height = '0';
            setTimeout(() => { bar.style.height = target; }, 100);
        });
    });
</script>

</body>
</html>