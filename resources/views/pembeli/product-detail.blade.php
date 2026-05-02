@extends('layouts.app')

@section('title', ($harvest->product->name ?? 'Detail Produk') . ' — SEARA')

@push('styles')
<style>
/* ── Layout ── */
.det-page { max-width: 1280px; margin: 0 auto; padding: 24px 24px 80px; }

/* ── Breadcrumb ── */
.breadcrumb { display: flex; align-items: center; gap: 6px; font-size: 13px; color: var(--text-muted); margin-bottom: 24px; flex-wrap: wrap; }
.breadcrumb a { color: var(--text-muted); transition: color .2s; }
.breadcrumb a:hover { color: var(--green-main); }
.breadcrumb .sep { opacity: .4; }
.breadcrumb .cur { color: var(--text-dark); font-weight: 700; }

/* ── Grid utama ── */
.det-grid { display: grid; grid-template-columns: 1fr 480px; gap: 32px; align-items: start; }

/* ── Galeri ── */
.gallery-wrap { position: sticky; top: 24px; }
.gallery-main {
    width: 100%; aspect-ratio: 1;
    background: var(--green-pale); border-radius: 20px;
    display: flex; align-items: center; justify-content: center;
    font-size: 140px; position: relative; overflow: hidden;
    border: 1.5px solid var(--border);
    margin-bottom: 14px;
}
.gallery-badge-wrap { position: absolute; top: 14px; left: 14px; display: flex; flex-direction: column; gap: 6px; }
.gallery-badge { font-size: 11px; font-weight: 800; padding: 4px 10px; border-radius: 6px; letter-spacing: .5px; display: inline-block; }
.badge-organic { background: var(--green-main); color: white; }
.badge-flash  { background: var(--accent); color: white; }
.gallery-thumbs { display: grid; grid-template-columns: repeat(4,1fr); gap: 10px; }
.thumb-item {
    aspect-ratio: 1; border-radius: 12px; background: var(--green-pale);
    display: flex; align-items: center; justify-content: center;
    font-size: 32px; cursor: pointer;
    border: 2.5px solid transparent; transition: all .2s;
}
.thumb-item.active { border-color: var(--green-main); background: #c8e6c9; }
.thumb-item:hover:not(.active) { border-color: var(--border); }

/* ── Panel kanan ── */
.det-panel { display: flex; flex-direction: column; gap: 20px; }

/* ── Header ── */
.det-header {}
.det-category { font-size: 11px; font-weight: 800; color: var(--green-main); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 6px; }
.det-name { font-family: 'Playfair Display', serif; font-size: 30px; font-weight: 700; color: var(--text-dark); line-height: 1.25; margin-bottom: 10px; }
.det-meta-row { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; }
.det-stars { display: flex; align-items: center; gap: 5px; }
.det-stars .stars { color: #f59e0b; font-size: 14px; letter-spacing: 1px; }
.det-stars .val { font-size: 13px; font-weight: 800; color: var(--text-dark); }
.det-stars .count { font-size: 12px; color: var(--text-muted); }
.det-dot { width: 4px; height: 4px; border-radius: 50%; background: var(--border); flex-shrink: 0; }
.det-sold { font-size: 13px; color: var(--text-muted); }
.det-loc { font-size: 13px; color: var(--text-muted); display: flex; align-items: center; gap: 4px; }

/* ── Divider ── */
.det-divider { height: 1px; background: var(--border); }

/* ── Card wrapper ── */
.det-card { background: white; border: 1.5px solid var(--border); border-radius: 16px; padding: 18px 20px; }
.det-card-title { font-size: 11px; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: .8px; margin-bottom: 12px; }

/* ── Harga ── */
.price-row { display: flex; align-items: baseline; gap: 8px; }
.price-main { font-size: 36px; font-weight: 900; color: var(--accent); line-height: 1; }
.price-unit { font-size: 15px; color: var(--text-muted); }
.price-old  { font-size: 14px; color: var(--text-muted); text-decoration: line-through; }
.price-disc { font-size: 12px; font-weight: 800; color: var(--accent); background: #fff3ee; padding: 2px 8px; border-radius: 5px; }
.organic-pill { margin-top: 10px; display: inline-flex; align-items: center; gap: 5px; background: var(--green-pale); color: var(--green-dark); font-size: 12px; font-weight: 700; padding: 5px 12px; border-radius: 20px; }

/* ── Stok ── */
.stock-bar-wrap { margin-top: 12px; }
.stock-label { display: flex; justify-content: space-between; font-size: 12px; color: var(--text-muted); margin-bottom: 6px; }
.stock-bar { height: 6px; background: #e0e0e0; border-radius: 10px; overflow: hidden; }
.stock-fill { height: 100%; background: var(--green-main); border-radius: 10px; transition: width .5s ease; }
.stock-fill.low { background: #f59e0b; }
.stock-fill.critical { background: #ef4444; }
.stock-num { font-size: 13px; font-weight: 800; color: var(--text-dark); margin-top: 6px; }
.stock-num span { color: var(--green-main); }

/* ── Timer Panen ── */
.timer-card { background: linear-gradient(135deg, var(--green-dark), var(--green-main)); border-radius: 16px; padding: 16px 20px; color: white; }
.timer-label { font-size: 11px; font-weight: 700; opacity: .75; text-transform: uppercase; letter-spacing: .8px; margin-bottom: 10px; }
.timer-boxes { display: flex; align-items: center; gap: 8px; }
.timer-box { background: rgba(255,255,255,.15); border-radius: 10px; padding: 8px 14px; text-align: center; min-width: 56px; }
.timer-num { font-size: 26px; font-weight: 900; line-height: 1; font-variant-numeric: tabular-nums; }
.timer-unit-lbl { font-size: 10px; opacity: .7; font-weight: 600; text-transform: uppercase; margin-top: 2px; }
.timer-sep { font-size: 24px; font-weight: 900; opacity: .5; }

/* ── Jumlah ── */
.qty-wrap { display: flex; align-items: center; gap: 16px; }
.qty-ctrl { display: flex; align-items: center; border: 1.5px solid var(--border); border-radius: 12px; overflow: hidden; }
.qty-btn {
    width: 44px; height: 44px; border: none;
    background: var(--green-pale); color: var(--green-dark);
    font-size: 22px; font-weight: 700; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    transition: background .15s;
}
.qty-btn:hover { background: #c8e6c9; }
.qty-num { width: 56px; height: 44px; display: flex; align-items: center; justify-content: center; font-size: 17px; font-weight: 800; color: var(--text-dark); }
.qty-total-label { font-size: 13px; color: var(--text-muted); }
.qty-total-val { font-size: 20px; font-weight: 900; color: var(--green-dark); }

/* ── CTA ── */
.cta-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
.btn-cart {
    padding: 14px; border-radius: 12px;
    border: 2px solid var(--green-main); background: transparent;
    color: var(--green-main); font-family: 'Nunito',sans-serif;
    font-size: 14px; font-weight: 800; cursor: pointer;
    display: flex; align-items: center; justify-content: center; gap: 6px;
    transition: all .2s;
}
.btn-cart:hover { background: var(--green-pale); }
.btn-buy {
    padding: 14px; border-radius: 12px;
    border: 2px solid var(--green-main); background: var(--green-main);
    color: white; font-family: 'Nunito',sans-serif;
    font-size: 14px; font-weight: 800; cursor: pointer;
    display: flex; align-items: center; justify-content: center; gap: 6px;
    transition: all .2s;
}
.btn-buy:hover { background: var(--green-dark); border-color: var(--green-dark); }
.btn-wishlist {
    width: 100%; margin-top: 8px; padding: 12px;
    border-radius: 12px; border: 1.5px solid var(--border);
    background: transparent; color: var(--text-mid);
    font-family: 'Nunito',sans-serif; font-size: 13px; font-weight: 700;
    cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 6px;
    transition: all .2s;
}
.btn-wishlist:hover { border-color: #f43f5e; color: #f43f5e; background: #fff1f2; }
.btn-wishlist.active { border-color: #f43f5e; color: #f43f5e; background: #fff1f2; }

/* ── Petani ── */
.farmer-card { display: flex; align-items: center; gap: 14px; }
.farmer-ava-det { width: 56px; height: 56px; border-radius: 50%; background: linear-gradient(135deg, var(--green-pale), var(--green-light)); display: flex; align-items: center; justify-content: center; font-size: 28px; flex-shrink: 0; border: 3px solid var(--green-pale); }
.farmer-info { flex: 1; min-width: 0; }
.farmer-det-name { font-size: 15px; font-weight: 800; color: var(--text-dark); margin-bottom: 2px; }
.farmer-det-loc  { font-size: 12px; color: var(--text-muted); margin-bottom: 6px; }
.farmer-verified { display: inline-flex; align-items: center; gap: 4px; font-size: 11px; font-weight: 700; color: var(--green-main); background: var(--green-pale); padding: 3px 9px; border-radius: 20px; }
.farmer-stats-row { display: flex; gap: 16px; margin-top: 10px; padding-top: 10px; border-top: 1px solid var(--border); }
.fstat { text-align: center; }
.fstat-val { font-size: 16px; font-weight: 900; color: var(--green-main); display: block; }
.fstat-lbl { font-size: 11px; color: var(--text-muted); }

/* ── Garansi ── */
.guarantees { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
.guar-item { display: flex; align-items: center; gap: 10px; }
.guar-icon { width: 36px; height: 36px; background: var(--green-pale); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0; }
.guar-text { font-size: 12px; font-weight: 700; color: var(--text-mid); line-height: 1.3; }

/* ── Deskripsi ── */
.desc-body { font-size: 14px; line-height: 1.75; color: var(--text-mid); }
.spec-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 0; }
.spec-row { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid var(--border); font-size: 13px; }
.spec-row:last-child { border-bottom: none; }
.spec-key { color: var(--text-muted); font-weight: 600; }
.spec-val { color: var(--text-dark); font-weight: 700; text-align: right; }

/* ── Ulasan ── */
.reviews-section { margin-top: 40px; }
.reviews-section h2 { font-size: 20px; font-weight: 800; color: var(--text-dark); margin-bottom: 16px; display: flex; align-items: center; gap: 8px; }
.reviews-section h2::before { content: ''; display: block; width: 4px; height: 22px; background: var(--green-main); border-radius: 2px; }
.reviews-summary { display: flex; align-items: center; gap: 32px; background: white; border: 1.5px solid var(--border); border-radius: 16px; padding: 24px; margin-bottom: 20px; }
.rev-big-score { text-align: center; }
.rev-big-num { font-size: 56px; font-weight: 900; color: var(--text-dark); line-height: 1; }
.rev-big-stars { color: #f59e0b; font-size: 20px; letter-spacing: 2px; margin: 4px 0; }
.rev-big-count { font-size: 12px; color: var(--text-muted); }
.rev-bars { flex: 1; display: flex; flex-direction: column; gap: 6px; }
.rev-bar-row { display: flex; align-items: center; gap: 8px; font-size: 12px; color: var(--text-muted); }
.rev-bar-track { flex: 1; height: 6px; background: #e0e0e0; border-radius: 10px; overflow: hidden; }
.rev-bar-fill { height: 100%; background: #f59e0b; border-radius: 10px; }
.rev-bar-num { width: 28px; text-align: right; font-weight: 700; color: var(--text-mid); }
.review-list { display: flex; flex-direction: column; gap: 14px; }
.review-item { background: white; border: 1.5px solid var(--border); border-radius: 16px; padding: 18px 20px; }
.review-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px; }
.review-user { display: flex; align-items: center; gap: 10px; }
.review-ava { width: 36px; height: 36px; border-radius: 50%; background: var(--green-pale); display: flex; align-items: center; justify-content: center; font-size: 16px; }
.review-name { font-size: 13px; font-weight: 800; color: var(--text-dark); }
.review-date { font-size: 11px; color: var(--text-muted); }
.review-stars { color: #f59e0b; font-size: 14px; letter-spacing: 1px; }
.review-body { font-size: 13px; line-height: 1.7; color: var(--text-mid); }
.review-tag { display: inline-block; margin-top: 8px; font-size: 11px; font-weight: 700; color: var(--green-main); background: var(--green-pale); padding: 2px 8px; border-radius: 5px; }

/* ── Produk serupa ── */
.related-section { margin-top: 40px; }
.related-section h2 { font-size: 20px; font-weight: 800; color: var(--text-dark); margin-bottom: 16px; display: flex; align-items: center; gap: 8px; }
.related-section h2::before { content: ''; display: block; width: 4px; height: 22px; background: var(--green-main); border-radius: 2px; }
.prod-grid-rel { display: flex; gap: 14px; overflow-x: auto; padding-bottom: 8px; scroll-behavior: smooth; }
.prod-grid-rel::-webkit-scrollbar { height: 4px; }
.prod-grid-rel::-webkit-scrollbar-thumb { background: #ccc; border-radius: 10px; }

/* ── Toast ── */
.toast {
    position: fixed; bottom: 32px; left: 50%; transform: translateX(-50%) translateY(20px);
    background: var(--green-dark); color: white; padding: 12px 24px;
    border-radius: 50px; font-size: 14px; font-weight: 700;
    opacity: 0; transition: all .35s cubic-bezier(.22,1,.36,1);
    z-index: 9999; white-space: nowrap; pointer-events: none;
    box-shadow: 0 8px 24px rgba(0,0,0,0.2);
}
.toast.show { opacity: 1; transform: translateX(-50%) translateY(0); }

/* ── Trust Bar (sama seperti dashboard) ── */
.trust-bar { background: white; border-top: 1px solid var(--border); border-bottom: 1px solid var(--border); }
.trust-inner { max-width: 1280px; margin: 0 auto; padding: 12px 24px; display: flex; align-items: center; justify-content: space-between; }
.trust-item { display: flex; align-items: center; gap: 10px; font-size: 13px; font-weight: 700; color: var(--text-mid); }
.trust-item span { font-size: 20px; }
.trust-div { width: 1px; height: 30px; background: var(--border); }

/* ── Prod Card (reuse dari dashboard) ── */
.prod-card { background: white; border: 1px solid var(--border); border-radius: var(--r); overflow: hidden; cursor: pointer; transition: all 0.25s; position: relative; min-width: 200px; max-width: 200px; flex-shrink: 0; }
.prod-card:hover { border-color: var(--green-main); transform: translateY(-4px); box-shadow: var(--shadow-md); }
.prod-img { width: 100%; aspect-ratio: 1; background: var(--green-pale); display: flex; align-items: center; justify-content: center; font-size: 56px; position: relative; }
.prod-badge { position: absolute; top: 8px; left: 8px; background: var(--accent); color: white; font-size: 10px; font-weight: 800; padding: 3px 7px; border-radius: 4px; z-index: 1; }
.prod-badge.organic { background: var(--green-main); }
.prod-body { padding: 12px; }
.prod-name { font-size: 13px; font-weight: 700; color: var(--text-dark); margin-bottom: 2px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.prod-farmer { font-size: 11px; color: var(--text-muted); margin-bottom: 8px; }
.prod-price-row { display: flex; align-items: baseline; gap: 6px; margin-bottom: 6px; }
.prod-price { font-size: 16px; font-weight: 900; color: var(--accent); }
.prod-unit { font-size: 11px; color: var(--text-muted); font-weight: 500; }
.prod-meta { display: flex; align-items: center; justify-content: space-between; }
.prod-stars { display: flex; align-items: center; gap: 3px; font-size: 11px; color: var(--text-muted); }
.prod-stars span { color: var(--yellow); font-size: 12px; }
.prod-sold { font-size: 11px; color: var(--text-muted); }
.add-to-cart-btn { width: 100%; background: var(--green-main); color: white; border: none; padding: 8px; border-radius: 7px; font-family: 'Nunito', sans-serif; font-weight: 800; font-size: 12px; margin-top: 10px; display: flex; align-items: center; justify-content: center; gap: 5px; transition: background 0.2s; cursor: pointer; }
.add-to-cart-btn:hover { background: var(--green-dark); }

@keyframes fadeUp { from { opacity:0; transform:translateY(16px); } to { opacity:1; transform:translateY(0); } }
.anim-1 { animation: fadeUp .45s ease both; }
.anim-2 { animation: fadeUp .45s .07s ease both; }
.anim-3 { animation: fadeUp .45s .14s ease both; }
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
    </div>
</div>

<div class="det-page">

    {{-- Breadcrumb --}}
    <div class="breadcrumb anim-1">
        <a href="{{ route('home') }}">🏠 Beranda</a>
        <span class="sep">›</span>
        <a href="{{ route('home') }}">Belanja</a>
        <span class="sep">›</span>
        <a href="{{ route('home', ['kategori' => $harvest->product->category->slug ?? '']) }}">
            {{ $harvest->product->category->name ?? 'Pertanian' }}
        </a>
        <span class="sep">›</span>
        <span class="cur">{{ $harvest->product->name ?? 'Detail Produk' }}</span>
    </div>

    {{-- Grid Utama --}}
    <div class="det-grid anim-2">

        {{-- KIRI: Galeri --}}
        <div class="gallery-wrap">
            <div class="gallery-main" id="mainImg">
                <span id="mainEmoji">{{ $harvest->product->emoji ?? '🌾' }}</span>
                <div class="gallery-badge-wrap">
                    @if($harvest->is_organic)
                        <span class="gallery-badge badge-organic">🌱 Organik</span>
                    @endif
                    <span class="gallery-badge badge-flash">⚡ Flash Sale</span>
                </div>
            </div>
            <div class="gallery-thumbs">
                @foreach(['🌾','🌿','🌱','🍃'] as $i => $e)
                <div class="thumb-item {{ $i === 0 ? 'active' : '' }}"
                     onclick="selectThumb(this, '{{ $e }}')" data-emoji="{{ $e }}">{{ $e }}</div>
                @endforeach
            </div>
        </div>

        {{-- KANAN: Panel Detail --}}
        <div class="det-panel anim-3">

            {{-- Header --}}
            <div class="det-header">
                <div class="det-category">
                    🌿 {{ $harvest->product->category->name ?? 'Pertanian' }}
                </div>
                <h1 class="det-name">{{ $harvest->product->name ?? 'Nama Produk' }}</h1>
                <div class="det-meta-row">
                    <div class="det-stars">
                        <span class="stars">★★★★★</span>
                        <span class="val">4.9</span>
                        <span class="count">(128 ulasan)</span>
                    </div>
                    <div class="det-dot"></div>
                    <div class="det-sold">2.340 terjual</div>
                    <div class="det-dot"></div>
                    <div class="det-loc">📍 {{ $harvest->seller->user->alamat ?? 'Indonesia' }}</div>
                </div>
            </div>

            <div class="det-divider"></div>

            {{-- Harga --}}
            <div class="det-card">
                <div class="det-card-title">Harga</div>
                <div class="price-row">
                    <div class="price-main">Rp {{ number_format($harvest->price_per_unit, 0, ',', '.') }}</div>
                    <div class="price-unit">/{{ $harvest->product->unit ?? 'kg' }}</div>
                    <div class="price-old">Rp {{ number_format($harvest->price_per_unit * 1.2, 0, ',', '.') }}</div>
                    <div class="price-disc">-20%</div>
                </div>
                @if($harvest->is_organic)
                <div class="organic-pill">🌱 Produk Organik Bersertifikat</div>
                @endif

                {{-- Stok --}}
                <div class="stock-bar-wrap">
                    @php
                        $stok = $harvest->remaining_stock;
                        $maxStok = 100;
                        $pct = min(100, round(($stok / $maxStok) * 100));
                        $fillClass = $pct <= 20 ? 'critical' : ($pct <= 50 ? 'low' : '');
                    @endphp
                    <div class="stock-label">
                        <span>Stok Tersisa</span>
                        <span>{{ $pct }}%</span>
                    </div>
                    <div class="stock-bar">
                        <div class="stock-fill {{ $fillClass }}" style="width:{{ $pct }}%"></div>
                    </div>
                    <div class="stock-num">
                        <span>{{ $stok }} {{ $harvest->product->unit ?? 'kg' }}</span> tersisa
                    </div>
                </div>
            </div>

            {{-- Timer Panen --}}
            @php
                $harvestDateTime = \Carbon\Carbon::parse($harvest->harvest_date);
            @endphp
            <div class="timer-card">
                <div class="timer-label">⏱ Waktu sejak dipanen</div>
                <div class="timer-boxes">
                    <div class="timer-box">
                        <div class="timer-num" id="t-h">00</div>
                        <div class="timer-unit-lbl">Jam</div>
                    </div>
                    <div class="timer-sep">:</div>
                    <div class="timer-box">
                        <div class="timer-num" id="t-m">00</div>
                        <div class="timer-unit-lbl">Menit</div>
                    </div>
                    <div class="timer-sep">:</div>
                    <div class="timer-box">
                        <div class="timer-num" id="t-s">00</div>
                        <div class="timer-unit-lbl">Detik</div>
                    </div>
                </div>
            </div>

            {{-- Jumlah + Total --}}
            <div class="det-card">
                <div class="det-card-title">Jumlah</div>
                <div class="qty-wrap">
                    <div class="qty-ctrl">
                        <button class="qty-btn" onclick="changeQty(-1)">−</button>
                        <div class="qty-num" id="qtyNum">1</div>
                        <button class="qty-btn" onclick="changeQty(1)">+</button>
                    </div>
                    <div>
                        <div class="qty-total-label">Total Pembayaran</div>
                        <div class="qty-total-val" id="qtyTotal">
                            Rp {{ number_format($harvest->price_per_unit, 0, ',', '.') }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- CTA --}}
            <div>
                <div class="cta-grid">
                    <button class="btn-cart" onclick="showToast('🛒 Ditambahkan ke keranjang!')">
                        🛒 Keranjang
                    </button>
                    <button class="btn-buy" onclick="showToast('✅ Memproses pembelian...')">
                        ⚡ Beli Sekarang
                    </button>
                </div>
                <button class="btn-wishlist" id="wishlistBtn" onclick="toggleWishlist()">
                    🤍 Tambahkan ke Wishlist
                </button>
            </div>

            {{-- Petani --}}
            <div class="det-card">
                <div class="det-card-title">Tentang Petani</div>
                <div class="farmer-card">
                    <div class="farmer-ava-det">👨‍🌾</div>
                    <div class="farmer-info">
                        <div class="farmer-det-name">{{ $harvest->seller->user->name ?? 'Petani Terverifikasi' }}</div>
                        <div class="farmer-det-loc">📍 {{ $harvest->seller->user->alamat ?? 'Indonesia' }}</div>
                        <div class="farmer-verified">✓ Petani Terverifikasi SEARA</div>
                    </div>
                </div>
                <div class="farmer-stats-row">
                    <div class="fstat"><span class="fstat-val">124</span><span class="fstat-lbl">Produk</span></div>
                    <div class="fstat"><span class="fstat-val">4.9★</span><span class="fstat-lbl">Rating</span></div>
                    <div class="fstat"><span class="fstat-val">2,3rb</span><span class="fstat-lbl">Terjual</span></div>
                    <div class="fstat"><span class="fstat-val">98%</span><span class="fstat-lbl">Respons</span></div>
                </div>
            </div>

            {{-- Garansi --}}
            <div class="det-card">
                <div class="det-card-title">Jaminan Kami</div>
                <div class="guarantees">
                    <div class="guar-item">
                        <div class="guar-icon">🔒</div>
                        <div class="guar-text">Pembayaran Aman & Terenkripsi</div>
                    </div>
                    <div class="guar-item">
                        <div class="guar-icon">🔄</div>
                        <div class="guar-text">Garansi Uang Kembali 3 Hari</div>
                    </div>
                    <div class="guar-item">
                        <div class="guar-icon">🚚</div>
                        <div class="guar-text">Gratis Ongkir Min. Rp 50.000</div>
                    </div>
                    <div class="guar-item">
                        <div class="guar-icon">✅</div>
                        <div class="guar-text">100% Segar Langsung Petani</div>
                    </div>
                </div>
            </div>

        </div>{{-- /det-panel --}}
    </div>{{-- /det-grid --}}

    {{-- Deskripsi & Spesifikasi --}}
    <div style="margin-top:40px;display:grid;grid-template-columns:1fr 1fr;gap:24px;" class="anim-3">
        <div class="det-card">
            <div class="det-card-title">Deskripsi Produk</div>
            <div class="desc-body">
                <p>{{ $harvest->product->description ?? 'Produk segar berkualitas tinggi langsung dari kebun petani lokal kami yang telah terverifikasi. Dipanen pada hari yang sama untuk menjaga kesegaran dan kandungan nutrisi optimal.' }}</p>
                <br>
                <p>Setiap produk melewati proses seleksi ketat untuk memastikan hanya hasil terbaik yang sampai ke tangan Anda. Bebas dari pestisida berbahaya dan ramah lingkungan.</p>
            </div>
        </div>
        <div class="det-card">
            <div class="det-card-title">Spesifikasi</div>
            <div>
                @foreach([
                    ['Nama Produk', $harvest->product->name ?? '-'],
                    ['Kategori', $harvest->product->category->name ?? 'Pertanian'],
                    ['Satuan', $harvest->product->unit ?? 'kg'],
                    ['Status', $harvest->is_organic ? '🌱 Organik' : 'Konvensional'],
                    ['Stok Tersisa', $harvest->remaining_stock . ' ' . ($harvest->product->unit ?? 'kg')],
                    ['Tanggal Panen', \Carbon\Carbon::parse($harvest->harvest_date)->format('d M Y')],
                    ['Asal Daerah', $harvest->seller->user->alamat ?? 'Indonesia'],
                    ['Petani', $harvest->seller->user->name ?? '-'],
                ] as [$k, $v])
                <div class="spec-row">
                    <span class="spec-key">{{ $k }}</span>
                    <span class="spec-val">{{ $v }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Ulasan --}}
    <div class="reviews-section">
        <h2>Ulasan Pembeli</h2>
        <div class="reviews-summary">
            <div class="rev-big-score">
                <div class="rev-big-num">4.9</div>
                <div class="rev-big-stars">★★★★★</div>
                <div class="rev-big-count">128 ulasan</div>
            </div>
            <div class="rev-bars">
                @foreach([['5 ★', 85], ['4 ★', 10], ['3 ★', 3], ['2 ★', 1], ['1 ★', 1]] as [$lbl, $pct])
                <div class="rev-bar-row">
                    <span style="width:32px;font-weight:700;color:var(--text-mid);">{{ $lbl }}</span>
                    <div class="rev-bar-track"><div class="rev-bar-fill" style="width:{{ $pct }}%"></div></div>
                    <span class="rev-bar-num">{{ $pct }}%</span>
                </div>
                @endforeach
            </div>
        </div>
        <div class="review-list">
            @foreach([
                ['👩', 'Siti R.', '2 hari lalu', '★★★★★', 'Produknya fresh banget! Langsung dateng dari petani, masih segar dan warnanya bagus. Harga juga murah dibanding pasar. Pasti beli lagi!', 'Panen Segar'],
                ['👨', 'Budi S.', '5 hari lalu', '★★★★★', 'Kualitas top, pengiriman cepat. Bawang merahnya besar-besar dan tidak busuk sama sekali. Petaninya juga responsif banget kalau ditanya.', 'Kualitas Terjamin'],
                ['👩', 'Dewi K.', '1 minggu lalu', '★★★★☆', 'Bagus, tapi ada beberapa yang agak kecil. Overall memuaskan dan akan order lagi minggu depan untuk stock keluarga.', 'Puas Belanja'],
            ] as [$ava, $name, $date, $stars, $body, $tag])
            <div class="review-item">
                <div class="review-header">
                    <div class="review-user">
                        <div class="review-ava">{{ $ava }}</div>
                        <div>
                            <div class="review-name">{{ $name }}</div>
                            <div class="review-date">{{ $date }}</div>
                        </div>
                    </div>
                    <div class="review-stars">{{ $stars }}</div>
                </div>
                <div class="review-body">{{ $body }}</div>
                <div class="review-tag">{{ $tag }}</div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Produk Serupa --}}
    <div class="related-section">
        <h2>Produk Serupa</h2>
        <div class="prod-grid-rel">
            @foreach($relatedHarvests ?? [] as $r)
            <a href="{{ route('buyer.product.show', $r->id) }}" class="prod-card" style="text-decoration:none;">
                <div class="prod-img">🌾
                    @if($r->is_organic)<span class="prod-badge organic">Organik</span>@endif
                </div>
                <div class="prod-body">
                    <div class="prod-name">{{ $r->product->name }}</div>
                    <div class="prod-farmer">👨‍🌾 {{ $r->seller->user->name }}</div>
                    <div class="prod-price-row">
                        <div class="prod-price">Rp {{ number_format($r->price_per_unit, 0, ',', '.') }}</div>
                        <div class="prod-unit">/{{ $r->product->unit ?? 'kg' }}</div>
                    </div>
                    <div class="prod-meta">
                        <div class="prod-stars"><span>★</span> 4.8</div>
                        <div class="prod-sold">{{ $r->remaining_stock }} stok</div>
                    </div>
                    <button class="add-to-cart-btn" onclick="event.preventDefault();showToast('🛒 Ditambahkan ke keranjang!')">+ Keranjang</button>
                </div>
            </a>
            @endforeach

            {{-- Placeholder kalau $relatedHarvests kosong --}}
            @if(empty($relatedHarvests) || count($relatedHarvests) === 0)
                @foreach([['🌽','Jagung Manis','Pak Agus','Rp 6.500','/kg'],['🥔','Kentang Granola','Ibu Susi','Rp 11.000','/kg'],['🍆','Terong Ungu','Pak Budi','Rp 7.000','/kg'],['🥬','Sawi Putih','Pak Dedi','Rp 5.500','/ikat'],['🧄','Bawang Putih','Pak Slamet','Rp 32.000','/kg']] as $p)
                <div class="prod-card">
                    <div class="prod-img">{{ $p[0] }}</div>
                    <div class="prod-body">
                        <div class="prod-name">{{ $p[1] }}</div>
                        <div class="prod-farmer">👨‍🌾 {{ $p[2] }}</div>
                        <div class="prod-price-row">
                            <div class="prod-price">{{ $p[3] }}</div>
                            <div class="prod-unit">{{ $p[4] }}</div>
                        </div>
                        <div class="prod-meta">
                            <div class="prod-stars"><span>★</span> 4.8</div>
                            <div class="prod-sold">Segar hari ini</div>
                        </div>
                        <button class="add-to-cart-btn" onclick="showToast('🛒 Ditambahkan ke keranjang!')">+ Keranjang</button>
                    </div>
                </div>
                @endforeach
            @endif
        </div>
    </div>

</div>

{{-- Toast --}}
<div class="toast" id="toast"></div>

@endsection

@push('scripts')
<script>
// ── Harga satuan untuk kalkulasi
const hargaSatuan = {{ $harvest->price_per_unit }};
const maxStok = {{ $harvest->remaining_stock }};
let qty = 1;

function changeQty(delta) {
    qty = Math.max(1, Math.min(maxStok, qty + delta));
    document.getElementById('qtyNum').textContent = qty;
    const total = qty * hargaSatuan;
    document.getElementById('qtyTotal').textContent = 'Rp ' + total.toLocaleString('id-ID');
}

// ── Galeri thumbnail
function selectThumb(el, emoji) {
    document.querySelectorAll('.thumb-item').forEach(t => t.classList.remove('active'));
    el.classList.add('active');
    document.getElementById('mainEmoji').textContent = emoji;
}

// ── Timer panen
(function() {
    const panenDate = new Date('{{ \Carbon\Carbon::parse($harvest->harvest_date)->format("Y-m-d H:i:s") }}');
    function tick() {
        const now = new Date();
        const diff = Math.max(0, Math.floor((now - panenDate) / 1000));
        const h = Math.floor(diff / 3600);
        const m = Math.floor((diff % 3600) / 60);
        const s = diff % 60;
        document.getElementById('t-h').textContent = String(h).padStart(2,'0');
        document.getElementById('t-m').textContent = String(m).padStart(2,'0');
        document.getElementById('t-s').textContent = String(s).padStart(2,'0');
    }
    tick();
    setInterval(tick, 1000);
})();

// ── Wishlist toggle
let wishlisted = false;
function toggleWishlist() {
    wishlisted = !wishlisted;
    const btn = document.getElementById('wishlistBtn');
    btn.classList.toggle('active', wishlisted);
    btn.innerHTML = wishlisted ? '❤️ Tersimpan di Wishlist' : '🤍 Tambahkan ke Wishlist';
    showToast(wishlisted ? '❤️ Ditambahkan ke wishlist!' : '🤍 Dihapus dari wishlist');
}

// ── Toast notification
function showToast(msg) {
    const toast = document.getElementById('toast');
    toast.textContent = msg;
    toast.classList.add('show');
    setTimeout(() => toast.classList.remove('show'), 2800);
}
</script>
@endpush
