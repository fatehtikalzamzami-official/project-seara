@extends('layouts.app')

@section('title', 'Dashboard Admin')
@section('hide-footer', true)

@push('styles')
<style>
/* ── Dashboard overrides ── */
#app-content { display: flex; }

/* Sidebar */
.dash-sidebar {
    width: 260px; flex-shrink: 0;
    background: #0f2b1a;
    border-right: 1px solid rgba(46,216,122,0.12);
    min-height: calc(100vh - 116px);
    display: flex; flex-direction: column;
    position: sticky; top: 116px;
    height: calc(100vh - 116px);
    overflow-y: auto;
}
.sidebar-section { padding: 20px 16px 8px; font-size: 10px; font-weight: 600; letter-spacing: 2px; text-transform: uppercase; color: #4a6a55; }
.nav-side-item {
    display: flex; align-items: center; gap: 12px;
    padding: 11px 20px; margin: 2px 8px;
    border-radius: 10px; cursor: pointer;
    transition: all 0.2s; color: #7aaa8a;
    font-size: 14px; font-weight: 500; text-decoration: none;
    position: relative;
}
.nav-side-item:hover { background: rgba(46,216,122,0.08); color: #e8f0eb; }
.nav-side-item.active { background: rgba(46,216,122,0.12); color: #2ed87a; font-weight: 600; border: 1px solid rgba(46,216,122,0.2); }
.nav-side-item.active::before { content: ''; position: absolute; left: -8px; top: 50%; transform: translateY(-50%); width: 3px; height: 20px; background: #2ed87a; border-radius: 2px; }
.nav-side-item svg { width: 17px; height: 17px; opacity: 0.8; flex-shrink: 0; }
.side-badge { margin-left: auto; background: #2ed87a; color: #0a1f14; font-size: 10px; font-weight: 800; padding: 2px 7px; border-radius: 20px; }

.sidebar-user { margin-top: auto; padding: 16px; border-top: 1px solid rgba(46,216,122,0.1); }
.sidebar-user-card { display: flex; align-items: center; gap: 10px; background: rgba(46,216,122,0.06); border: 1px solid rgba(46,216,122,0.12); border-radius: 10px; padding: 10px 12px; cursor: pointer; }
.su-ava { width: 34px; height: 34px; border-radius: 50%; background: linear-gradient(135deg, #1a9a52, #2ed87a); display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 800; color: #0a1f14; flex-shrink: 0; }
.su-name { font-size: 13px; font-weight: 600; color: #e8f0eb; }
.su-role { font-size: 11px; color: #4a6a55; }

/* Main area */
.dash-main { flex: 1; min-height: calc(100vh - 116px); background: #0a1f14; overflow-y: auto; }
.dash-content { padding: 28px 32px 48px; }

.dash-greeting { margin-bottom: 24px; animation: fadeUp 0.5s ease both; }
.dash-greeting h1 { font-family: 'Playfair Display', serif; font-size: 28px; font-weight: 600; color: #e8f0eb; margin-bottom: 4px; }
.dash-greeting p { font-size: 14px; color: #7aaa8a; }

/* Stats */
.stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 22px; animation: fadeUp 0.5s 0.08s ease both; }
.stat-card { background: #132d1c; border: 1px solid rgba(46,216,122,0.12); border-radius: 14px; padding: 20px 20px 16px; position: relative; overflow: hidden; transition: all 0.25s; cursor: default; }
.stat-card:hover { border-color: rgba(46,216,122,0.25); background: #1a3a25; transform: translateY(-2px); box-shadow: 0 12px 40px rgba(0,0,0,0.3); }
.stat-card::after { content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 2px; background: linear-gradient(90deg, transparent, #2ed87a, transparent); opacity: 0; transition: opacity 0.25s; }
.stat-card:hover::after { opacity: 1; }
.stat-label { font-size: 12px; color: #4a6a55; letter-spacing: 0.5px; margin-bottom: 10px; font-weight: 600; }
.stat-value { font-family: 'Playfair Display', serif; font-size: 26px; font-weight: 700; color: #e8f0eb; margin-bottom: 6px; line-height: 1; }
.stat-change { display: inline-flex; align-items: center; gap: 4px; font-size: 12px; font-weight: 600; }
.stat-change.up { color: #2ed87a; }
.stat-change.down { color: #e05c5c; }
.stat-icon { position: absolute; top: 16px; right: 16px; width: 36px; height: 36px; background: rgba(46,216,122,0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 18px; }

/* Chart + Activity */
.two-col { display: grid; grid-template-columns: 1fr 360px; gap: 18px; margin-bottom: 20px; animation: fadeUp 0.5s 0.16s ease both; }

.dash-card { background: #132d1c; border: 1px solid rgba(46,216,122,0.12); border-radius: 14px; overflow: hidden; }
.dash-card-hd { padding: 18px 20px 0; display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px; }
.dash-card-title { font-family: 'Playfair Display', serif; font-size: 16px; font-weight: 600; color: #e8f0eb; }
.dash-card-action { font-size: 12px; color: #2ed87a; cursor: pointer; font-weight: 600; text-decoration: none; transition: opacity 0.2s; }
.dash-card-action:hover { opacity: 0.7; }

/* Chart bars */
.chart-wrap { padding: 0 20px 18px; }
.chart-bars { display: flex; align-items: flex-end; gap: 6px; height: 100px; }
.bar-group { flex: 1; display: flex; align-items: flex-end; gap: 2px; }
.bar { flex: 1; border-radius: 4px 4px 0 0; cursor: default; }
.bar:hover { opacity: 0.7; }
.bar-primary { background: #2ed87a; }
.bar-secondary { background: rgba(46,216,122,0.2); }
.chart-labels { display: flex; gap: 6px; margin-top: 8px; }
.chart-label { flex: 1; text-align: center; font-size: 10px; color: #4a6a55; }

/* Activity */
.activity-feed { padding: 0 20px 18px; }
.activity-item { display: flex; gap: 10px; padding: 10px 0; border-bottom: 1px solid rgba(46,216,122,0.08); }
.activity-item:last-child { border-bottom: none; }
.act-dot { width: 34px; height: 34px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 15px; flex-shrink: 0; margin-top: 2px; }
.dot-g { background: rgba(46,216,122,0.12); }
.dot-b { background: rgba(86,150,255,0.12); }
.dot-y { background: rgba(255,180,0,0.12); }
.act-msg { font-size: 13px; color: #e8f0eb; line-height: 1.5; }
.act-msg strong { color: #2ed87a; font-weight: 600; }
.act-time { font-size: 11px; color: #4a6a55; margin-top: 2px; }

/* Orders table */
.dash-table-wrap { animation: fadeUp 0.5s 0.24s ease both; margin-bottom: 20px; }
.dash-table { width: 100%; border-collapse: collapse; }
.dash-table th { text-align: left; padding: 0 20px 10px; font-size: 11px; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; color: #4a6a55; border-bottom: 1px solid rgba(46,216,122,0.1); }
.dash-table td { padding: 12px 20px; font-size: 13px; border-bottom: 1px solid rgba(46,216,122,0.06); vertical-align: middle; color: #e8f0eb; }
.dash-table tr:last-child td { border-bottom: none; }
.dash-table tr:hover td { background: rgba(46,216,122,0.04); }
.order-id { color: #2ed87a; font-weight: 600; font-size: 12px; }
.order-prod { display: flex; align-items: center; gap: 10px; }
.prod-thumb { width: 32px; height: 32px; border-radius: 8px; background: #0f2b1a; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0; }
.pname { font-size: 13px; font-weight: 600; color: #e8f0eb; }
.pfarm { font-size: 11px; color: #4a6a55; }
.badge { display: inline-flex; align-items: center; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; }
.badge-success { background: rgba(46,216,122,0.1); color: #2ed87a; }
.badge-pending { background: rgba(255,180,0,0.1); color: #ffb400; }
.badge-process { background: rgba(86,150,255,0.1); color: #5696ff; }
.badge-cancel  { background: rgba(224,92,92,0.1); color: #e05c5c; }

/* Products + Commodity */
.bottom-col { display: grid; grid-template-columns: 1fr 360px; gap: 18px; animation: fadeUp 0.5s 0.32s ease both; }
.prod-mini-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; padding: 0 20px 20px; }
.pmini { background: #0f2b1a; border: 1px solid rgba(46,216,122,0.1); border-radius: 10px; padding: 14px; cursor: pointer; transition: all 0.2s; }
.pmini:hover { border-color: rgba(46,216,122,0.25); background: #1a3a25; }
.pmini-em { font-size: 28px; margin-bottom: 8px; }
.pmini-name { font-size: 12px; font-weight: 700; color: #e8f0eb; margin-bottom: 2px; }
.pmini-farm { font-size: 10px; color: #4a6a55; margin-bottom: 8px; }
.pmini-price { font-family: 'Playfair Display', serif; font-size: 14px; font-weight: 700; color: #2ed87a; }
.add-btn-mini { width: 24px; height: 24px; background: #2ed87a; border: none; border-radius: 6px; color: #0a1f14; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 15px; font-weight: 700; transition: opacity 0.2s; }
.add-btn-mini:hover { opacity: 0.8; }

/* Commodity prices */
.commodity-list { padding: 0 20px 20px; }
.commodity-item { display: flex; align-items: center; gap: 10px; padding: 10px 0; border-bottom: 1px solid rgba(46,216,122,0.08); transition: padding-left 0.2s; cursor: default; }
.commodity-item:last-child { border-bottom: none; }
.commodity-item:hover { padding-left: 4px; }
.com-em { width: 38px; height: 38px; background: #0f2b1a; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0; }
.com-name { font-size: 13px; font-weight: 600; color: #e8f0eb; }
.com-loc { font-size: 11px; color: #4a6a55; }
.com-price { text-align: right; margin-left: auto; }
.com-val { font-family: 'Playfair Display', serif; font-size: 14px; font-weight: 700; color: #e8f0eb; }
.com-chg { font-size: 11px; font-weight: 600; }
.com-chg.up { color: #2ed87a; }
.com-chg.down { color: #e05c5c; }

/* Quick actions */
.quick-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; padding: 0 20px 20px; }
.quick-item { display: flex; flex-direction: column; align-items: center; gap: 7px; padding: 14px 8px; background: #0f2b1a; border: 1px solid rgba(46,216,122,0.1); border-radius: 10px; cursor: pointer; transition: all 0.2s; text-decoration: none; }
.quick-item:hover { border-color: rgba(46,216,122,0.25); background: #1a3a25; }
.quick-item span:first-child { font-size: 22px; }
.quick-item span:last-child { font-size: 11px; color: #7aaa8a; font-weight: 600; text-align: center; }

/* Back to shop link */
.back-to-shop { display: inline-flex; align-items: center; gap: 6px; font-size: 13px; font-weight: 700; color: #2ed87a; margin-bottom: 20px; text-decoration: none; transition: opacity 0.2s; }
.back-to-shop:hover { opacity: 0.7; }

@keyframes fadeUp { from { opacity: 0; transform: translateY(16px); } to { opacity: 1; transform: translateY(0); } }
</style>
@endpush

@section('content')

{{-- Sidebar --}}
<aside class="dash-sidebar">
    <div class="sidebar-section">Utama</div>
    <a href="{{ route('dashboard') }}" class="nav-side-item active">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/></svg>
        Dashboard
    </a>
    <a href="#" class="nav-side-item">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
        Pesanan
        <span class="side-badge">12</span>
    </a>
    <a href="#" class="nav-side-item">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
        Produk
    </a>
    <a href="#" class="nav-side-item">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"/></svg>
        Petani
    </a>
    <a href="#" class="nav-side-item">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
        Pesan
        <span class="side-badge">3</span>
    </a>

    <div class="sidebar-section">Keuangan</div>
    <a href="#" class="nav-side-item">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
        Laporan
    </a>
    <a href="#" class="nav-side-item">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
        Pembayaran
    </a>
    <a href="#" class="nav-side-item">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><circle cx="12" cy="12" r="3"/></svg>
        Pengaturan
    </a>

    <div class="sidebar-user">
        <div class="sidebar-user-card">
            <div class="su-ava">AB</div>
            <div>
                <div class="su-name">Ahmad Budiman</div>
                <div class="su-role">Admin Toko</div>
            </div>
        </div>
    </div>
</aside>

{{-- Dashboard Main --}}
<div class="dash-main">
    <div class="dash-content">

        <a href="{{ route('home') }}" class="back-to-shop">
            ← Kembali ke Toko
        </a>

        <div class="dash-greeting">
            <h1>Selamat Pagi, Ahmad 👋</h1>
            <p>{{ now()->isoFormat('dddd, D MMMM Y') }} — Berikut ringkasan aktivitas hari ini</p>
        </div>

        {{-- Stats --}}
        <div class="stats-grid">
            @foreach([
                ['Total Penjualan','Rp 48,2M','up','▲ 12,5% dari bulan lalu','💰'],
                ['Pesanan Aktif','284','up','▲ 8 pesanan baru hari ini','📦'],
                ['Petani Terdaftar','1.204','up','▲ 24 petani minggu ini','👨‍🌾'],
                ['Komoditas Tersedia','96','down','▼ 3 stok habis','🌿'],
            ] as $s)
            <div class="stat-card">
                <div class="stat-label">{{ $s[0] }}</div>
                <div class="stat-value">{{ $s[1] }}</div>
                <span class="stat-change {{ $s[2] }}">{{ $s[3] }}</span>
                <div class="stat-icon">{{ $s[4] }}</div>
            </div>
            @endforeach
        </div>

        {{-- Chart + Activity --}}
        <div class="two-col">
            <div class="dash-card">
                <div class="dash-card-hd">
                    <div class="dash-card-title">Grafik Penjualan — {{ now()->isoFormat('MMMM Y') }}</div>
                    <a href="#" class="dash-card-action">Lihat semua →</a>
                </div>
                <div class="chart-wrap">
                    <div style="display:flex;align-items:center;gap:16px;margin-bottom:14px">
                        <div style="display:flex;align-items:center;gap:6px;"><div style="width:10px;height:10px;border-radius:3px;background:#2ed87a"></div><span style="font-size:11px;color:#4a6a55">Penjualan</span></div>
                        <div style="display:flex;align-items:center;gap:6px;"><div style="width:10px;height:10px;border-radius:3px;background:rgba(46,216,122,0.2)"></div><span style="font-size:11px;color:#4a6a55">Target</span></div>
                        <div style="margin-left:auto;font-family:'Playfair Display',serif;font-size:20px;color:#2ed87a">Rp 48,2 Juta</div>
                    </div>
                    <div class="chart-bars">
                        @foreach([45,60,38,72,65,85,78,100,68,80,55,70] as $h)
                        <div class="bar-group">
                            <div class="bar bar-secondary" style="height:{{ $h * 0.9 }}%"></div>
                            <div class="bar bar-primary" style="height:{{ $h }}%"></div>
                        </div>
                        @endforeach
                    </div>
                    <div class="chart-labels">
                        @foreach(['1','4','7','10','13','16','19','22','25','28','30','Apr'] as $l)
                        <div class="chart-label">{{ $l }}</div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="dash-card">
                <div class="dash-card-hd">
                    <div class="dash-card-title">Aktivitas Terkini</div>
                    <a href="#" class="dash-card-action">Semua →</a>
                </div>
                <div class="activity-feed">
                    @foreach([
                        ['📦','dot-g','Pesanan <strong>#ORD-2841</strong> dikonfirmasi Pak Slamet','5 menit lalu'],
                        ['👤','dot-b','Petani baru <strong>Ibu Sari Dewi</strong> bergabung dari Malang','23 menit lalu'],
                        ['⚠️','dot-y','Stok <strong>Cabai Merah</strong> hampir habis — 5 kg','1 jam lalu'],
                        ['💰','dot-g','Pembayaran <strong>Rp 2.400.000</strong> dari Toko Makmur','2 jam lalu'],
                        ['⭐','dot-b','Ulasan bintang 5 untuk <strong>Beras Premium</strong>','3 jam lalu'],
                    ] as $a)
                    <div class="activity-item">
                        <div class="act-dot {{ $a[1] }}">{{ $a[0] }}</div>
                        <div>
                            <div class="act-msg">{!! $a[2] !!}</div>
                            <div class="act-time">{{ $a[3] }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Orders Table --}}
        <div class="dash-table-wrap">
            <div class="dash-card">
                <div class="dash-card-hd">
                    <div class="dash-card-title">Pesanan Masuk Terbaru</div>
                    <a href="#" class="dash-card-action">Lihat semua pesanan →</a>
                </div>
                <table class="dash-table">
                    <thead>
                        <tr>
                            <th>ID Pesanan</th><th>Produk</th><th>Pembeli</th>
                            <th>Qty</th><th>Total</th><th>Status</th><th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach([
                            ['#ORD-2841','🌾','Beras Pandan Wangi','Pak Hendra · Cianjur','Toko Sumber Rejeki','50 kg','Rp 750.000','success','Selesai'],
                            ['#ORD-2840','🥦','Brokoli Organik','Ibu Ratna · Lembang','CV Hijau Segar','20 kg','Rp 320.000','process','Proses'],
                            ['#ORD-2839','🌶️','Cabai Merah Keriting','Pak Joko · Kediri','Pasar Induk Utara','100 kg','Rp 4.200.000','pending','Menunggu'],
                            ['#ORD-2838','🧅','Bawang Putih Lokal','Pak Slamet · Brebes','Restoran Nusantara','30 kg','Rp 1.080.000','success','Selesai'],
                            ['#ORD-2837','🍅','Tomat Cherry','Ibu Dewi · Malang','Supermarket Fresh','15 kg','Rp 225.000','cancel','Dibatalkan'],
                        ] as $o)
                        <tr>
                            <td><span class="order-id">{{ $o[0] }}</span></td>
                            <td>
                                <div class="order-prod">
                                    <div class="prod-thumb">{{ $o[1] }}</div>
                                    <div><div class="pname">{{ $o[2] }}</div><div class="pfarm">{{ $o[3] }}</div></div>
                                </div>
                            </td>
                            <td>{{ $o[4] }}</td>
                            <td>{{ $o[5] }}</td>
                            <td>{{ $o[6] }}</td>
                            <td><span class="badge badge-{{ $o[7] }}">{{ $o[8] }}</span></td>
                            <td style="color:#4a6a55;font-size:12px">{{ now()->subDays(rand(0,2))->format('d M Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Products + Commodity --}}
        <div class="bottom-col">
            <div class="dash-card">
                <div class="dash-card-hd">
                    <div class="dash-card-title">Produk Unggulan</div>
                    <a href="#" class="dash-card-action">Kelola produk →</a>
                </div>
                <div class="prod-mini-grid">
                    @foreach([
                        ['🌾','Beras Pandan Wangi','Pak Hendra','Rp 15.000'],
                        ['🥦','Brokoli Organik','Ibu Ratna','Rp 16.000'],
                        ['🌽','Jagung Manis','Pak Agus','Rp 8.000'],
                        ['🥕','Wortel Premium','Bu Susi','Rp 12.000'],
                        ['🧄','Bawang Putih','Pak Slamet','Rp 36.000'],
                        ['🍆','Terong Ungu','Pak Budi','Rp 9.000'],
                    ] as $p)
                    <div class="pmini">
                        <div class="pmini-em">{{ $p[0] }}</div>
                        <div class="pmini-name">{{ $p[1] }}</div>
                        <div class="pmini-farm">{{ $p[2] }}</div>
                        <div style="display:flex;align-items:center;justify-content:space-between">
                            <div class="pmini-price">{{ $p[3] }}/kg</div>
                            <button class="add-btn-mini">+</button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div style="display:flex;flex-direction:column;gap:16px">
                <div class="dash-card">
                    <div class="dash-card-hd">
                        <div class="dash-card-title">Harga Komoditas</div>
                        <a href="#" class="dash-card-action">Update →</a>
                    </div>
                    <div class="commodity-list">
                        @foreach([
                            ['🌾','Beras IR64','Cianjur, Jabar','Rp 13.500/kg','up','▲ 2,1%'],
                            ['🌶️','Cabai Merah','Kediri, Jatim','Rp 42.000/kg','down','▼ 5,3%'],
                            ['🧅','Bawang Merah','Brebes, Jateng','Rp 28.000/kg','up','▲ 1,4%'],
                            ['🥔','Kentang','Dieng, Jateng','Rp 14.000/kg','up','▲ 0,7%'],
                        ] as $c)
                        <div class="commodity-item">
                            <div class="com-em">{{ $c[0] }}</div>
                            <div><div class="com-name">{{ $c[1] }}</div><div class="com-loc">{{ $c[2] }}</div></div>
                            <div class="com-price">
                                <div class="com-val">{{ $c[3] }}</div>
                                <div class="com-chg {{ $c[4] }}">{{ $c[5] }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="dash-card">
                    <div class="dash-card-hd">
                        <div class="dash-card-title">Aksi Cepat</div>
                    </div>
                    <div class="quick-grid">
                        @foreach([['➕','Tambah Produk'],['👨‍🌾','Daftar Petani'],['📊','Ekspor Laporan'],['🚚','Lacak Kirim']] as $q)
                        <a href="#" class="quick-item">
                            <span>{{ $q[0] }}</span>
                            <span>{{ $q[1] }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
