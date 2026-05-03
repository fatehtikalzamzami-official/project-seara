@extends('layouts.app')

@section('title', 'Wishlist Saya — SEARA')

@push('styles')
<style>
/* ── Layout ─────────────────────────────────────────────────────────── */
.wishlist-page { max-width: 1280px; margin: 0 auto; padding: 24px 24px 80px; }

/* ── Breadcrumb ─────────────────────────────────────────────────────── */
.breadcrumb { display: flex; align-items: center; gap: 6px; font-size: 13px; color: var(--text-muted); margin-bottom: 24px; flex-wrap: wrap; }
.breadcrumb a { color: var(--text-muted); transition: color .2s; }
.breadcrumb a:hover { color: var(--green-main); }
.breadcrumb .sep { opacity: .4; }
.breadcrumb .cur { color: var(--text-dark); font-weight: 700; }

/* ── Header ─────────────────────────────────────────────────────────── */
.wl-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; }
.wl-title { font-size: 22px; font-weight: 900; color: var(--text-dark); display: flex; align-items: center; gap: 8px; }
.wl-title::before { content: ''; display: block; width: 4px; height: 24px; background: var(--green-main); border-radius: 2px; }
.wl-count { font-size: 14px; font-weight: 600; color: var(--text-muted); }

/* ── Grid produk ────────────────────────────────────────────────────── */
.wl-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 18px;
}

/* ── Kartu produk ───────────────────────────────────────────────────── */
.wl-card {
    background: white;
    border: 1px solid var(--border);
    border-radius: 14px;
    overflow: hidden;
    transition: box-shadow .2s, transform .2s;
    position: relative;
    cursor: pointer;
}
.wl-card:hover {
    box-shadow: var(--shadow-md);
    transform: translateY(-2px);
}
.wl-card.removing {
    opacity: .3;
    pointer-events: none;
    transition: opacity .3s;
}

