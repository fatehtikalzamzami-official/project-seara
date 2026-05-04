@extends('layouts.app')

@section('title', $query ? "Hasil Pencarian: {$query}" : 'Cari Produk')

@push('styles')
<style>
.page { max-width: 1280px; margin: 0 auto; padding: 24px 24px 60px; }

/* ─── Search Header ─── */
.search-header {
    background: linear-gradient(135deg, var(--green-dark) 0%, var(--green-main) 100%);
    padding: 28px 0 20px;
    margin-bottom: 0;
}
.search-header-inner {
    max-width: 1280px; margin: 0 auto; padding: 0 24px;
}
.search-header h1 {
    color: white; font-size: 22px; font-weight: 900; margin-bottom: 4px;
}
.search-header p {
    color: rgba(255,255,255,0.75); font-size: 13px;
}

/* ─── Produk Grid ─── */
.product-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 16px;
    margin-top: 24px;
}

/* ─── Produk Card ─── */
.prod-card {
    background: white;
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 1px 6px rgba(0,0,0,0.07);
    transition: transform 0.2s, box-shadow 0.2s;
    text-decoration: none;
    display: block;
    color: inherit;
}
.prod-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(44,95,46,0.15);
}
.prod-img {
    width: 100%; height: 160px; object-fit: cover;
    background: #f0faf0;
    display: flex; align-items: center; justify-content: center;
    font-size: 48px;
}
.prod-img img { width: 100%; height: 100%; object-fit: cover; }
.prod-body { padding: 12px 14px 14px; }
.prod-category {
    font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;
    color: var(--green-main); margin-bottom: 4px;
}
.prod-name { font-size: 15px; font-weight: 800; color: var(--text-dark); margin-bottom: 4px; line-height: 1.3; }
.prod-seller { font-size: 12px; color: var(--text-muted); margin-bottom: 8px; }
.prod-footer { display: flex; align-items: center; justify-content: space-between; }
.prod-price { font-size: 16px; font-weight: 900; color: var(--green-dark); }
.prod-unit { font-size: 11px; font-weight: 600; color: var(--text-muted); }
.prod-organic {
    background: #e8f5e9; color: #2e7d32;
    font-size: 10px; font-weight: 800; padding: 2px 8px; border-radius: 20px;
}
.prod-stock { font-size: 11px; color: var(--text-muted); margin-top: 6px; }

/* ─── Empty State ─── */
.empty-state {
    text-align: center; padding: 60px 20px;
}
.empty-state .empty-icon { font-size: 56px; margin-bottom: 16px; }
.empty-state h3 { font-size: 20px; font-weight: 900; color: var(--text-dark); margin-bottom: 8px; }
.empty-state p { color: var(--text-muted); font-size: 14px; max-width: 400px; margin: 0 auto 24px; }
.btn-primary {
    display: inline-flex; align-items: center; gap: 8px;
    background: var(--green-main); color: white;
    padding: 10px 24px; border-radius: 8px; font-weight: 800; font-size: 14px;
    text-decoration: none; transition: background 0.2s;
}
.btn-primary:hover { background: var(--green-dark); }

/* ─── Section title ─── */
.section-title {
    font-size: 18px; font-weight: 900; color: var(--text-dark);
    margin-bottom: 4px;
    display: flex; align-items: center; gap: 8px;
}
.result-count {
    font-size: 13px; color: var(--text-muted); font-weight: 600; margin-bottom: 20px;
}

/* ─── Pagination ─── */
.pagination-wrap { margin-top: 32px; display: flex; justify-content: center; }
.pagination-wrap .pagination { display: flex; gap: 6px; list-style: none; padding: 0; margin: 0; }
.pagination-wrap .page-item .page-link {
    display: flex; align-items: center; justify-content: center;
    width: 36px; height: 36px; border-radius: 8px;
    font-size: 13px; font-weight: 700;
    color: var(--text-dark); background: white;
    border: 1px solid var(--border); text-decoration: none;
    transition: all 0.15s;
}
.pagination-wrap .page-item.active .page-link {
    background: var(--green-main); color: white; border-color: var(--green-main);
}
.pagination-wrap .page-item .page-link:hover:not(.active) {
    background: var(--green-pale); color: var(--green-dark);
}

