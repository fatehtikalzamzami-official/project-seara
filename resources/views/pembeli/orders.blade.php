@extends('layouts.app')

@section('title', 'Pesanan Saya — SEARA')

@push('styles')
<style>
/* ── Layout ─────────────────────────────────────────────────────── */
.orders-page { max-width: 900px; margin: 0 auto; padding: 28px 20px 80px; }

/* ── Breadcrumb ─────────────────────────────────────────────────── */
.breadcrumb { display: flex; align-items: center; gap: 6px; font-size: 13px; color: var(--text-muted); margin-bottom: 24px; flex-wrap: wrap; }
.breadcrumb a { color: var(--text-muted); transition: color .2s; }
.breadcrumb a:hover { color: var(--green-main); }
.breadcrumb .sep { opacity: .4; }
.breadcrumb .cur { color: var(--text-dark); font-weight: 700; }

/* ── Header ─────────────────────────────────────────────────────── */
.page-header { display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 20px; gap: 12px; flex-wrap: wrap; }
.page-title { font-size: 24px; font-weight: 900; color: var(--text-dark); display: flex; align-items: center; gap: 10px; }
.page-title::before { content: ''; display: block; width: 4px; height: 28px; background: var(--green-main); border-radius: 2px; }
.page-sub { font-size: 13px; color: var(--text-muted); margin-top: 4px; }

/* ── Filter tabs ─────────────────────────────────────────────────── */
.filter-wrap { background: white; border: 1px solid var(--border); border-radius: 14px; padding: 4px; display: flex; gap: 2px; margin-bottom: 20px; overflow-x: auto; scrollbar-width: none; }
.filter-wrap::-webkit-scrollbar { display: none; }
.filter-tab {
    padding: 8px 16px; border-radius: 10px; font-size: 12px; font-weight: 800;
    color: var(--text-muted); cursor: pointer; white-space: nowrap;
    background: transparent; border: none; font-family: 'Nunito', sans-serif;
    transition: all .2s; display: flex; align-items: center; gap: 6px;
}
.filter-tab:hover { background: var(--green-pale); color: var(--green-dark); }
.filter-tab.active { background: var(--green-main); color: white; }
.filter-tab .tab-count {
    background: rgba(255,255,255,.25); padding: 1px 7px; border-radius: 20px;
    font-size: 11px;
}
.filter-tab:not(.active) .tab-count { background: var(--border); color: var(--text-muted); }

/* ── Order card ──────────────────────────────────────────────────── */
.order-card {
    background: white; border: 1px solid var(--border); border-radius: 16px;
    margin-bottom: 14px; overflow: hidden; transition: box-shadow .2s, transform .15s;
}
.order-card:hover { box-shadow: 0 4px 20px rgba(0,0,0,.08); transform: translateY(-1px); }

.order-card-head {
    display: flex; align-items: center; gap: 12px;
    padding: 14px 18px; background: var(--green-bg);
    border-bottom: 1px solid var(--border);
}
.order-number-wrap { flex: 1; min-width: 0; }
.order-no { font-size: 13px; font-weight: 900; color: var(--text-dark); font-family: monospace; }
.order-date { font-size: 11px; color: var(--text-muted); margin-top: 2px; }
.status-pill {
    padding: 5px 12px; border-radius: 20px; font-size: 11px; font-weight: 800;
    white-space: nowrap; flex-shrink: 0;
}

.order-card-body { padding: 14px 18px; }

.order-items-row { display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 12px; }
.item-chip {
    display: flex; align-items: center; gap: 6px;
    background: var(--green-pale); border: 1px solid var(--border);
    border-radius: 8px; padding: 5px 10px; font-size: 12px; font-weight: 700;
    color: var(--text-mid);
}
.item-chip-more { background: var(--green-bg); color: var(--text-muted); border-style: dashed; }

.order-card-foot {
    display: flex; align-items: center; justify-content: space-between;
    padding-top: 12px; border-top: 1px dashed var(--border); flex-wrap: wrap; gap: 10px;
}
.order-total-wrap {}
.order-total-label { font-size: 11px; color: var(--text-muted); font-weight: 600; }
.order-total-val { font-size: 18px; font-weight: 900; color: var(--text-dark); }

