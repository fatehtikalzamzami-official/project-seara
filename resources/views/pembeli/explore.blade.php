@extends('layouts.app')

@section('title', 'Jelajahi Toko Petani — SEARA')

@push('styles')
<style>
.explore-page { max-width: 1280px; margin: 0 auto; padding: 24px 24px 80px; }

/* Header */
.explore-hero { background: linear-gradient(135deg, var(--green-dark), var(--green-main)); border-radius: var(--r); padding: 32px 36px; margin-bottom: 24px; color: white; display: flex; align-items: center; justify-content: space-between; gap: 24px; flex-wrap: wrap; }
.explore-hero h1 { font-family: 'Playfair Display', serif; font-size: 28px; font-weight: 700; }
.explore-hero p { font-size: 14px; opacity: .8; margin-top: 6px; }

/* Search + filter bar */
.filter-bar { background: white; border: 1px solid var(--border); border-radius: var(--r); padding: 16px 20px; margin-bottom: 24px; display: flex; gap: 12px; flex-wrap: wrap; align-items: center; }
.search-wrap { flex: 1; min-width: 200px; position: relative; }
.search-wrap input { width: 100%; padding: 10px 16px 10px 40px; border: 1.5px solid var(--border); border-radius: 10px; font-family: 'Nunito', sans-serif; font-size: 14px; outline: none; transition: border-color .2s; }
.search-wrap input:focus { border-color: var(--green-main); }
.search-wrap .search-icon { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); font-size: 16px; pointer-events: none; }
.filter-select { padding: 10px 14px; border: 1.5px solid var(--border); border-radius: 10px; font-family: 'Nunito', sans-serif; font-size: 13px; font-weight: 700; color: var(--text-mid); outline: none; cursor: pointer; background: white; transition: border-color .2s; }
.filter-select:focus { border-color: var(--green-main); }
.btn-search { padding: 10px 22px; background: var(--green-main); color: white; border: none; border-radius: 10px; font-family: 'Nunito', sans-serif; font-weight: 800; font-size: 13px; cursor: pointer; transition: background .2s; white-space: nowrap; }
.btn-search:hover { background: var(--green-dark); }

/* Grid */
.sellers-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 18px; }

