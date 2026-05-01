@extends('layouts.app')

@section('title', 'Belanja Produk Petani')

@push('styles')
<style>
.trust-bar { background: white; border-top: 1px solid var(--border); border-bottom: 1px solid var(--border); }
.trust-inner { max-width: 1280px; margin: 0 auto; padding: 12px 24px; display: flex; align-items: center; justify-content: space-between; }
.trust-item { display: flex; align-items: center; gap: 10px; font-size: 13px; font-weight: 700; color: var(--text-mid); }
.trust-item span { font-size: 20px; }
.trust-div { width: 1px; height: 30px; background: var(--border); }

.page { max-width: 1280px; margin: 0 auto; padding: 20px 24px 60px; }

/* Hero */
.hero-section { display: grid; grid-template-columns: 1fr 320px; gap: 16px; margin-bottom: 20px; animation: fadeUp 0.5s ease both; }
.hero-main {
    background: linear-gradient(135deg, var(--green-dark) 0%, var(--green-main) 55%, #5aad60 100%);
    border-radius: var(--r); padding: 40px 44px;
    position: relative; overflow: hidden; min-height: 220px;
    display: flex; align-items: center; box-shadow: var(--shadow-md);
}
.hero-main::before {
    content: ''; position: absolute; inset: 0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}
.hero-circles { position: absolute; right: -40px; top: -40px; width: 280px; height: 280px; background: rgba(255,255,255,0.05); border-radius: 50%; }
.hero-circles::after { content: ''; position: absolute; inset: 30px; background: rgba(255,255,255,0.04); border-radius: 50%; }
.hero-content { position: relative; z-index: 1; }
.hero-tag { background: var(--accent); color: white; font-size: 11px; font-weight: 800; padding: 4px 10px; border-radius: 4px; letter-spacing: 1px; display: inline-block; margin-bottom: 12px; text-transform: uppercase; }
.hero-title { font-family: 'Playfair Display', serif; font-size: 36px; font-weight: 700; color: white; line-height: 1.2; margin-bottom: 10px; }
.hero-title span { color: #a8e6a8; }
.hero-sub { color: rgba(255,255,255,0.75); font-size: 14px; margin-bottom: 22px; font-weight: 500; }
.hero-btn { background: white; color: var(--green-dark); border: none; padding: 11px 24px; border-radius: 8px; font-weight: 800; font-size: 14px; display: inline-flex; align-items: center; gap: 8px; transition: transform 0.2s, box-shadow 0.2s; box-shadow: 0 4px 14px rgba(0,0,0,0.15); cursor: pointer; text-decoration: none; }
.hero-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,0,0,0.2); }
.hero-side { display: flex; flex-direction: column; gap: 12px; }
.side-banner { flex: 1; border-radius: var(--r); padding: 20px; display: flex; flex-direction: column; justify-content: flex-end; position: relative; overflow: hidden; min-height: 100px; box-shadow: var(--shadow-sm); cursor: pointer; transition: transform 0.2s; }
.side-banner:hover { transform: translateY(-2px); }
.side-banner-1 { background: linear-gradient(135deg, #ff6b35, #ff8c5a); }
.side-banner-2 { background: linear-gradient(135deg, #ffc107, #ffdd57); }
.side-banner-emoji { font-size: 36px; position: absolute; right: 14px; top: 14px; }
.side-banner-label { color: white; font-size: 12px; font-weight: 700; opacity: 0.85; text-transform: uppercase; letter-spacing: 1px; }
.side-banner-title { color: white; font-weight: 900; font-size: 18px; line-height: 1.2; }
.side-banner-2 .side-banner-label, .side-banner-2 .side-banner-title { color: #5a3e00; }

/* Section headers */
.section-hd { display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px; }
.section-hd h2 { font-size: 20px; font-weight: 800; color: var(--text-dark); display: flex; align-items: center; gap: 8px; }
.section-hd h2::before { content: ''; display: block; width: 4px; height: 22px; background: var(--green-main); border-radius: 2px; }
.see-all { font-size: 13px; font-weight: 700; color: var(--green-main); display: flex; align-items: center; gap: 4px; transition: color 0.2s; }
.see-all:hover { color: var(--green-dark); }

/* Categories */
.cats-grid { display: flex; gap: 12px; flex-wrap: wrap; }
.cat-item { display: flex; flex-direction: column; align-items: center; gap: 8px; padding: 16px 14px; background: white; border: 2px solid var(--border); border-radius: var(--r); cursor: pointer; transition: all 0.2s; min-width: 88px; flex: 1; max-width: 110px; }
.cat-item:hover, .cat-item.active { border-color: var(--green-main); background: var(--green-pale); transform: translateY(-2px); box-shadow: var(--shadow-sm); }
.cat-icon { width: 48px; height: 48px; background: var(--green-pale); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 24px; transition: background 0.2s; }
.cat-item:hover .cat-icon, .cat-item.active .cat-icon { background: var(--green-main); }
.cat-name { font-size: 12px; font-weight: 700; color: var(--text-mid); text-align: center; }

/* Flash Sale */
.flash-section { background: white; border-radius: var(--r); padding: 20px; margin-bottom: 20px; box-shadow: var(--shadow-sm); border: 1px solid var(--border); }
.flash-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px; }
.flash-title { display: flex; align-items: center; gap: 10px; font-size: 20px; font-weight: 900; color: var(--accent); }
.flash-countdown { display: flex; align-items: center; gap: 6px; font-size: 12px; font-weight: 600; color: var(--text-mid); }
.countdown-box { background: var(--green-dark); color: white; padding: 4px 9px; border-radius: 6px; font-weight: 800; font-size: 16px; font-variant-numeric: tabular-nums; min-width: 34px; text-align: center; }

/* Product cards */
.prod-grid {
    display: flex;
    gap: 14px;
    overflow-x: auto;
    scroll-behavior: smooth;
    padding-bottom: 6px;
}

.prod-grid::-webkit-scrollbar {
    height: 6px;
}
.prod-grid::-webkit-scrollbar-thumb {
    background: #ccc;
    border-radius: 10px;
}
.prod-grid-6 { grid-template-columns: repeat(6, 1fr); }
.prod-card { background: white; border: 1px solid var(--border); border-radius: var(--r); overflow: hidden; cursor: pointer; transition: all 0.25s; position: relative; min-width: 220px;
    max-width: 220px;
    flex-shrink: 0;}
.prod-card:hover { border-color: var(--green-main); transform: translateY(-4px); box-shadow: var(--shadow-md); }
.prod-img { width: 100%; aspect-ratio: 1; background: var(--green-pale); display: flex; align-items: center; justify-content: center; font-size: 56px; position: relative; }
.prod-badge { position: absolute; top: 8px; left: 8px; background: var(--accent); color: white; font-size: 10px; font-weight: 800; padding: 3px 7px; border-radius: 4px; z-index: 1; }
.prod-badge.organic { background: var(--green-main); }
.prod-badge.new-badge { background: #5696ff; }
/* Time badge — warna dinamis */
.prod-badge.time {
    background: #166534;  /* default hijau */
    color: #bbf7d0;
    transition: background 0.4s, color 0.4s;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}
.prod-badge.time.badge-yellow { background: #854d0e; color: #fef08a; }
.prod-badge.time.badge-red    { background: #991b1b; color: #fecaca; }
.prod-wishlist { position: absolute; top: 8px; right: 8px; width: 28px; height: 28px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 14px; box-shadow: 0 2px 6px rgba(0,0,0,0.12); z-index: 1; opacity: 0; transition: opacity 0.2s; border: none; cursor: pointer; }
.prod-card:hover .prod-wishlist { opacity: 1; }
.prod-body { padding: 12px; }
.prod-name { font-size: 13px; font-weight: 700; color: var(--text-dark); margin-bottom: 2px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.prod-farmer { font-size: 11px; color: var(--text-muted); margin-bottom: 8px; }
.prod-price-row { display: flex; align-items: baseline; gap: 6px; margin-bottom: 6px; }
.prod-price { font-size: 16px; font-weight: 900; color: var(--accent); }
.prod-unit { font-size: 11px; color: var(--text-muted); font-weight: 500; }
.prod-old-price { font-size: 11px; color: var(--text-muted); text-decoration: line-through; }
.prod-discount { font-size: 11px; font-weight: 800; color: var(--accent); background: var(--accent-soft); padding: 1px 5px; border-radius: 4px; }
.prod-meta { display: flex; align-items: center; justify-content: space-between; }
.prod-stars { display: flex; align-items: center; gap: 3px; font-size: 11px; color: var(--text-muted); }
.prod-stars span { color: var(--yellow); font-size: 12px; }
.prod-sold { font-size: 11px; color: var(--text-muted); }
.prod-location { font-size: 11px; color: var(--text-muted); display: flex; align-items: center; gap: 3px; margin-top: 4px; }
.add-to-cart-btn { width: 100%; background: var(--green-main); color: white; border: none; padding: 8px; border-radius: 7px; font-family: 'Nunito', sans-serif; font-weight: 800; font-size: 12px; margin-top: 10px; display: flex; align-items: center; justify-content: center; gap: 5px; transition: background 0.2s; cursor: pointer; }
.add-to-cart-btn:hover { background: var(--green-dark); }

/* Promo strip */
.promo-strip { display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px; margin-bottom: 20px; }
.promo-card { border-radius: var(--r); padding: 20px 22px; display: flex; align-items: center; gap: 14px; cursor: pointer; transition: transform 0.2s, box-shadow 0.2s; box-shadow: var(--shadow-sm); }
.promo-card:hover { transform: translateY(-2px); box-shadow: var(--shadow-md); }
.promo-card-1 { background: linear-gradient(135deg, #e8f5e9, #c8e6c9); }
.promo-card-2 { background: linear-gradient(135deg, #fff8e1, #ffecb3); }
.promo-card-3 { background: linear-gradient(135deg, #fce4ec, #f8bbd0); }
.promo-emoji { font-size: 40px; }
.promo-label { font-size: 11px; font-weight: 700; opacity: 0.6; text-transform: uppercase; letter-spacing: 1px; }
.promo-title { font-size: 16px; font-weight: 900; color: var(--text-dark); }
.promo-sub { font-size: 12px; color: var(--text-mid); font-weight: 500; margin-top: 2px; }

/* Farmers */
.farmer-grid { display: grid; grid-template-columns: repeat(5, 1fr); gap: 14px; }
.farmer-card { background: white; border: 1px solid var(--border); border-radius: var(--r); padding: 20px 16px; text-align: center; cursor: pointer; transition: all 0.2s; }
.farmer-card:hover { border-color: var(--green-main); transform: translateY(-3px); box-shadow: var(--shadow-md); }
.farmer-ava { width: 64px; height: 64px; border-radius: 50%; background: linear-gradient(135deg, var(--green-pale), var(--green-light)); margin: 0 auto 10px; display: flex; align-items: center; justify-content: center; font-size: 30px; border: 3px solid var(--green-pale); }
.farmer-card:hover .farmer-ava { border-color: var(--green-main); }
.farmer-name { font-size: 13px; font-weight: 800; color: var(--text-dark); margin-bottom: 2px; }
.farmer-loc { font-size: 11px; color: var(--text-muted); margin-bottom: 8px; }
.farmer-stats { display: flex; justify-content: center; gap: 12px; }
.farmer-stat { font-size: 11px; color: var(--text-mid); font-weight: 600; }
.farmer-stat strong { display: block; font-size: 14px; font-weight: 900; color: var(--green-main); }
.verified-badge { display: inline-flex; align-items: center; gap: 3px; font-size: 10px; font-weight: 700; color: var(--green-main); background: var(--green-pale); padding: 2px 7px; border-radius: 4px; margin-bottom: 6px; }

/* Tabs */
.tab-bar { display: flex; gap: 4px; margin-bottom: 16px; background: white; padding: 6px; border-radius: 10px; border: 1px solid var(--border); width: fit-content; }
.tab { padding: 7px 18px; border-radius: 7px; font-size: 13px; font-weight: 700; cursor: pointer; border: none; background: transparent; color: var(--text-mid); transition: all 0.2s; font-family: 'Nunito', sans-serif; }
.tab.active { background: var(--green-main); color: white; }
.tab:hover:not(.active) { background: var(--green-pale); color: var(--green-dark); }

@keyframes fadeUp { from { opacity: 0; transform: translateY(18px); } to { opacity: 1; transform: translateY(0); } }
.anim-1 { animation: fadeUp 0.5s ease both; }
.anim-2 { animation: fadeUp 0.5s 0.08s ease both; }
.anim-3 { animation: fadeUp 0.5s 0.16s ease both; }
.anim-4 { animation: fadeUp 0.5s 0.24s ease both; }
.anim-5 { animation: fadeUp 0.5s 0.32s ease both; }
</style>
@endpush

@section('content')

{{-- Trust Bar --}}
<div class="trust-bar">
    <div class="trust-inner">
        <div class="trust-item"><span>🚚</span> Gratis Ongkir Pembelian >Rp 50.000</div>
        <div class="trust-div"></div>
        <div class="trust-item"><span>✅</span> 100% Produk Segar Langsung Petani</div>
        <div class="trust-div"></div>
        <div class="trust-item"><span>🔒</span> Pembayaran Aman & Terpercaya</div>
        <div class="trust-div"></div>
        <div class="trust-item"><span>🔄</span> Garansi Uang Kembali 3 Hari</div>
        <div class="trust-div"></div>
        <div class="trust-item"><span>⭐</span> 1.200+ Petani Terverifikasi</div>
    </div>
</div>

<div class="page">

    {{-- Hero --}}
    <div class="hero-section anim-1">
        <div class="hero-main">
            <div class="hero-circles"></div>
            <div class="hero-content">
                <div class="hero-tag">🌾 Panen Langsung Hari Ini</div>
                <h1 class="hero-title">Dari <span>Petani</span><br>Untuk Petani!</h1>
                <p class="hero-sub">Sayuran & buah segar, langsung dari kebun petani lokal.<br>Tanpa perantara, harga lebih murah, kualitas terjamin.</p>
                <a href="#produk" class="hero-btn">
                    Belanja Sekarang
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>
        </div>
        <div class="hero-side">
            <div class="side-banner side-banner-1">
                <div class="side-banner-emoji">🌶️</div>
                <div class="side-banner-label">PROMO HARI INI</div>
                <div class="side-banner-title">Cabai & Bawang<br>Diskon 40%</div>
            </div>
            <div class="side-banner side-banner-2">
                <div class="side-banner-emoji">🌽</div>
                <div class="side-banner-label">BELI 2 GRATIS 1</div>
                <div class="side-banner-title">Jagung Manis<br>Segar Pilihan</div>
            </div>
        </div>
    </div>

    {{-- Categories --}}
    <div class="anim-2" style="margin-bottom:20px">
        <div class="section-hd">
            <h2>Berdasarkan Kategori</h2>
            <a href="#" class="see-all">Lihat Semua →</a>
        </div>
        <div class="cats-grid">
            @foreach([
                ['🌿','Semua'], ['🌾','Pertanian'], ['🌳','Perkebunan'],
                ['🥗','Sayuran'], ['🍎','Buah-buahan'], ['🌿','Rempah'],
                ['🐄','Peternakan'], ['🐟','Perikanan'], ['🌱','Bibit'], ['🧴','Pupuk']
            ] as $i => $cat)
            <div class="cat-item {{ $i === 0 ? 'active' : '' }}">
                <div class="cat-icon">{{ $cat[0] }}</div>
                <div class="cat-name">{{ $cat[1] }}</div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Promo Banners --}}
    <div class="promo-strip anim-3">
        <div class="promo-card promo-card-1">
            <div class="promo-emoji">🛒</div>
            <div>
                <div class="promo-label">Gratis Ongkir</div>
                <div class="promo-title">Belanja Min. Rp 50.000</div>
                <div class="promo-sub">Berlaku ke seluruh Indonesia</div>
            </div>
        </div>
        <div class="promo-card promo-card-2">
            <div class="promo-emoji">🎁</div>
            <div>
                <div class="promo-label">Member Baru</div>
                <div class="promo-title">Diskon Rp 25.000</div>
                <div class="promo-sub">Daftar sekarang dan hemat!</div>
            </div>
        </div>
        <div class="promo-card promo-card-3">
            <div class="promo-emoji">⭐</div>
            <div>
                <div class="promo-label">Program Petani</div>
                <div class="promo-title">Jual Hasil Panen</div>
                <div class="promo-sub">Bergabung & raih penghasilan lebih</div>
            </div>
        </div>
    </div>

 {{-- Panen Hari ini --}}
<div class="anim-3" style="margin-bottom:24px">
    <div class="section-hd">
        <h2>Panen Hari ini</h2>
        <a href="#" class="see-all">Lihat Semua →</a>
    </div>

    <div class="prod-grid"> {{-- INI YANG KURANG --}}
        
        @foreach($harvests as $h)
        <div class="prod-card">
            <div class="prod-img">
                🌾

                @if($h->is_organic)
                    <span class="prod-badge organic">Organik</span>
                @endif

                @php
$harvestDate = \Carbon\Carbon::parse($h->harvest_date)->format('Y-m-d');
$harvestDateTime = \Carbon\Carbon::parse($harvestDate . ' ' . $h->harvest_time);
@endphp

                <span class="prod-badge time"
                    data-deadline="{{ $harvestDateTime->format('Y-m-d H:i:s') }}">
                    ⏱ --:--:--
                </span>

                <button class="prod-wishlist">🤍</button>
            </div>

            <div class="prod-body">
                <div class="prod-name">
                    {{ $h->product->name ?? 'Produk Tidak Diketahui' }}
                </div>

                <div class="prod-farmer">
                    👨‍🌾 {{ $h->seller->user->name ?? 'Petani' }}
                </div>

                <div class="prod-price-row">
                    <div class="prod-price">
                        Rp {{ number_format($h->price_per_unit, 0, ',', '.') }}
                    </div>
                    <div class="prod-unit">
                        /{{ $h->product->unit ?? 'kg' }}
                    </div>
                </div>

                <div class="prod-meta">
                    <div class="prod-stars">
                        📦 {{ $h->remaining_stock }} stok
                    </div>
                    <div class="prod-sold">
                        Panen hari ini
                    </div>
                </div>

                <div class="prod-location">
                    📍 {{ $h->seller->user->alamat ?? 'Indonesia' }}
                </div>

                <button class="add-to-cart-btn">
                    + Keranjang
                </button>
            </div>
        </div>
        @endforeach

    </div>
</div>

    {{-- Flash Sale --}}
    <div class="flash-section anim-3" id="produk">
        <div class="flash-header">
            <div class="flash-title">
                <svg width="22" height="22" fill="currentColor" viewBox="0 0 24 24"><path d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                Flash Sale
            </div>
            <div class="flash-countdown">
                Berakhir dalam:
                <div class="countdown-box" id="h">03</div> :
                <div class="countdown-box" id="m">24</div> :
                <div class="countdown-box" id="s">17</div>
                <a href="#" class="see-all" style="margin-left:12px">Lihat Semua →</a>
            </div>
        </div>
        <div class="prod-grid prod-grid-6">
            @foreach($harvests as $h)
<div class="prod-card">
    <div class="prod-img">
        🌾
        @if($h->is_organic)
            <span class="prod-badge organic">Organik</span>
        @endif
        <button class="prod-wishlist">🤍</button>
    </div>

    <div class="prod-body">
        <div class="prod-name">
            {{ $h->product->name }}
        </div>

        <div class="prod-farmer">
            👨‍🌾 {{ $h->seller->user->name }}
        </div>

        <div class="prod-price-row">
            <div class="prod-price">
                Rp {{ number_format($h->price_per_unit, 0, ',', '.') }}
            </div>
            <div class="prod-unit">
                /{{ $h->product->unit ?? 'kg' }}
            </div>
        </div>

        <div class="prod-meta">
            <div class="prod-stars">
                📦 {{ $h->remaining_stock }} stok
            </div>
            <div class="prod-sold">
                Panen hari ini
            </div>
        </div>

        <div class="prod-location">
            📍 {{ $h->seller->user->alamat ?? 'Indonesia' }}
        </div>

        <button class="add-to-cart-btn">
            + Keranjang
        </button>
    </div>
</div>
@endforeach
        </div>
    </div>

    {{-- Farmers --}}
    <div class="anim-4" style="margin-bottom:24px">
        <div class="section-hd">
            <h2>Petani Terpopuler</h2>
            <a href="#" class="see-all">Semua Petani →</a>
        </div>
        <div class="farmer-grid">
            @foreach([
                ['👨‍🌾','Pak Slamet Santoso','Brebes, Jawa Tengah','124','4.9'],
                ['👩‍🌾','Ibu Ratna Wulandari','Lembang, Jabar','86','5.0'],
                ['🧑‍🌾','Pak Hendra Kusuma','Cianjur, Jabar','52','4.8'],
                ['👨‍🌾','Pak Agus Purnomo','Malang, Jatim','97','4.7'],
                ['👩‍🌾','Ibu Sari Dewi','Dieng, Jateng','43','4.9'],
            ] as $f)
            <div class="farmer-card">
                <div class="farmer-ava">{{ $f[0] }}</div>
                <div class="verified-badge">✓ Terverifikasi</div>
                <div class="farmer-name">{{ $f[1] }}</div>
                <div class="farmer-loc">📍 {{ $f[2] }}</div>
                <div class="farmer-stats">
                    <div class="farmer-stat"><strong>{{ $f[3] }}</strong> Produk</div>
                    <div class="farmer-stat"><strong>{{ $f[4] }} ★</strong> Rating</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Terpopuler --}}
    <div class="anim-5" style="margin-bottom:24px">
        <div class="section-hd">
            <h2>Produk Terpopuler</h2>
            <a href="#" class="see-all">Lihat Semua →</a>
        </div>
        <div class="tab-bar">
            <button class="tab active">Terlaris</button>
            <button class="tab">Terbaru</button>
            <button class="tab">Sayuran</button>
            <button class="tab">Buah-buahan</button>
            <button class="tab">Rempah</button>
        </div>
        <div class="prod-grid">
            @foreach([
                ['🌽','Jagung Manis Super','Pak Agus · Malang','Rp 6.500','/kg','4.8','3.204','Malang',''],
                ['🥔','Kentang Granola','Ibu Susi · Dieng','Rp 11.000','/kg','4.9','1.870','Dieng','organic'],
                ['🍆','Terong Ungu Lokal','Pak Budi · Jember','Rp 7.000','/kg','4.6','942','Jember',''],
                ['🥬','Sawi Putih Segar','Pak Dedi · Bandung','Rp 5.500','/ikat','4.7','520','Bandung','new'],
                ['🧄','Bawang Putih Lokal','Pak Slamet · Brebes','Rp 32.000','/kg','4.9','2.110','Brebes',''],
            ] as $p)
            <div class="prod-card">
                <div class="prod-img">{{ $p[0] }}
                    @if($p[8] === 'organic')<span class="prod-badge organic">Organik</span>@endif
                    @if($p[8] === 'new')<span class="prod-badge new-badge">Baru</span>@endif
                    <button class="prod-wishlist">🤍</button>
                </div>
                <div class="prod-body">
                    <div class="prod-name">{{ $p[1] }}</div>
                    <div class="prod-farmer">👨‍🌾 {{ $p[2] }}</div>
                    <div class="prod-price-row">
                        <div class="prod-price">{{ $p[3] }}</div>
                        <div class="prod-unit">{{ $p[4] }}</div>
                    </div>
                    <div class="prod-meta">
                        <div class="prod-stars"><span>★</span> {{ $p[5] }}</div>
                        <div class="prod-sold">{{ $p[6] }} terjual</div>
                    </div>
                    <div class="prod-location">📍 {{ $p[7] }}</div>
                    <button class="add-to-cart-btn">+ Keranjang</button>
                </div>
            </div>
            @endforeach
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
let total = 3 * 3600 + 24 * 60 + 17;
function tick() {
    total--;
    if (total < 0) total = 86400;
    const h = String(Math.floor(total / 3600)).padStart(2, '0');
    const m = String(Math.floor((total % 3600) / 60)).padStart(2, '0');
    const s = String(total % 60).padStart(2, '0');
    document.getElementById('h').textContent = h;
    document.getElementById('m').textContent = m;
    document.getElementById('s').textContent = s;
}
setInterval(tick, 1000);

document.querySelectorAll('.tab').forEach(t => {
    t.addEventListener('click', () => {
        document.querySelectorAll('.tab').forEach(x => x.classList.remove('active'));
        t.classList.add('active');
    });
});
document.querySelectorAll('.cat-item').forEach(c => {
    c.addEventListener('click', () => {
        document.querySelectorAll('.cat-item').forEach(x => x.classList.remove('active'));
        c.classList.add('active');
    });
});
document.querySelectorAll('.prod-wishlist').forEach(btn => {
    btn.addEventListener('click', e => {
        e.stopPropagation();
        btn.textContent = btn.textContent === '🤍' ? '❤️' : '🤍';
    });
});

function updateTimeBadges() {
    const now = new Date();

    document.querySelectorAll('.prod-badge.time').forEach(badge => {
        const deadline = badge.dataset.deadline;

        if (!deadline) {
            badge.textContent = '⏱ --:--:--';
            return;
        }

        const panenDate = new Date(deadline);
        let diffMs = now - panenDate;

        if (diffMs < 0) {
            badge.textContent = '⏱ Belum Panen';
            badge.classList.remove('badge-yellow', 'badge-red');
            return;
        }

        const totalSec = Math.floor(diffMs / 1000);
        const hrs  = Math.floor(totalSec / 3600);
        const mins = Math.floor((totalSec % 3600) / 60);
        const secs = totalSec % 60;

        badge.textContent = '⏱ '
            + String(hrs).padStart(2,'0') + ':'
            + String(mins).padStart(2,'0') + ':'
            + String(secs).padStart(2,'0');

        badge.classList.remove('badge-yellow', 'badge-red');

        const jamBerlalu = diffMs / 3600000;
        if (jamBerlalu >= 4) badge.classList.add('badge-red');
        else if (jamBerlalu >= 2) badge.classList.add('badge-yellow');
    });
}

setInterval(updateTimeBadges, 1000);
updateTimeBadges();
</script>
@endpush