.wl-img {
    height: 140px;
    background: var(--green-pale);
    display: flex; align-items: center; justify-content: center;
    font-size: 56px;
    position: relative;
}
.wl-organic {
    position: absolute; bottom: 8px; left: 8px;
    background: var(--green-main); color: white;
    font-size: 10px; font-weight: 800;
    padding: 3px 7px; border-radius: 5px; letter-spacing: .5px;
}
.wl-remove-btn {
    position: absolute; top: 8px; right: 8px;
    width: 30px; height: 30px;
    background: white; border-radius: 50%;
    border: none; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    font-size: 16px;
    box-shadow: 0 2px 8px rgba(0,0,0,.12);
    transition: background .2s, transform .2s;
}
.wl-remove-btn:hover { background: #fef2f2; transform: scale(1.1); }

.wl-body { padding: 14px; }
.wl-category { font-size: 10px; font-weight: 800; color: var(--green-main); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px; }
.wl-name { font-size: 15px; font-weight: 800; color: var(--text-dark); margin-bottom: 4px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.wl-farmer { font-size: 12px; color: var(--text-muted); margin-bottom: 8px; }
.wl-price { font-size: 16px; font-weight: 900; color: var(--green-dark); margin-bottom: 4px; }
.wl-unit { font-size: 11px; color: var(--text-muted); font-weight: 600; }
.wl-stock { font-size: 11px; margin-top: 6px; }
.wl-stock.ok { color: var(--green-mid); font-weight: 700; }
.wl-stock.low { color: #f59e0b; font-weight: 700; }
.wl-stock.empty { color: #dc2626; font-weight: 700; }

.wl-actions { padding: 0 14px 14px; display: flex; gap: 8px; }
.btn-add-cart {
    flex: 1;
    background: var(--green-main); color: white;
    border: none; border-radius: 8px;
    padding: 9px 0; font-family: 'Nunito', sans-serif;
    font-size: 13px; font-weight: 800; cursor: pointer;
    transition: background .2s;
    text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 5px;
}
.btn-add-cart:hover { background: var(--green-dark); }
.btn-add-cart:disabled { background: var(--text-muted); cursor: not-allowed; }
.btn-detail {
    background: var(--green-pale); color: var(--green-dark);
    border: 1.5px solid var(--border); border-radius: 8px;
    padding: 9px 12px; font-family: 'Nunito', sans-serif;
    font-size: 13px; font-weight: 700; cursor: pointer;
    transition: background .2s; text-decoration: none;
    display: flex; align-items: center; justify-content: center;
}
.btn-detail:hover { background: var(--green-pale); border-color: var(--green-main); }

/* ── Empty state ────────────────────────────────────────────────────── */
.wl-empty {
    text-align: center;
    padding: 80px 24px;
    background: white;
    border: 1px solid var(--border);
    border-radius: 16px;
}
.wl-empty-icon { font-size: 72px; margin-bottom: 16px; line-height: 1; }
.wl-empty-title { font-size: 20px; font-weight: 800; color: var(--text-dark); margin-bottom: 8px; }
.wl-empty-desc { font-size: 14px; color: var(--text-muted); margin-bottom: 24px; }
.btn-explore {
    display: inline-flex; align-items: center; gap: 8px;
    background: var(--green-main); color: white;
    padding: 12px 28px; border-radius: 10px;
    font-family: 'Nunito', sans-serif; font-weight: 800; font-size: 15px;
    text-decoration: none; transition: background .2s;
}
.btn-explore:hover { background: var(--green-dark); }

/* ── Toast notif ────────────────────────────────────────────────────── */
.wl-toast {
    position: fixed; bottom: 24px; left: 50%; transform: translateX(-50%) translateY(80px);
    background: var(--green-dark); color: white;
    padding: 12px 24px; border-radius: 10px;
    font-size: 14px; font-weight: 700;
    box-shadow: var(--shadow-md); z-index: 9999;
    transition: transform .3s cubic-bezier(.34,1.56,.64,1);
    white-space: nowrap;
}
.wl-toast.show { transform: translateX(-50%) translateY(0); }

@media (max-width: 640px) {
    .wl-grid { grid-template-columns: repeat(2, 1fr); gap: 12px; }
    .wl-actions { flex-direction: column; }
}
</style>
@endpush

@section('content')
<div class="wishlist-page">

    {{-- Breadcrumb --}}
    <nav class="breadcrumb">
        <a href="{{ route('home') }}">🏠 Beranda</a>
        <span class="sep">›</span>
        <span class="cur">❤️ Wishlist Saya</span>
    </nav>

    {{-- Header --}}
    <div class="wl-header">
        <h1 class="wl-title">
            Wishlist Saya
            <span class="wl-count">({{ $items->count() }} item)</span>
        </h1>
    </div>

    @if($items->isEmpty())
        {{-- Empty state --}}
        <div class="wl-empty">
            <div class="wl-empty-icon">🤍</div>
            <div class="wl-empty-title">Wishlist-mu masih kosong</div>
            <div class="wl-empty-desc">Tambahkan produk dari beranda dengan menekan ikon ❤️ di kartu produk.</div>
            <a href="{{ route('buyer.dashboard') }}" class="btn-explore">
                🌾 Jelajahi Produk
            </a>
        </div>
    @else
        <div class="wl-grid" id="wishlistGrid">
            @foreach($items as $item)
                @php
                    $harvest  = $item->harvest;
                    $product  = $harvest->product;
                    $seller   = $harvest->seller;
                    $stock    = $harvest->remaining_stock;
                @endphp
                <div class="wl-card" id="wl-card-{{ $item->id }}" onclick="goToDetail({{ $harvest->id }})">
                    <div class="wl-img">
                        🌾
                        @if($harvest->is_organic)
                            <span class="wl-organic">Organik</span>
                        @endif
                        <button class="wl-remove-btn"
                            onclick="removeWishlist(event, {{ $item->id }}, {{ $harvest->id }})"
                            title="Hapus dari wishlist">
                            ❤️
                        </button>
                    </div>
                    <div class="wl-body">
                        <div class="wl-category">{{ $product->category->name ?? 'Produk' }}</div>
                        <div class="wl-name" title="{{ $product->name }}">{{ $product->name }}</div>
                        <div class="wl-farmer">👨‍🌾 {{ $seller->user->name ?? 'Petani' }}</div>
                        <div class="wl-price">Rp {{ number_format($harvest->price_per_unit, 0, ',', '.') }}</div>
                        <div class="wl-unit">/ {{ $product->unit ?? 'unit' }}</div>
                        @if($stock <= 0)
                            <div class="wl-stock empty">✗ Stok habis</div>
                        @elseif($stock <= 10)
                            <div class="wl-stock low">⚠ Stok tersisa {{ $stock }} {{ $product->unit }}</div>
                        @else
                            <div class="wl-stock ok">✓ Tersedia {{ $stock }} {{ $product->unit }}</div>
                        @endif
                    </div>
                    <div class="wl-actions">
                        <button class="btn-add-cart"
                            onclick="addToCart(event, {{ $harvest->id }})"
                            {{ $stock <= 0 ? 'disabled' : '' }}>
                            🛒 Keranjang
                        </button>
                        <a href="{{ route('buyer.product.show', $harvest->id) }}"
                           class="btn-detail"
                           onclick="event.stopPropagation()">
                            👁
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

{{-- Toast --}}
<div class="wl-toast" id="wlToast"></div>
@endsection

@push('scripts')
<script>
const CSRF = document.querySelector('meta[name="csrf-token"]').content;

// ── Hapus dari wishlist ──────────────────────────────────────────────────
async function removeWishlist(e, wishlistId, harvestId) {
    e.stopPropagation();
    const card = document.getElementById('wl-card-' + wishlistId);
    card.classList.add('removing');

    try {
        const res = await fetch(`/wishlist/${wishlistId}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' }
        });
        const data = await res.json();
        if (data.success) {
            setTimeout(() => {
                card.remove();
                updateCount();
                showToast('Dihapus dari wishlist');
            }, 300);
        }
    } catch(err) {
        card.classList.remove('removing');
        showToast('Gagal menghapus, coba lagi');
    }
}

// ── Tambah ke keranjang ──────────────────────────────────────────────────
async function addToCart(e, harvestId) {
    e.stopPropagation();
    const btn = e.currentTarget;
    btn.disabled = true;
    btn.textContent = '⏳ Menambahkan...';

    try {
        const res = await fetch('/keranjang', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': CSRF,
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ harvest_id: harvestId, quantity: 1 })
        });
        const data = await res.json();
        if (data.success) {
            btn.textContent = '✓ Ditambahkan!';
            showToast('Berhasil ditambahkan ke keranjang 🛒');

            // Update badge keranjang di topbar
            const badge = document.getElementById('cartBadge');
            if (badge && data.cart_count > 0) {
                badge.textContent = data.cart_count;
                badge.style.display = 'flex';
            }

            setTimeout(() => {
                btn.disabled = false;
                btn.innerHTML = '🛒 Keranjang';
            }, 2000);
        }
    } catch(err) {
        btn.disabled = false;
        btn.innerHTML = '🛒 Keranjang';
        showToast('Gagal menambahkan, coba lagi');
    }
}

// ── Navigasi ke detail produk ─────────────────────────────────────────────
function goToDetail(harvestId) {
    window.location.href = `/buyer/produk/${harvestId}`;
}

// ── Update jumlah item di header ──────────────────────────────────────────
function updateCount() {
    const remaining = document.querySelectorAll('.wl-card').length;
    const countEl = document.querySelector('.wl-count');
    if (countEl) countEl.textContent = `(${remaining} item)`;

    if (remaining === 0) {
        document.getElementById('wishlistGrid').innerHTML = `
            <div style="grid-column:1/-1">
                <div class="wl-empty">
                    <div class="wl-empty-icon">🤍</div>
                    <div class="wl-empty-title">Wishlist-mu sudah kosong</div>
                    <div class="wl-empty-desc">Tambahkan produk dari beranda.</div>
                    <a href="{{ route('buyer.dashboard') }}" class="btn-explore">🌾 Jelajahi Produk</a>
                </div>
            </div>`;
    }
}

// ── Toast ─────────────────────────────────────────────────────────────────
function showToast(msg) {
    const t = document.getElementById('wlToast');
    t.textContent = msg;
    t.classList.add('show');
    setTimeout(() => t.classList.remove('show'), 2500);
}
</script>
@endpush