/* Seller card */
.seller-card { background: white; border: 1px solid var(--border); border-radius: 14px; overflow: hidden; transition: all .25s; cursor: pointer; }
.seller-card:hover { border-color: var(--green-main); transform: translateY(-4px); box-shadow: var(--shadow-md); }
.seller-card-banner { height: 90px; background: linear-gradient(135deg, var(--green-dark), var(--green-main)); position: relative; display: flex; align-items: center; justify-content: center; font-size: 40px; }
.seller-card-body { padding: 14px 16px 16px; }
.seller-avatar { width: 56px; height: 56px; border-radius: 50%; background: white; border: 3px solid white; display: flex; align-items: center; justify-content: center; font-size: 28px; box-shadow: 0 2px 8px rgba(0,0,0,.12); margin-top: -32px; margin-bottom: 8px; overflow: hidden; flex-shrink: 0; }
.seller-avatar img { width: 100%; height: 100%; object-fit: cover; }
.seller-name { font-size: 15px; font-weight: 900; color: var(--text-dark); }
.seller-kategori { font-size: 11px; font-weight: 700; color: var(--green-main); text-transform: uppercase; letter-spacing: .5px; margin-top: 2px; }
.seller-loc { font-size: 12px; color: var(--text-muted); margin-top: 4px; display: flex; align-items: center; gap: 4px; }
.seller-stats { display: flex; gap: 16px; margin-top: 12px; padding-top: 12px; border-top: 1px solid var(--border); }
.seller-stat { font-size: 11px; color: var(--text-muted); }
.seller-stat strong { display: block; font-size: 14px; font-weight: 900; color: var(--text-dark); }
.verified-chip { display: inline-flex; align-items: center; gap: 3px; background: var(--green-pale); color: var(--green-dark); font-size: 10px; font-weight: 800; padding: 2px 8px; border-radius: 4px; margin-top: 6px; }
.open-chip { display: inline-flex; align-items: center; gap: 4px; font-size: 11px; font-weight: 700; padding: 3px 8px; border-radius: 6px; margin-left: 6px; }
.open-chip.open { background: #dcfce7; color: #166534; }
.open-chip.closed { background: #fee2e2; color: #991b1b; }
.btn-visit { display: block; width: 100%; margin-top: 12px; padding: 9px; background: var(--green-pale); color: var(--green-dark); border: none; border-radius: 9px; font-family: 'Nunito', sans-serif; font-weight: 800; font-size: 13px; text-align: center; text-decoration: none; transition: background .2s; }
.btn-visit:hover { background: #c8e6c9; }

/* Empty */
.empty-state { text-align: center; padding: 60px 20px; }
.es-icon { font-size: 56px; margin-bottom: 14px; }
.es-title { font-size: 18px; font-weight: 900; color: var(--text-dark); margin-bottom: 8px; }
.es-sub { font-size: 13px; color: var(--text-muted); }
</style>
@endpush

@section('content')
<div class="explore-page">

    {{-- Hero --}}
    <div class="explore-hero">
        <div>
            <h1>🌾 Jelajahi Toko Petani</h1>
            <p>Temukan petani lokal terpercaya dan beli langsung dari sumbernya</p>
        </div>
        <div style="font-size:13px;opacity:.8;text-align:right;">
            <strong style="font-size:22px;display:block;">{{ $sellers->total() }}</strong>
            toko ditemukan
        </div>
    </div>

    {{-- Filter --}}
    <form action="{{ route('explore') }}" method="GET" class="filter-bar">
        <div class="search-wrap">
            <span class="search-icon">🔍</span>
            <input type="text" name="q" placeholder="Cari nama toko, produk..."
                value="{{ $search }}" autocomplete="off">
        </div>
        <select name="kategori" class="filter-select">
            <option value="">Semua Kategori</option>
            @foreach($kategoriList as $k)
            <option value="{{ $k }}" {{ $kategori === $k ? 'selected' : '' }}>{{ $k }}</option>
            @endforeach
        </select>
        <select name="provinsi" class="filter-select">
            <option value="">Semua Provinsi</option>
            @foreach($provinsiList as $p)
            <option value="{{ $p }}" {{ $provinsi === $p ? 'selected' : '' }}>{{ $p }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn-search">Cari Toko</button>
        @if($search || $kategori || $provinsi)
        <a href="{{ route('explore') }}" style="font-size:13px;font-weight:700;color:var(--text-muted);">✕ Reset</a>
        @endif
    </form>

    {{-- Grid --}}
    @if($sellers->isEmpty())
    <div class="empty-state">
        <div class="es-icon">🏪</div>
        <div class="es-title">Toko tidak ditemukan</div>
        <div class="es-sub">Coba ubah kata kunci atau filter pencarian</div>
    </div>
    @else
    <div class="sellers-grid">
        @foreach($sellers as $sp)
        <div class="seller-card" onclick="window.location='{{ route('store.show', $sp->slug_toko) }}'">
            {{-- Banner --}}
            <div class="seller-card-banner">
                @if(isset($sp->banner_toko) && $sp->banner_toko)
                    <img src="{{ asset('storage/'.$sp->banner_toko) }}" style="width:100%;height:100%;object-fit:cover;" alt="">
                @else
                    🌿
                @endif
            </div>
            <div class="seller-card-body">
                {{-- Avatar --}}
                <div class="seller-avatar">
                    @if($sp->foto_toko)
                        <img src="{{ asset('storage/'.$sp->foto_toko) }}" alt="{{ $sp->nama_toko }}">
                    @else
                        👨‍🌾
                    @endif
                </div>

                <div class="seller-name">{{ $sp->nama_toko }}</div>
                @if($sp->kategori_utama)
                <div class="seller-kategori">{{ $sp->kategori_utama }}</div>
                @endif
                <div style="margin-top:4px;">
                    @if($sp->is_verified)
                    <span class="verified-chip">✓ Terverifikasi</span>
                    @endif
                    <span class="open-chip {{ $sp->is_open ? 'open' : 'closed' }}">
                        {{ $sp->is_open ? '🟢 Buka' : '🔴 Tutup' }}
                    </span>
                </div>
                @if($sp->kota_kabupaten || $sp->provinsi)
                <div class="seller-loc">📍 {{ $sp->kota_kabupaten ? $sp->kota_kabupaten.', ' : '' }}{{ $sp->provinsi }}</div>
                @endif

                <div class="seller-stats">
                    <div class="seller-stat">
                        <strong>{{ $sp->total_transaksi ?? 0 }}</strong>
                        Transaksi
                    </div>
                    <div class="seller-stat">
                        <strong>{{ number_format($sp->rating ?? 5, 1) }} ★</strong>
                        Rating
                    </div>
                    <div class="seller-stat">
                        <strong>{{ $sp->total_produk ?? 0 }}</strong>
                        Produk
                    </div>
                </div>

                @if($sp->deskripsi_toko)
                <p style="font-size:12px;color:var(--text-muted);margin-top:10px;line-height:1.5;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                    {{ $sp->deskripsi_toko }}
                </p>
                @endif

                <a href="{{ route('store.show', $sp->slug_toko) }}" class="btn-visit" onclick="event.stopPropagation()">
                    Kunjungi Toko →
                </a>
            </div>
        </div>
        @endforeach
    </div>

    <div style="margin-top:28px;">
        {{ $sellers->appends(request()->query())->links() }}
    </div>
    @endif

</div>
@endsection