/* ─── Rekomendasi ─── */
.reko-section { margin-top: 40px; }
.reko-section .section-title { margin-bottom: 4px; }
.reko-desc { font-size: 13px; color: var(--text-muted); margin-bottom: 16px; }

@media (max-width: 640px) {
    .product-grid { grid-template-columns: repeat(2, 1fr); gap: 10px; }
    .page { padding: 16px 12px 40px; }
}
</style>
@endpush

@section('content')


<div class="page">

    @if($harvests->isNotEmpty())

        <div class="section-title">
            @if($query)
                Produk cocok dengan "{{ $query }}"
            @else
                Semua Produk
            @endif
        </div>
        <p class="result-count">Menampilkan {{ $harvests->firstItem() }}–{{ $harvests->lastItem() }} dari {{ $harvests->total() }} produk</p>

        <div class="product-grid">
            @foreach($harvests as $harvest)
                <a href="{{ route('buyer.product.show', $harvest->id) }}" class="prod-card">
                    <div class="prod-img">
                        @if($harvest->product->image ?? null)
                            <img src="{{ asset('storage/' . $harvest->product->image) }}" alt="{{ $harvest->product->name }}">
                        @else
                            🌿
                        @endif
                    </div>
                    <div class="prod-body">
                        <div class="prod-category">{{ $harvest->product->category->name ?? 'Produk' }}</div>
                        <div class="prod-name">{{ $harvest->product->name ?? '-' }}</div>
                        <div class="prod-seller">👨‍🌾 {{ $harvest->seller->user->nama_lengkap ?? 'Petani' }}</div>
                        <div class="prod-footer">
                            <div>
                                <div class="prod-price">Rp {{ number_format($harvest->price_per_unit, 0, ',', '.') }}</div>
                                <div class="prod-unit">per {{ $harvest->product->unit ?? 'kg' }}</div>
                            </div>
                            @if($harvest->is_organic)
                                <span class="prod-organic">🌱 Organik</span>
                            @endif
                        </div>
                        <div class="prod-stock">Stok: {{ $harvest->remaining_stock }} {{ $harvest->product->unit ?? 'kg' }}</div>
                    </div>
                </a>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($harvests->hasPages())
            <div class="pagination-wrap">
                {{ $harvests->links() }}
            </div>
        @endif

    @else

        {{-- Empty State --}}
        <div class="empty-state">
            <div class="empty-icon">🔍</div>
            <h3>Produk tidak ditemukan</h3>
            <p>
                Kami tidak menemukan produk untuk
                @if($query) "<strong>{{ $query }}</strong>" @else pencarian ini @endif.
                Coba kata kunci lain atau lihat semua produk tersedia.
            </p>
            <a href="{{ route('search.index') }}" class="btn-primary">Lihat Semua Produk</a>
        </div>

        {{-- Rekomendasi --}}
        @if($recommendations->isNotEmpty())
            <div class="reko-section">
                <div class="section-title">✨ Rekomendasi untuk Kamu</div>
                <p class="reko-desc">Produk segar yang tersedia hari ini</p>
                <div class="product-grid">
                    @foreach($recommendations as $harvest)
                        <a href="{{ route('buyer.product.show', $harvest->id) }}" class="prod-card">
                            <div class="prod-img">
                                @if($harvest->product->image ?? null)
                                    <img src="{{ asset('storage/' . $harvest->product->image) }}" alt="{{ $harvest->product->name }}">
                                @else
                                    🌿
                                @endif
                            </div>
                            <div class="prod-body">
                                <div class="prod-category">{{ $harvest->product->category->name ?? 'Produk' }}</div>
                                <div class="prod-name">{{ $harvest->product->name ?? '-' }}</div>
                                <div class="prod-seller">👨‍🌾 {{ $harvest->seller->user->nama_lengkap ?? 'Petani' }}</div>
                                <div class="prod-footer">
                                    <div>
                                        <div class="prod-price">Rp {{ number_format($harvest->price_per_unit, 0, ',', '.') }}</div>
                                        <div class="prod-unit">per {{ $harvest->product->unit ?? 'kg' }}</div>
                                    </div>
                                    @if($harvest->is_organic)
                                        <span class="prod-organic">🌱 Organik</span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

    @endif

</div>
@endsection
