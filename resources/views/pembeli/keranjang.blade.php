@extends('layouts.app')

@section('title', 'Keranjang Belanja — SEARA')

@push('styles')
<style>
/* ── Layout ─────────────────────────────────────────────────────────── */
.cart-page { max-width: 1280px; margin: 0 auto; padding: 24px 24px 80px; }

/* ── Breadcrumb ─────────────────────────────────────────────────────── */
.breadcrumb { display: flex; align-items: center; gap: 6px; font-size: 13px; color: var(--text-muted); margin-bottom: 24px; flex-wrap: wrap; }
.breadcrumb a { color: var(--text-muted); transition: color .2s; }
.breadcrumb a:hover { color: var(--green-main); }
.breadcrumb .sep { opacity: .4; }
.breadcrumb .cur { color: var(--text-dark); font-weight: 700; }

/* ── Grid utama ─────────────────────────────────────────────────────── */
.cart-grid { display: grid; grid-template-columns: 1fr 360px; gap: 24px; align-items: start; }

/* ── Panel kiri (daftar item) ───────────────────────────────────────── */
.cart-left {}
.cart-header-row {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 16px;
}
.cart-title { font-size: 22px; font-weight: 900; color: var(--text-dark); display: flex; align-items: center; gap: 8px; }
.cart-title::before { content: ''; display: block; width: 4px; height: 24px; background: var(--green-main); border-radius: 2px; }
.cart-count { font-size: 14px; font-weight: 600; color: var(--text-muted); }
.btn-clear-all {
    font-size: 13px; font-weight: 700; color: #dc2626;
    background: #fef2f2; border: 1px solid #fecaca;
    padding: 7px 14px; border-radius: 8px; cursor: pointer;
    font-family: 'Nunito', sans-serif; transition: background .2s;
    text-decoration: none; display: inline-flex; align-items: center; gap: 5px;
}
.btn-clear-all:hover { background: #fee2e2; }

/* ── Select-all row ─────────────────────────────────────────────────── */
.select-all-row {
    display: flex; align-items: center; gap: 10px;
    background: white; border: 1px solid var(--border);
    border-radius: 12px; padding: 12px 16px; margin-bottom: 12px;
    font-size: 13px; font-weight: 700; color: var(--text-mid);
}
.custom-cb { width: 18px; height: 18px; accent-color: var(--green-main); cursor: pointer; flex-shrink: 0; }

/* ── Seller group ───────────────────────────────────────────────────── */
.seller-group { margin-bottom: 14px; }
.seller-group-header {
    display: flex; align-items: center; gap: 10px;
    background: white; border: 1px solid var(--border);
    border-radius: 12px 12px 0 0; padding: 12px 16px;
    border-bottom: 1px solid var(--green-pale);
}
.seller-group-header .seller-ava {
    width: 34px; height: 34px; border-radius: 50%;
    background: linear-gradient(135deg, var(--green-pale), var(--green-light));
    display: flex; align-items: center; justify-content: center; font-size: 16px;
    border: 2px solid var(--border); flex-shrink: 0;
}
.seller-group-header .seller-name { font-size: 13px; font-weight: 800; color: var(--text-dark); }
.seller-group-header .seller-loc  { font-size: 11px; color: var(--text-muted); }
.seller-group-header .chat-btn {
    margin-left: auto; font-size: 12px; font-weight: 700;
    color: var(--green-main); border: 1.5px solid var(--green-main);
    background: transparent; padding: 5px 12px; border-radius: 7px;
    cursor: pointer; font-family: 'Nunito', sans-serif; transition: all .2s;
    text-decoration: none; display: inline-flex; align-items: center; gap: 5px;
}
.seller-group-header .chat-btn:hover { background: var(--green-pale); }

/* ── Cart item card ─────────────────────────────────────────────────── */
.cart-item {
    background: white; border: 1px solid var(--border);
    border-top: none; padding: 16px;
    display: flex; align-items: flex-start; gap: 14px;
    transition: background .15s;
}
.seller-group .cart-item:last-child { border-radius: 0 0 12px 12px; }
.cart-item:hover { background: var(--green-bg); }
.cart-item.removing { opacity: .4; pointer-events: none; transition: opacity .3s; }

.item-img {
    width: 84px; height: 84px; border-radius: 12px;
    background: var(--green-pale); display: flex;
    align-items: center; justify-content: center;
    font-size: 44px; flex-shrink: 0; border: 1px solid var(--border);
    position: relative;
}
.item-organic-badge {
    position: absolute; bottom: 4px; right: 4px;
    background: var(--green-main); color: white;
    font-size: 9px; font-weight: 800; padding: 2px 5px;
    border-radius: 4px; letter-spacing: .5px;
}

.item-body { flex: 1; min-width: 0; }
.item-category { font-size: 10px; font-weight: 800; color: var(--green-main); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 3px; }
.item-name { font-size: 15px; font-weight: 800; color: var(--text-dark); margin-bottom: 4px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.item-harvest-date { font-size: 11px; color: var(--text-muted); margin-bottom: 8px; display: flex; align-items: center; gap: 4px; }

.item-price-row { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 8px; }
.item-price { font-size: 18px; font-weight: 900; color: var(--accent); }
.item-unit  { font-size: 12px; color: var(--text-muted); font-weight: 500; }
.item-subtotal { font-size: 13px; font-weight: 700; color: var(--text-mid); }

/* ── Qty stepper ────────────────────────────────────────────────────── */
.qty-wrap { display: flex; align-items: center; gap: 0; margin-top: 10px; width: fit-content; }
.qty-btn {
    width: 32px; height: 32px; border: 1.5px solid var(--border);
    background: white; font-size: 18px; line-height: 1; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    font-family: 'Nunito', sans-serif; font-weight: 700; color: var(--text-dark);
    transition: all .2s; user-select: none;
}
.qty-btn:first-child { border-radius: 8px 0 0 8px; }
.qty-btn:last-child  { border-radius: 0 8px 8px 0; }
.qty-btn:hover { background: var(--green-pale); border-color: var(--green-main); color: var(--green-main); }
.qty-btn:disabled { opacity: .4; cursor: not-allowed; }
.qty-input {
    width: 52px; height: 32px; border: 1.5px solid var(--border);
    border-left: none; border-right: none;
    text-align: center; font-size: 14px; font-weight: 800;
    font-family: 'Nunito', sans-serif; color: var(--text-dark);
    outline: none; -moz-appearance: textfield;
}
.qty-input::-webkit-outer-spin-button,
.qty-input::-webkit-inner-spin-button { -webkit-appearance: none; }

/* ── Hapus item ─────────────────────────────────────────────────────── */
.item-actions { display: flex; flex-direction: column; align-items: flex-end; gap: 8px; flex-shrink: 0; }
.btn-remove {
    width: 32px; height: 32px; border-radius: 8px;
    background: #fef2f2; border: 1.5px solid #fecaca;
    color: #dc2626; cursor: pointer; display: flex;
    align-items: center; justify-content: center;
    transition: all .2s;
}
.btn-remove:hover { background: #fee2e2; border-color: #fca5a5; }
.btn-remove svg { width: 15px; height: 15px; }

.item-stock-warn { font-size: 11px; color: #d97706; font-weight: 700; display: flex; align-items: center; gap: 3px; }

/* ── Panel kanan (ringkasan) ────────────────────────────────────────── */
.cart-right { position: sticky; top: 88px; }

.summary-card {
    background: white; border: 1.5px solid var(--border);
    border-radius: 16px; overflow: hidden;
    box-shadow: var(--shadow-sm);
}
.summary-head {
    background: linear-gradient(135deg, var(--green-dark), var(--green-main));
    padding: 16px 20px; color: white;
    font-size: 15px; font-weight: 900; display: flex; align-items: center; gap: 8px;
}
.summary-body { padding: 20px; }
.summary-row {
    display: flex; justify-content: space-between; align-items: center;
    font-size: 14px; margin-bottom: 12px; color: var(--text-mid);
}
.summary-row strong { color: var(--text-dark); }
.summary-row.total {
    border-top: 1.5px dashed var(--border); padding-top: 14px;
    margin-top: 4px; font-size: 16px; font-weight: 800; color: var(--text-dark);
}
.summary-row.total .price-total { font-size: 22px; font-weight: 900; color: var(--accent); }
.free-ongkir-badge {
    display: inline-flex; align-items: center; gap: 5px;
    background: var(--green-pale); color: var(--green-dark);
    font-size: 11px; font-weight: 700; padding: 3px 10px; border-radius: 20px;
}

/* Promo input */
.promo-wrap { margin-bottom: 16px; }
.promo-label { font-size: 12px; font-weight: 700; color: var(--text-mid); margin-bottom: 6px; }
.promo-row { display: flex; gap: 8px; }
.promo-input {
    flex: 1; height: 38px; border: 1.5px solid var(--border);
    border-radius: 8px; padding: 0 12px; font-family: 'Nunito', sans-serif;
    font-size: 13px; outline: none; transition: border-color .2s;
    text-transform: uppercase; letter-spacing: 1px;
}
.promo-input:focus { border-color: var(--green-main); }
.promo-btn {
    height: 38px; padding: 0 14px; background: var(--green-pale);
    color: var(--green-dark); border: 1.5px solid var(--border);
    border-radius: 8px; font-family: 'Nunito', sans-serif;
    font-size: 13px; font-weight: 800; cursor: pointer; transition: all .2s;
}
.promo-btn:hover { background: var(--green-main); color: white; border-color: var(--green-main); }

/* Checkout btn */
.btn-checkout {
    width: 100%; padding: 14px; background: var(--green-main); color: white;
    border: none; border-radius: 12px; font-family: 'Nunito', sans-serif;
    font-size: 16px; font-weight: 900; cursor: pointer; transition: all .2s;
    display: flex; align-items: center; justify-content: center; gap: 8px;
    box-shadow: 0 4px 14px rgba(58,125,68,.3);
}
.btn-checkout:hover { background: var(--green-dark); transform: translateY(-2px); box-shadow: 0 8px 24px rgba(58,125,68,.35); }
.btn-checkout:disabled { opacity: .5; cursor: not-allowed; transform: none; box-shadow: none; }
.btn-continue {
    width: 100%; padding: 11px; background: transparent; color: var(--green-main);
    border: 1.5px solid var(--green-main); border-radius: 12px;
    font-family: 'Nunito', sans-serif; font-size: 14px; font-weight: 800;
    cursor: pointer; transition: all .2s; margin-top: 10px;
    display: flex; align-items: center; justify-content: center; gap: 6px;
    text-decoration: none;
}
.btn-continue:hover { background: var(--green-pale); }

/* Jaminan icons */
.guarantees { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-top: 16px; }
.guarantee-item {
    display: flex; flex-direction: column; align-items: center; gap: 5px;
    background: var(--green-bg); border-radius: 10px; padding: 10px 8px;
    text-align: center;
}
.guarantee-item span { font-size: 20px; }
.guarantee-item p { font-size: 10px; font-weight: 700; color: var(--text-mid); line-height: 1.3; }

/* ── Empty state ────────────────────────────────────────────────────── */
.cart-empty {
    background: white; border: 1.5px solid var(--border); border-radius: 20px;
    padding: 80px 40px; text-align: center;
}
.cart-empty-icon { font-size: 80px; margin-bottom: 20px; }
.cart-empty h2 { font-size: 22px; font-weight: 900; color: var(--text-dark); margin-bottom: 8px; }
.cart-empty p { font-size: 14px; color: var(--text-muted); margin-bottom: 28px; }
.btn-shop {
    display: inline-flex; align-items: center; gap: 8px;
    background: var(--green-main); color: white;
    padding: 13px 28px; border-radius: 12px;
    font-weight: 900; font-size: 15px; transition: all .2s;
    box-shadow: 0 4px 14px rgba(58,125,68,.3);
}
.btn-shop:hover { background: var(--green-dark); transform: translateY(-2px); }

/* ── Produk rekomendasi ─────────────────────────────────────────────── */
.rec-section { margin-top: 32px; }
.rec-grid { display: grid; grid-template-columns: repeat(5, 1fr); gap: 14px; }
.rec-card {
    background: white; border: 1px solid var(--border);
    border-radius: var(--r); overflow: hidden; cursor: pointer;
    transition: all .25s; position: relative;
}
.rec-card:hover { border-color: var(--green-main); transform: translateY(-4px); box-shadow: var(--shadow-md); }
.rec-img { width: 100%; aspect-ratio: 1; background: var(--green-pale); display: flex; align-items: center; justify-content: center; font-size: 52px; }
.rec-body { padding: 10px 12px; }
.rec-name { font-size: 13px; font-weight: 700; color: var(--text-dark); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.rec-price { font-size: 15px; font-weight: 900; color: var(--accent); margin-top: 4px; }
.rec-unit { font-size: 11px; color: var(--text-muted); }
.rec-add-btn {
    width: 100%; background: var(--green-pale); color: var(--green-dark);
    border: 1.5px solid var(--border); padding: 7px; border-radius: 7px;
    font-family: 'Nunito', sans-serif; font-weight: 800; font-size: 12px;
    margin-top: 8px; cursor: pointer; transition: all .2s;
    display: flex; align-items: center; justify-content: center; gap: 4px;
}
.rec-add-btn:hover { background: var(--green-main); color: white; border-color: var(--green-main); }

/* ── Toast notifikasi ───────────────────────────────────────────────── */
.toast {
    position: fixed; bottom: 28px; right: 28px;
    background: var(--green-dark); color: white;
    padding: 14px 20px; border-radius: 12px;
    font-size: 14px; font-weight: 700; z-index: 9999;
    display: flex; align-items: center; gap: 8px;
    box-shadow: var(--shadow-lg); opacity: 0;
    transform: translateY(16px);
    transition: opacity .3s, transform .3s;
    pointer-events: none; max-width: 320px;
}
.toast.show { opacity: 1; transform: translateY(0); }
.toast.error { background: #dc2626; }

/* ── Animasi ────────────────────────────────────────────────────────── */
@keyframes fadeUp { from { opacity: 0; transform: translateY(14px); } to { opacity: 1; transform: translateY(0); } }
.cart-item { animation: fadeUp .35s ease both; }

@media (max-width: 900px) {
    .cart-grid { grid-template-columns: 1fr; }
    .cart-right { position: static; }
    .rec-grid { grid-template-columns: repeat(3, 1fr); }
}
</style>
@endpush

@section('content')

<div class="cart-page">

    {{-- Breadcrumb --}}
    <div class="breadcrumb">
        <a href="{{ route('home') }}">🏠 Beranda</a>
        <span class="sep">/</span>
        <span class="cur">🛒 Keranjang Belanja</span>
    </div>

    @if($items->isEmpty())

    {{-- ═══ EMPTY STATE ════════════════════════════════════════════════ --}}
    <div class="cart-empty">
        <div class="cart-empty-icon">🛒</div>
        <h2>Keranjangmu masih kosong!</h2>
        <p>Yuk, temukan produk segar langsung dari petani lokal.</p>
        <a href="{{ route('home') }}" class="btn-shop">
            🌾 Mulai Belanja
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
            </svg>
        </a>
    </div>

    @else

    {{-- ═══ ISI KERANJANG ══════════════════════════════════════════════ --}}
    <div class="cart-grid">

        {{-- ── Panel Kiri ─────────────────────────────────────────────── --}}
        <div class="cart-left">

            {{-- Header --}}
            <div class="cart-header-row">
                <div>
                    <div class="cart-title">Keranjang Belanja</div>
                    <div class="cart-count">{{ $items->count() }} produk · {{ $items->sum('quantity') }} item</div>
                </div>
                <form method="POST" action="{{ route('cart.clear') }}"
                      onsubmit="return confirm('Kosongkan seluruh keranjang?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-clear-all">
                        🗑 Kosongkan Semua
                    </button>
                </form>
            </div>

            {{-- Select all --}}
            <div class="select-all-row">
                <input type="checkbox" class="custom-cb" id="selectAll" checked>
                <label for="selectAll" style="cursor:pointer;user-select:none">Pilih Semua</label>
                <span style="margin-left:auto;font-size:12px;color:var(--text-muted)">
                    {{ $items->sum('quantity') }} item dipilih
                </span>
            </div>

            {{-- Grouped by seller --}}
            @foreach($grouped as $sellerId => $sellerItems)
            @php
                $seller = $sellerItems->first()->harvest->seller;
                $sellerName = $seller?->shop_name ?? 'Petani';
            @endphp

            <div class="seller-group">
                {{-- Seller header --}}
                <div class="seller-group-header">
                    <input type="checkbox" class="custom-cb seller-cb" checked>
                    <div class="seller-ava">👨‍🌾</div>
                    <div>
                        <div class="seller-name">{{ $sellerName }}</div>
                        @if($seller?->description)
                            <div class="seller-loc">📍 {{ Str::limit($seller->description, 35) }}</div>
                        @endif
                    </div>
                    @auth
                    <a href="{{ route('chat.open') }}" class="chat-btn"
                       onclick="event.preventDefault(); openChat({{ $seller?->user_id ?? 'null' }})">
                        💬 Chat Petani
                    </a>
                    @endauth
                </div>

                {{-- Items --}}
                @foreach($sellerItems as $item)
                @php
                    $harvest = $item->harvest;
                    $product = $harvest?->product;
                    $stockPct = $harvest && $harvest->remaining_stock ? min(100, ($item->quantity / $harvest->remaining_stock) * 100) : 0;
                    $isLowStock = $harvest && $harvest->remaining_stock <= 10;
                @endphp
                <div class="cart-item" id="cart-item-{{ $item->id }}">
                    {{-- Checkbox --}}
                    <input type="checkbox" class="custom-cb item-cb" checked style="margin-top:34px;flex-shrink:0">

                    {{-- Gambar produk --}}
                    <div class="item-img" style="cursor:pointer"
                         onclick="window.location='{{ route('buyer.product.show', $harvest->id) }}'">
                        🌿
                        @if($harvest->is_organic)
                            <div class="item-organic-badge">ORGANIK</div>
                        @endif
                    </div>

                    {{-- Info --}}
                    <div class="item-body">
                        <div class="item-category">{{ $product?->category?->name ?? 'Produk Pertanian' }}</div>
                        <div class="item-name">{{ $product?->name ?? 'Produk' }}</div>
                        <div class="item-harvest-date">
                            🗓 Panen: {{ $harvest->harvest_date ? \Carbon\Carbon::parse($harvest->harvest_date)->translatedFormat('d M Y, H:i') : '-' }}
                        </div>

                        {{-- Harga + subtotal --}}
                        <div class="item-price-row">
                            <div>
                                <span class="item-price">Rp {{ number_format($harvest->price_per_unit, 0, ',', '.') }}</span>
                                <span class="item-unit">/{{ $product?->unit ?? 'unit' }}</span>
                            </div>
                            <div class="item-subtotal" id="subtotal-{{ $item->id }}">
                                = Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                            </div>
                        </div>

                        {{-- Stok warning --}}
                        @if($isLowStock)
                        <div class="item-stock-warn" style="margin-top:6px">
                            ⚠️ Stok tersisa {{ $harvest->remaining_stock }}{{ $product?->unit ? ' '.$product->unit : '' }}
                        </div>
                        @endif

                        {{-- Qty stepper --}}
                        <div class="qty-wrap">
                            <button class="qty-btn"
                                    onclick="changeQty({{ $item->id }}, -1, {{ $harvest->price_per_unit }}, {{ $harvest->remaining_stock }})"
                                    {{ $item->quantity <= 1 ? 'disabled' : '' }}>−</button>
                            <input  class="qty-input" type="number"
                                    id="qty-{{ $item->id }}"
                                    value="{{ $item->quantity }}"
                                    min="1" max="{{ $harvest->remaining_stock }}"
                                    onchange="setQty({{ $item->id }}, this.value, {{ $harvest->price_per_unit }}, {{ $harvest->remaining_stock }})">
                            <button class="qty-btn"
                                    onclick="changeQty({{ $item->id }}, 1, {{ $harvest->price_per_unit }}, {{ $harvest->remaining_stock }})"
                                    {{ $item->quantity >= $harvest->remaining_stock ? 'disabled' : '' }}>+</button>
                        </div>
                    </div>

                    {{-- Tombol hapus --}}
                    <div class="item-actions">
                        <button class="btn-remove" onclick="removeItem({{ $item->id }})" title="Hapus">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                        <div style="font-size:11px;color:var(--text-muted);text-align:center">Hapus</div>
                    </div>
                </div>
                @endforeach
            </div>
            @endforeach

            {{-- Tombol lanjut belanja --}}
            <a href="{{ route('home') }}" class="btn-continue" style="margin-top:4px">
                ← Lanjut Belanja
            </a>
        </div>

        {{-- ── Panel Kanan (Ringkasan) ────────────────────────────────── --}}
        <div class="cart-right">
            <div class="summary-card">
                <div class="summary-head">
                    🧾 Ringkasan Belanja
                </div>
                <div class="summary-body">

                    {{-- Kode promo --}}
                    <div class="promo-wrap">
                        <div class="promo-label">Kode Promo / Voucher</div>
                        <div class="promo-row">
                            <input type="text" class="promo-input" placeholder="MASUKKAN KODE" id="promoCode">
                            <button class="promo-btn" onclick="applyPromo()">Pakai</button>
                        </div>
                        <div id="promoMsg" style="font-size:12px;margin-top:5px;display:none"></div>
                    </div>

                    {{-- Baris total --}}
                    <div class="summary-row">
                        <span>Total Harga ({{ $items->sum('quantity') }} item)</span>
                        <strong id="summary-subtotal">Rp {{ number_format($subtotal, 0, ',', '.') }}</strong>
                    </div>
                    <div class="summary-row">
                        <span>Ongkos Kirim</span>
                        @if($ongkir == 0)
                            <span class="free-ongkir-badge">✅ Gratis!</span>
                        @else
                            <strong>Rp {{ number_format($ongkir, 0, ',', '.') }}</strong>
                        @endif
                    </div>
                    <div class="summary-row">
                        <span>Diskon Promo</span>
                        <strong id="summary-disc" style="color:var(--green-main)">−Rp 0</strong>
                    </div>
                    <div class="summary-row total">
                        <span>Total Bayar</span>
                        <span class="price-total" id="summary-total">
                            Rp {{ number_format($total, 0, ',', '.') }}
                        </span>
                    </div>

                    @if($subtotal < 50000)
                    <div style="background:#fff8e1;border:1px solid #ffe082;border-radius:8px;padding:10px 12px;font-size:12px;font-weight:700;color:#7c5a00;margin-bottom:14px;display:flex;align-items:center;gap:6px">
                        🚚 Tambah <strong>Rp {{ number_format(50000 - $subtotal, 0, ',', '.') }}</strong> lagi untuk gratis ongkir!
                    </div>
                    @endif

                    <button class="btn-checkout" id="checkoutBtn" onclick="handleCheckout()">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Checkout Sekarang
                    </button>
                    <a href="{{ route('home') }}" class="btn-continue">← Lanjut Belanja</a>

                    {{-- Jaminan --}}
                    <div class="guarantees">
                        <div class="guarantee-item">
                            <span>🔒</span>
                            <p>Pembayaran Aman</p>
                        </div>
                        <div class="guarantee-item">
                            <span>🔄</span>
                            <p>Garansi 3 Hari</p>
                        </div>
                        <div class="guarantee-item">
                            <span>✅</span>
                            <p>Produk Segar</p>
                        </div>
                        <div class="guarantee-item">
                            <span>🚚</span>
                            <p>Pengiriman Cepat</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>{{-- /cart-grid --}}
    @endif

    {{-- ═══ REKOMENDASI ════════════════════════════════════════════════ --}}
    @if(!$items->isEmpty())
    <div class="rec-section">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px">
            <h2 style="font-size:18px;font-weight:900;color:var(--text-dark);display:flex;align-items:center;gap:8px">
                <span style="display:block;width:4px;height:20px;background:var(--green-main);border-radius:2px"></span>
                Produk Lainnya
            </h2>
            <a href="{{ route('home') }}" style="font-size:13px;font-weight:700;color:var(--green-main)">Lihat Semua →</a>
        </div>
        <div class="rec-grid">
            @foreach(['🌽','🥦','🍅','🥕','🧅'] as $emoji)
            <div class="rec-card">
                <div class="rec-img">{{ $emoji }}</div>
                <div class="rec-body">
                    <div class="rec-name">Produk Segar Pilihan</div>
                    <div><span class="rec-price">Rp 8.500</span> <span class="rec-unit">/kg</span></div>
                    <button class="rec-add-btn">+ Keranjang</button>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

</div>

{{-- Toast --}}
<div class="toast" id="toast"></div>

@endsection

@push('scripts')
<script>
const CSRF = document.querySelector('meta[name="csrf-token"]').content;
let subtotalBase = {{ $subtotal }};
let ongkir       = {{ $ongkir }};
let promoDisc    = 0;

// ── Format rupiah ────────────────────────────────────────────────────
function fmtRp(n) {
    return 'Rp ' + Math.round(n).toLocaleString('id-ID');
}

// ── Toast ────────────────────────────────────────────────────────────
function showToast(msg, isError = false) {
    const t = document.getElementById('toast');
    t.textContent = (isError ? '❌ ' : '✅ ') + msg;
    t.className   = 'toast show' + (isError ? ' error' : '');
    clearTimeout(t._tid);
    t._tid = setTimeout(() => t.classList.remove('show'), 3000);
}

// ── Update ringkasan --------------------------------------------------
function refreshSummary() {
    // Hitung ulang dari semua item yang di-check
    let newSub = 0;
    document.querySelectorAll('.item-cb').forEach((cb, idx) => {
        if (!cb.checked) return;
        const row = cb.closest('.cart-item');
        if (!row) return;
        const id  = row.id.replace('cart-item-', '');
        const qty = parseInt(document.getElementById('qty-'+id)?.value ?? 0);
        const sub = parseFloat(row.dataset.price ?? 0) * qty;
        newSub += sub;
    });
    subtotalBase = newSub;
    ongkir       = subtotalBase >= 50000 ? 0 : 15000;
    const total  = subtotalBase + ongkir - promoDisc;

    document.getElementById('summary-subtotal').textContent = fmtRp(subtotalBase);
    document.getElementById('summary-total').textContent    = fmtRp(Math.max(0, total));
}

// ── Ubah qty ---------------------------------------------------------
async function changeQty(id, delta, price, maxStock) {
    const input = document.getElementById('qty-' + id);
    let qty = parseInt(input.value) + delta;
    qty = Math.max(1, Math.min(qty, maxStock));
    input.value = qty;
    await saveQty(id, qty, price);
}

async function setQty(id, val, price, maxStock) {
    let qty = parseInt(val);
    if (isNaN(qty) || qty < 1) qty = 1;
    if (qty > maxStock)        qty = maxStock;
    document.getElementById('qty-' + id).value = qty;
    await saveQty(id, qty, price);
}

async function saveQty(id, qty, price) {
    try {
        const res  = await fetch(`/keranjang/${id}`, {
            method: 'PATCH',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
            body: JSON.stringify({ quantity: qty })
        });
        const data = await res.json();
        if (data.success) {
            document.getElementById('subtotal-' + id).textContent =
                '= ' + fmtRp(data.subtotal);
            // update data-price jika belum ada
            const row = document.getElementById('cart-item-' + id);
            if (row) row.dataset.price = price;
            refreshSummary();
        }
    } catch(e) {
        showToast('Gagal update qty', true);
    }
}

// ── Hapus item ────────────────────────────────────────────────────────
async function removeItem(id) {
    const row = document.getElementById('cart-item-' + id);
    row?.classList.add('removing');
    try {
        const res  = await fetch(`/keranjang/${id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' }
        });
        const data = await res.json();
        if (data.success) {
            row?.remove();
            showToast('Item dihapus dari keranjang');
            refreshSummary();
            // Cek apakah masih ada item
            if (!document.querySelector('.cart-item')) {
                location.reload();
            }
        }
    } catch(e) {
        row?.classList.remove('removing');
        showToast('Gagal menghapus item', true);
    }
}

// ── Promo ─────────────────────────────────────────────────────────────
function applyPromo() {
    const code = document.getElementById('promoCode').value.trim().toUpperCase();
    const msg  = document.getElementById('promoMsg');
    // Contoh kode promo statis (hubungkan ke API promo nanti)
    const promos = { 'SEARA25': 25000, 'PETANI10': 10000 };
    if (promos[code]) {
        promoDisc = promos[code];
        msg.style.display = 'block';
        msg.style.color   = 'var(--green-main)';
        msg.innerHTML     = '✅ Promo berhasil! Diskon ' + fmtRp(promoDisc);
        document.getElementById('summary-disc').textContent = '−' + fmtRp(promoDisc);
        refreshSummary();
        showToast('Kode promo berhasil dipakai!');
    } else {
        msg.style.display = 'block';
        msg.style.color   = '#dc2626';
        msg.textContent   = '❌ Kode promo tidak valid.';
    }
}

// ── Checkbox logic ────────────────────────────────────────────────────
document.getElementById('selectAll')?.addEventListener('change', function() {
    document.querySelectorAll('.item-cb, .seller-cb').forEach(cb => cb.checked = this.checked);
    refreshSummary();
});
document.querySelectorAll('.item-cb').forEach(cb => {
    cb.addEventListener('change', refreshSummary);
});

// ── Checkout ─────────────────────────────────────────────────────────
function handleCheckout() {
    // Kumpulkan ID cart item yang dicentang
    const checked = [...document.querySelectorAll('.item-cb:checked')].map(cb => cb.dataset.id);
    if (checked.length === 0) {
        showToast('Pilih minimal satu produk untuk checkout.', 'warning');
        return;
    }
    const params = checked.map(id => `items[]=${id}`).join('&');
    window.location.href = `{{ route('orders.checkout.cart') }}?${params}`;
}

// ── Simpan data-price di setiap baris untuk perhitungan lokal ─────────
document.querySelectorAll('.cart-item').forEach(row => {
    // Ambil dari teks harga (fallback jika tidak ada dataset)
    if (!row.dataset.price) {
        const priceEl = row.querySelector('.item-price');
        if (priceEl) {
            const raw = priceEl.textContent.replace(/[^0-9]/g, '');
            row.dataset.price = raw || 0;
        }
    }
});

// ── Chat petani ───────────────────────────────────────────────────────
function openChat(userId) {
    if (!userId) return;
    fetch('{{ route("chat.open") }}', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
        body: JSON.stringify({ seller_user_id: userId })
    })
    .then(r => r.json())
    .then(data => {
        if (data.chat_room_id) {
            window.location.href = `/chat/${data.chat_room_id}`;
        }
    })
    .catch(() => showToast('Gagal membuka chat', true));
}
</script>
@endpush
