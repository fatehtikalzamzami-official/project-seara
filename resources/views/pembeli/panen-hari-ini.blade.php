@extends('layouts.app')

@section('title', 'Panen Hari Ini — SEARA')

@push('styles')
<style>
/* ── Page Header */
.phi-header {
    background: linear-gradient(135deg, #1a3c1a, var(--green-dark, #2d5a27));
    border-radius: var(--r, 12px);
    padding: 28px 32px;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.15);
}
.phi-header-left { flex: 1; }
.phi-header-emoji { font-size: 36px; margin-bottom: 4px; }
.phi-header-title { font-size: 24px; font-weight: 900; color: white; }
.phi-header-sub { font-size: 13px; color: rgba(255,255,255,0.7); margin-top: 4px; }
.phi-header-count {
    background: rgba(255,255,255,0.15);
    border: 1px solid rgba(255,255,255,0.25);
    border-radius: 10px;
    padding: 12px 22px;
    text-align: center;
    color: white;
    flex-shrink: 0;
}
.phi-header-count-num { font-size: 28px; font-weight: 900; }
.phi-header-count-lbl { font-size: 11px; opacity: 0.75; text-transform: uppercase; letter-spacing: .5px; }

/* ── Search + Filter bar */
.phi-filter-bar {
    display: flex;
    gap: 12px;
    margin-bottom: 24px;
    flex-wrap: wrap;
    align-items: center;
}
.phi-search-form {
    flex: 1;
    min-width: 240px;
    display: flex;
    border: 1.5px solid var(--border, #e2e8e0);
    border-radius: 10px;
    overflow: hidden;
    background: white;
    transition: border-color .2s;
}
.phi-search-form:focus-within { border-color: var(--green-light, #4caf50); }
.phi-search-form input {
    flex: 1;
    border: none;
    outline: none;
    padding: 10px 16px;
    font-size: 14px;
    background: transparent;
    color: var(--text-dark, #1a1a1a);
}
.phi-search-form input::placeholder { color: var(--text-muted, #9eada0); }
.phi-search-btn {
    padding: 10px 18px;
    background: var(--green-dark, #2d5a27);
    color: white;
    border: none;
    cursor: pointer;
    font-size: 14px;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 6px;
    transition: background .2s;
}
.phi-search-btn:hover { background: var(--green-mid, #3d7a36); }
.phi-clear-link {
    font-size: 13px;
    color: var(--text-muted, #9eada0);
    text-decoration: none;
    padding: 10px 12px;
    border-radius: 8px;
    border: 1.5px solid var(--border, #e2e8e0);
    background: white;
    white-space: nowrap;
    transition: all .2s;
}
.phi-clear-link:hover { border-color: #ccc; background: #f5f5f5; }

/* ── Category chips */
.phi-cats {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    margin-bottom: 20px;
}
.phi-cat-chip {
    padding: 7px 16px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    text-decoration: none;
    border: 1.5px solid var(--border, #e2e8e0);
    background: white;
    color: var(--text-mid, #4a5568);
    transition: all .2s;
}
.phi-cat-chip:hover { border-color: var(--green-light, #4caf50); color: var(--green-dark, #2d5a27); }
.phi-cat-chip.active {
    background: var(--green-dark, #2d5a27);
    border-color: var(--green-dark, #2d5a27);
    color: white;
}

/* ── Search result banner */
.phi-search-banner {
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    border-radius: 10px;
    padding: 12px 18px;
    margin-bottom: 16px;
    font-size: 14px;
    color: #166534;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
}
.phi-search-banner strong { font-weight: 800; }

/* ── Product grid */
.phi-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(210px, 1fr));
    gap: 16px;
    margin-bottom: 32px;
}
@media (max-width: 768px) { .phi-grid { grid-template-columns: repeat(2, 1fr); gap: 10px; } }
@media (max-width: 400px) { .phi-grid { grid-template-columns: 1fr; } }

/* ── Product card (reuse from dashboard) */
.phi-card {
    background: white;
    border: 1px solid var(--border, #e2e8e0);
    border-radius: var(--r, 12px);
    overflow: hidden;
    cursor: pointer;
    transition: transform .2s, box-shadow .2s;
}
.phi-card:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(0,0,0,0.1); }
.phi-card-img {
    aspect-ratio: 1;
    background: #f5f5f5;
    position: relative;
    overflow: hidden;
}
.phi-card-img img { width: 100%; height: 100%; object-fit: cover; display: block; }
.phi-card-img-fb {
    position: absolute; inset: 0;
    display: flex; align-items: center; justify-content: center;
    font-size: 48px; background: #f0f9f0;
}
.phi-badge {
    position: absolute;
    font-size: 11px; font-weight: 800;
    padding: 3px 8px;
    border-radius: 5px;
    line-height: 1.4;
}
.phi-badge.organic { top: 8px; left: 8px; background: #166534; color: white; }
.phi-badge.time { bottom: 8px; left: 8px; background: rgba(0,0,0,0.65); color: white; backdrop-filter: blur(4px); }
.phi-wishlist-btn {
    position: absolute; top: 8px; right: 8px;
    background: white; border: none; border-radius: 50%;
    width: 32px; height: 32px; font-size: 15px;
    cursor: pointer; box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    display: flex; align-items: center; justify-content: center;
    transition: transform .2s;
}
.phi-wishlist-btn:hover { transform: scale(1.15); }
.phi-card-body { padding: 12px; }
.phi-card-name { font-size: 14px; font-weight: 800; color: var(--text-dark, #1a1a1a); margin-bottom: 3px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.phi-card-farmer { font-size: 12px; color: var(--text-muted, #9eada0); margin-bottom: 8px; }
.phi-card-price { font-size: 16px; font-weight: 900; color: var(--green-dark, #2d5a27); }
.phi-card-unit { font-size: 11px; color: var(--text-muted, #9eada0); }
.phi-card-meta { display: flex; justify-content: space-between; font-size: 11px; color: var(--text-muted, #9eada0); margin: 6px 0; }
.phi-card-location { font-size: 11px; color: var(--text-muted, #9eada0); margin-bottom: 8px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.phi-add-btn {
    width: 100%;
    padding: 9px;
    background: var(--green-dark, #2d5a27);
    color: white;
    border: none;
    border-radius: 8px;
    font-weight: 800;
    font-size: 13px;
    cursor: pointer;
    transition: background .2s;
    text-align: center;
    text-decoration: none;
    display: block;
}
.phi-add-btn:hover { background: var(--green-mid, #3d7a36); }

/* ── Sold out overlay */
.phi-card-sold-out { opacity: 0.75; }
.phi-sold-overlay {
    position: absolute; inset: 0;
    background: rgba(0,0,0,0.45);
    display: flex; align-items: center; justify-content: center;
    color: white; font-weight: 900; font-size: 15px;
    letter-spacing: .5px;
}

/* ── Empty state */
.phi-empty {
    background: white;
    border: 1px solid var(--border, #e2e8e0);
    border-radius: var(--r, 12px);
    padding: 60px 40px;
    text-align: center;
    color: var(--text-muted, #9eada0);
}
.phi-empty-icon { font-size: 56px; margin-bottom: 12px; }
.phi-empty-title { font-size: 18px; font-weight: 800; color: var(--text-dark, #1a1a1a); margin-bottom: 6px; }
.phi-empty-sub { font-size: 14px; }
.phi-empty-link { color: var(--green-light, #4caf50); text-decoration: none; font-weight: 700; }

/* ── Pagination */
.phi-pagination {
    display: flex;
    justify-content: center;
    gap: 8px;
    flex-wrap: wrap;
    margin-top: 8px;
}
.phi-pagination .page-link, .phi-pagination span {
    padding: 8px 14px;
    border-radius: 8px;
    border: 1.5px solid var(--border, #e2e8e0);
    font-size: 13px;
    font-weight: 700;
    text-decoration: none;
    color: var(--text-dark, #1a1a1a);
    background: white;
    transition: all .2s;
    display: inline-block;
}
.phi-pagination .page-link:hover { border-color: var(--green-light, #4caf50); color: var(--green-dark, #2d5a27); }
.phi-pagination .active span {
    background: var(--green-dark, #2d5a27);
    border-color: var(--green-dark, #2d5a27);
    color: white;
}
.phi-pagination .disabled span { opacity: 0.4; cursor: not-allowed; }

/* ── Back breadcrumb */
.phi-breadcrumb {
    font-size: 13px;
    color: var(--text-muted, #9eada0);
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    gap: 6px;
}
.phi-breadcrumb a { color: var(--green-light, #4caf50); text-decoration: none; font-weight: 700; }
.phi-breadcrumb a:hover { text-decoration: underline; }
</style>
@endpush

@section('content')
<div style="max-width:1280px; margin:0 auto; padding:24px 16px;">

    {{-- Breadcrumb --}}
    <div class="phi-breadcrumb">
        <a href="{{ route('buyer.dashboard') }}">← Beranda</a>
        <span>/</span>
        <span>Panen Hari Ini</span>
    </div>

    {{-- Page Header --}}
    <div class="phi-header">
        <div class="phi-header-left">
            <div class="phi-header-emoji">🌾</div>
            <div class="phi-header-title">Panen Hari Ini</div>
            <div class="phi-header-sub">
                {{ now()->translatedFormat('l, d F Y') }} · Produk segar langsung dari petani
            </div>
        </div>
        <div class="phi-header-count">
            <div class="phi-header-count-num">{{ $total }}</div>
            <div class="phi-header-count-lbl">Produk tersedia</div>
        </div>
    </div>

    {{-- Search + Filter bar --}}
    <div class="phi-filter-bar">
        <form action="{{ route('buyer.panen.today') }}" method="GET" class="phi-search-form">
            @if($activeCategoryId)
                <input type="hidden" name="category" value="{{ $activeCategoryId }}">
            @endif
            <input
                type="text"
                name="q"
                placeholder="Cari nama produk atau petani..."
                value="{{ $search }}"
                autofocus
            >
            <button type="submit" class="phi-search-btn">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" width="15" height="15">
                    <circle cx="11" cy="11" r="8"/>
                    <path stroke-linecap="round" d="m21 21-4.35-4.35"/>
                </svg>
                Cari
            </button>
        </form>
        @if($search || $activeCategoryId)
            <a href="{{ route('buyer.panen.today') }}" class="phi-clear-link">✕ Reset</a>
        @endif
    </div>

    {{-- Category chips --}}
    <div class="phi-cats">
        <a href="{{ route('buyer.panen.today', $search ? ['q' => $search] : []) }}"
           class="phi-cat-chip {{ !$activeCategoryId ? 'active' : '' }}">
            Semua
        </a>
        @foreach($categories as $cat)
            <a href="{{ route('buyer.panen.today', array_filter(['category' => $cat->id, 'q' => $search])) }}"
               class="phi-cat-chip {{ $activeCategoryId == $cat->id ? 'active' : '' }}">
                {{ $cat->name }}
            </a>
        @endforeach
    </div>

    {{-- Search result banner --}}
    @if($search)
    <div class="phi-search-banner">
        <span>Menampilkan hasil untuk <strong>"{{ $search }}"</strong>
            — {{ $harvests->total() }} produk ditemukan</span>
        <a href="{{ route('buyer.panen.today', $activeCategoryId ? ['category' => $activeCategoryId] : []) }}"
           style="color:#166534; font-weight:700; text-decoration:none; font-size:13px; white-space:nowrap">
            ✕ Hapus
        </a>
    </div>
    @endif

    {{-- Helper: foto produk --}}
    @php
    $prodPhotos = [
        'Brokoli'=>'photo-1459411621453-7b03977f4bfc','Cabai Merah'=>'photo-1588252303782-cb80119abd6d',
        'Cabai Rawit'=>'photo-1525059696034-4967a8e1dca2','Tomat'=>'photo-1561136594-7f68813130d3',
        'Bayam'=>'photo-1576045057995-568f588f82fb','Kangkung'=>'photo-1622206151226-18ca2c9ab4a1',
        'Wortel'=>'photo-1598170845058-32b9d6a5da37','Kentang'=>'photo-1518977676601-b53f82aba655',
        'Terong Ungu'=>'photo-1659261200833-ec8761558af7','Pare'=>'photo-1617692855027-33b14f061079',
        'Kacang Panjang'=>'photo-1471194402529-8e0f5a675de6','Sawi Hijau'=>'photo-1540420773420-3366772f4999',
        'Selada'=>'photo-1622206151226-18ca2c9ab4a1','Timun'=>'photo-1449300079323-02e209d9d3a6',
        'Mangga Harum Manis'=>'photo-1553279768-865429fa0078','Alpukat Mentega'=>'photo-1523049673857-eb18f1d7b578',
        'Pisang Kepok'=>'photo-1571771894821-ce9b6c11b08e','Pisang Ambon'=>'photo-1528825871115-3581a5387919',
        'Jeruk Baby'=>'photo-1547514701-42782101795e','Jeruk Keprok'=>'photo-1611080626919-7cf5a9dbab12',
        'Apel Malang'=>'photo-1560806887-1e4cd0b6cbd6','Stroberi'=>'photo-1543528176-61b239494933',
        'Semangka'=>'photo-1563114773-84221bd62daa','Melon'=>'photo-1571575173700-afb9492e6a50',
        'Jahe Emprit'=>'photo-1615485500704-8e990f9900f7','Jahe Merah'=>'photo-1615485500704-8e990f9900f7',
        'Kunyit'=>'photo-1615485291234-9d694218aeb3','Bawang Merah'=>'photo-1518977676601-b53f82aba655',
        'Bawang Putih'=>'photo-1615485291234-9d694218aeb3','Jagung Manis'=>'photo-1551754655-cd27e38d2076',
        'Kopi Robusta'=>'photo-1447933601403-0c6688de566e','Kopi Arabika'=>'photo-1618160702438-9b02ab6515c9',
        'Singkong'=>'photo-1596591868231-05e808fd4b6d','Ubi Jalar Ungu'=>'photo-1567306301408-9b74779a11af',
        'Ubi Cilembu'=>'photo-1567306301408-9b74779a11af','Beras Merah'=>'photo-1536304929831-ee1ca9d44906',
        'Beras Organik'=>'photo-1536304929831-ee1ca9d44906',
    ];
    $getProdPhoto = function(string $name) use ($prodPhotos): ?string {
        if (!isset($prodPhotos[$name])) return null;
        return 'https://images.unsplash.com/' . $prodPhotos[$name] . '?w=400&h=400&q=80&auto=format&fit=crop';
    };
    @endphp

    {{-- Product Grid --}}
    @if($harvests->isEmpty())
        <div class="phi-empty">
            <div class="phi-empty-icon">{{ $search ? '🔍' : '🌾' }}</div>
            <div class="phi-empty-title">
                @if($search)
                    Tidak ada produk untuk "{{ $search }}"
                @else
                    Belum ada panen hari ini
                @endif
            </div>
            <div class="phi-empty-sub">
                @if($search)
                    Coba kata kunci lain atau
                    <a class="phi-empty-link" href="{{ route('buyer.panen.today') }}">lihat semua panen hari ini</a>
                @else
                    Cek kembali besok atau <a class="phi-empty-link" href="{{ route('buyer.dashboard') }}">jelajahi semua produk</a>
                @endif
            </div>
        </div>

        {{-- Rekomendasi saat search tidak ketemu --}}
        @if($search && !empty($recommendations) && $recommendations->isNotEmpty())
        <div style="margin-top:32px">
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:16px">
                <div style="width:4px;height:24px;background:var(--green-dark,#2d5a27);border-radius:2px"></div>
                <h3 style="font-size:16px;font-weight:900;color:var(--text-dark,#1a1a1a);margin:0">
                    Mungkin kamu suka ini 👇
                </h3>
                <span style="font-size:12px;color:var(--text-muted,#9eada0)">— Panen hari ini yang tersedia</span>
            </div>
            <div class="phi-grid">
                @foreach($recommendations as $h)
                    @php
                        $panenStr  = \Carbon\Carbon::parse($h->harvest_date)->format('Y-m-d H:i:s');
                        $photoUrl  = $getProdPhoto($h->product->name ?? '');
                        $stokHabis = ($h->remaining_stock ?? 0) <= 0;
                    @endphp
                    <div class="phi-card {{ $stokHabis ? 'phi-card-sold-out' : '' }}"
                         onclick="window.location='{{ route('buyer.product.show', $h->id) }}'">
                        <div class="phi-card-img">
                            @if($photoUrl)
                                <img src="{{ $photoUrl }}" alt="{{ $h->product->name ?? 'Produk' }}"
                                     loading="lazy"
                                     onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                                <div class="phi-card-img-fb" style="display:none">🌾</div>
                            @else
                                <div class="phi-card-img-fb">🌾</div>
                            @endif
                            @if($stokHabis)<div class="phi-sold-overlay">Stok Habis</div>@endif
                            @if($h->is_organic)<span class="phi-badge organic">Organik</span>@endif
                            <span class="phi-badge time" data-panen="{{ $panenStr }}">⏱ ...</span>
                            @auth
                            @if(!$stokHabis)
                            <button class="phi-wishlist-btn" data-harvest-id="{{ $h->id }}"
                                    onclick="event.stopPropagation()">🤍</button>
                            @endif
                            @endauth
                        </div>
                        <div class="phi-card-body">
                            <div class="phi-card-name">{{ $h->product->name ?? 'Produk' }}</div>
                            <div class="phi-card-farmer">👨‍🌾 {{ $h->seller->user->name ?? 'Petani' }}</div>
                            <div style="display:flex;align-items:baseline;gap:4px;margin-bottom:4px">
                                <div class="phi-card-price">Rp {{ number_format($h->price_per_unit, 0, ',', '.') }}</div>
                                <div class="phi-card-unit">/{{ $h->product->unit ?? 'kg' }}</div>
                            </div>
                            <div class="phi-card-meta">
                                <span>📦 {{ $h->remaining_stock }} stok</span>
                                <span>{{ $h->product->category->name ?? '' }}</span>
                            </div>
                            <div class="phi-card-location">📍 {{ $h->seller->kota_kabupaten ?? $h->seller->user->alamat ?? 'Indonesia' }}</div>
                            @if($stokHabis)
                                <div class="phi-add-btn" style="background:#ccc;cursor:not-allowed;opacity:.7">Stok Habis</div>
                            @else
                                @auth
                                <button class="phi-add-btn"
                                        onclick="event.stopPropagation(); addToCart({{ $h->id }}, this)">
                                    🛒 + Keranjang
                                </button>
                                @else
                                <a href="/" class="phi-add-btn" onclick="event.stopPropagation()">Login untuk Beli</a>
                                @endauth
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

    @else
    <div class="phi-grid">
        @foreach($harvests as $h)
            @php
                $panenStr = \Carbon\Carbon::parse($h->harvest_date)->format('Y-m-d H:i:s');
                $photoUrl = $getProdPhoto($h->product->name ?? '');
                $stokHabis = ($h->remaining_stock ?? 0) <= 0;
            @endphp
            <div class="phi-card {{ $stokHabis ? 'phi-card-sold-out' : '' }}"
                 onclick="window.location='{{ route('buyer.product.show', $h->id) }}'">
                <div class="phi-card-img">
                    @if($photoUrl)
                        <img src="{{ $photoUrl }}" alt="{{ $h->product->name ?? 'Produk' }}"
                             loading="lazy"
                             onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                        <div class="phi-card-img-fb" style="display:none">🌾</div>
                    @else
                        <div class="phi-card-img-fb">🌾</div>
                    @endif
                    @if($stokHabis)
                        <div class="phi-sold-overlay">Stok Habis</div>
                    @endif
                    @if($h->is_organic)
                        <span class="phi-badge organic">Organik</span>
                    @endif
                    <span class="phi-badge time" data-panen="{{ $panenStr }}">⏱ ...</span>
                    @auth
                    @if(!$stokHabis)
                    <button class="phi-wishlist-btn" data-harvest-id="{{ $h->id }}"
                            onclick="event.stopPropagation()">🤍</button>
                    @endif
                    @endauth
                </div>
                <div class="phi-card-body">
                    <div class="phi-card-name">{{ $h->product->name ?? 'Produk' }}</div>
                    <div class="phi-card-farmer">👨‍🌾 {{ $h->seller->user->name ?? 'Petani' }}</div>
                    <div style="display:flex;align-items:baseline;gap:4px;margin-bottom:4px">
                        <div class="phi-card-price">Rp {{ number_format($h->price_per_unit, 0, ',', '.') }}</div>
                        <div class="phi-card-unit">/{{ $h->product->unit ?? 'kg' }}</div>
                    </div>
                    <div class="phi-card-meta">
                        <span>📦 {{ $h->remaining_stock }} stok</span>
                        <span>{{ $h->product->category->name ?? '' }}</span>
                    </div>
                    <div class="phi-card-location">📍 {{ $h->seller->kota_kabupaten ?? $h->seller->user->alamat ?? 'Indonesia' }}</div>
                    @if($stokHabis)
                        <div class="phi-add-btn" style="background:#ccc;cursor:not-allowed;opacity:.7">Stok Habis</div>
                    @else
                        @auth
                        <button class="phi-add-btn"
                                onclick="event.stopPropagation(); addToCart({{ $h->id }}, this)">
                            🛒 + Keranjang
                        </button>
                        @else
                        <a href="/" class="phi-add-btn" onclick="event.stopPropagation()">Login untuk Beli</a>
                        @endauth
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    @if($harvests->hasPages())
    <div class="phi-pagination">
        {{ $harvests->onEachSide(1)->links('pagination::simple-tailwind') }}
    </div>
    @endif
    @endif

</div>
@endsection

@push('scripts')
<script>
/* ── Countdown timer — sama dengan dashboard: hitung sejak panen */
function updateTimers() {
    const now = new Date();
    document.querySelectorAll('.phi-badge.time[data-panen]').forEach(el => {
        const panenDate = new Date(el.dataset.panen);
        const diffMs    = now - panenDate;

        if (diffMs < 0) {
            el.textContent = '⏱ Belum Panen';
            return;
        }

        const totalSec = Math.floor(diffMs / 1000);
        const hrs  = Math.floor(totalSec / 3600);
        const mins = Math.floor((totalSec % 3600) / 60);
        const secs = totalSec % 60;
        el.textContent = '⏱ ' + String(hrs).padStart(2,'0') + ':' + String(mins).padStart(2,'0') + ':' + String(secs).padStart(2,'0');

        el.classList.remove('badge-yellow','badge-red');
        const jamBerlalu = diffMs / 3600000;
        if (jamBerlalu >= 4) el.classList.add('badge-red');
        else if (jamBerlalu >= 2) el.classList.add('badge-yellow');
    });
}
updateTimers();
setInterval(updateTimers, 1000);

/* ── Add to cart */
async function addToCart(harvestId, btn) {
    btn.disabled = true;
    btn.textContent = '⏳ Memproses...';
    try {
        const r = await fetch('/keranjang', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content ?? ''
            },
            body: JSON.stringify({ harvest_id: harvestId, quantity: 1 })
        });
        const d = await r.json();
        if (r.ok) {
            btn.textContent = '✓ Ditambahkan!';
            btn.style.background = '#166534';
            setTimeout(() => { btn.textContent = '🛒 + Keranjang'; btn.style.background = ''; btn.disabled = false; }, 2000);
        } else {
            btn.textContent = d.message ?? 'Gagal';
            setTimeout(() => { btn.textContent = '🛒 + Keranjang'; btn.disabled = false; }, 2000);
        }
    } catch {
        btn.textContent = 'Error';
        setTimeout(() => { btn.textContent = '🛒 + Keranjang'; btn.disabled = false; }, 2000);
    }
}

/* ── Wishlist toggle */
document.querySelectorAll('.phi-wishlist-btn').forEach(btn => {
    btn.addEventListener('click', async function() {
        const harvestId = this.dataset.harvestId;
        try {
            const r = await fetch('/wishlist/toggle', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content ?? ''
                },
                body: JSON.stringify({ harvest_id: harvestId })
            });
            const d = await r.json();
            this.textContent = d.wishlisted ? '❤️' : '🤍';
        } catch {}
    });
});
</script>
@endpush