.order-foot-actions { display: flex; gap: 8px; align-items: center; }
.btn-detail {
    padding: 8px 18px; background: var(--green-main); color: white;
    font-size: 12px; font-weight: 800; border-radius: 8px; text-decoration: none;
    transition: background .2s; display: inline-flex; align-items: center; gap: 5px;
}
.btn-detail:hover { background: var(--green-dark); }

/* ── Payment reminder badge ──────────────────────────────────────── */
.pay-reminder {
    display: flex; align-items: center; gap: 8px;
    background: #fffbeb; border: 1px solid #fde68a; border-radius: 10px;
    padding: 8px 12px; margin-bottom: 10px; font-size: 12px; font-weight: 700; color: #92400e;
}
.pay-reminder .pay-icon { font-size: 16px; }

/* ── Payment method badge ────────────────────────────────────────── */
.pay-method-chip {
    display: inline-flex; align-items: center; gap: 4px;
    background: var(--green-bg); border: 1px solid var(--border);
    border-radius: 6px; padding: 3px 8px; font-size: 11px; font-weight: 700; color: var(--text-mid);
}

/* ── Empty state ─────────────────────────────────────────────────── */
.empty-state { text-align: center; padding: 64px 20px; }
.es-icon { font-size: 60px; margin-bottom: 16px; }
.es-title { font-size: 18px; font-weight: 900; color: var(--text-dark); margin-bottom: 8px; }
.es-sub { font-size: 14px; color: var(--text-muted); margin-bottom: 24px; }
.btn-shop {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 12px 24px; background: var(--green-main); color: white;
    font-size: 14px; font-weight: 800; border-radius: 12px; text-decoration: none;
    transition: background .2s; box-shadow: 0 4px 14px rgba(58,125,68,.3);
}
.btn-shop:hover { background: var(--green-dark); }

/* ── Pagination ──────────────────────────────────────────────────── */
.pagination-wrap { margin-top: 24px; }

@media (max-width: 600px) {
    .order-card-head { flex-wrap: wrap; }
    .order-card-foot { flex-direction: column; align-items: flex-start; }
    .order-foot-actions { width: 100%; }
    .btn-detail { flex: 1; justify-content: center; }
}
</style>
@endpush

@section('content')
<div class="orders-page">

    {{-- Breadcrumb --}}
    <div class="breadcrumb">
        <a href="{{ route('buyer.dashboard') }}">🏠 Beranda</a>
        <span class="sep">›</span>
        <span class="cur">Pesanan Saya</span>
    </div>

    {{-- Header --}}
    <div class="page-header">
        <div>
            <div class="page-title">Pesanan Saya</div>
            <div class="page-sub">{{ $orders->total() }} pesanan total</div>
        </div>
        <a href="{{ route('buyer.dashboard') }}" class="btn-shop" style="padding:9px 18px; font-size:13px;">
            🛒 Belanja Lagi
        </a>
    </div>

    {{-- Filter tabs --}}
    @php
        $currentStatus = request('status', 'all');
        $countByStatus = $countByStatus ?? [];
        $tabCounts = [
            'all'             => $allCount ?? $orders->total(),
            'pending_payment' => $countByStatus['pending_payment'] ?? 0,
            'paid'            => $countByStatus['paid'] ?? 0,
            'processing'      => $countByStatus['processing'] ?? 0,
            'shipped'         => $countByStatus['shipped'] ?? 0,
            'delivered'       => $countByStatus['delivered'] ?? 0,
            'cancelled'       => $countByStatus['cancelled'] ?? 0,
        ];
        $tabs = [
            'all'             => ['📋', 'Semua'],
            'pending_payment' => ['⏳', 'Menunggu Bayar'],
            'paid'            => ['💳', 'Dibayar'],
            'processing'      => ['📦', 'Diproses'],
            'shipped'         => ['🚚', 'Dikirim'],
            'delivered'       => ['✅', 'Selesai'],
            'cancelled'       => ['❌', 'Dibatalkan'],
        ];
    @endphp
    <div class="filter-wrap">
        @foreach($tabs as $key => [$icon, $label])
        <a href="{{ route('orders.index', $key !== 'all' ? ['status' => $key] : []) }}"
           class="filter-tab {{ $currentStatus === $key ? 'active' : '' }}">
            {{ $icon }} {{ $label }}
            @if($tabCounts[$key] > 0)
                <span class="tab-count">{{ $tabCounts[$key] }}</span>
            @endif
        </a>
        @endforeach
    </div>

    @if($orders->isEmpty())
    <div class="empty-state">
        <div class="es-icon">📦</div>
        <div class="es-title">
            @if($currentStatus !== 'all')
                Tidak ada pesanan dengan status ini
            @else
                Belum ada pesanan
            @endif
        </div>
        <div class="es-sub">
            @if($currentStatus !== 'all')
                Coba filter status lain atau mulai belanja.
            @else
                Yuk belanja produk segar langsung dari petani lokal!
            @endif
        </div>
        <a href="{{ route('buyer.dashboard') }}" class="btn-shop">
            🌾 Mulai Belanja
        </a>
    </div>

    @else
    @foreach($orders as $order)
    @php
        $statusStyle = match($order->status) {
            'pending_payment' => 'background:#fef9c3; color:#92400e;',
            'paid'            => 'background:#dbeafe; color:#1e40af;',
            'processing'      => 'background:#ede9fe; color:#5b21b6;',
            'shipped'         => 'background:#cffafe; color:#0e7490;',
            'delivered'       => 'background:#dcfce7; color:#166534;',
            'cancelled'       => 'background:#fee2e2; color:#991b1b;',
            default           => 'background:var(--border); color:var(--text-mid);',
        };
        $payMethod = match($order->payment_method) {
            'transfer'  => ['🏦', 'Transfer Bank'],
            'e-wallet'  => ['📱', 'E-Wallet'],
            'cod'       => ['💵', 'COD'],
            default     => ['💳', $order->payment_method],
        };
    @endphp
    <div class="order-card">
        {{-- Header --}}
        <div class="order-card-head">
            <div class="order-number-wrap">
                <div class="order-no">{{ $order->order_number }}</div>
                <div class="order-date">{{ $order->created_at->translatedFormat('d F Y, H:i') }}</div>
            </div>
            <span class="pay-method-chip">{{ $payMethod[0] }} {{ $payMethod[1] }}</span>
            <div class="status-pill" style="{{ $statusStyle }}">{{ $order->statusLabel() }}</div>
        </div>

        {{-- Body --}}
        <div class="order-card-body">

            {{-- Pengingat bayar --}}
            @if($order->isPendingPayment() && $order->payment_method !== 'cod')
            <div class="pay-reminder">
                <span class="pay-icon">⚠️</span>
                Segera lakukan pembayaran agar pesanan diproses penjual.
            </div>
            @endif

            {{-- Item preview --}}
            <div class="order-items-row">
                @foreach($order->items->take(3) as $item)
                <div class="item-chip">
                    🌿 {{ $item->product_name }} ×{{ $item->quantity }} {{ $item->product_unit }}
                </div>
                @endforeach
                @if($order->items->count() > 3)
                <div class="item-chip item-chip-more">+{{ $order->items->count() - 3 }} produk lagi</div>
                @endif
            </div>

            {{-- Footer --}}
            <div class="order-card-foot">
                <div class="order-total-wrap">
                    <div class="order-total-label">Total Pembayaran</div>
                    <div class="order-total-val">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</div>
                    @if($order->discount_amount > 0)
                        <div style="font-size:11px; color:var(--green-main); font-weight:700; margin-top:2px;">
                            💰 Hemat Rp {{ number_format($order->discount_amount, 0, ',', '.') }}
                        </div>
                    @endif
                </div>
                <div class="order-foot-actions">
                    <a href="{{ route('orders.show', $order) }}" class="btn-detail">
                        Lihat Detail →
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <div class="pagination-wrap">
        {{ $orders->appends(request()->query())->links() }}
    </div>
    @endif

</div>
@endsection
