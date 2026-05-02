@extends('layouts.app')

@section('title', 'Pesanan Saya — SEARA')

@push('styles')
<style>
.orders-page { max-width: 860px; margin: 0 auto; padding: 28px 20px 80px; }

.breadcrumb { display: flex; align-items: center; gap: 6px; font-size: 13px; color: var(--text-muted); margin-bottom: 24px; }
.breadcrumb a { color: var(--text-muted); }
.breadcrumb a:hover { color: var(--green-main); }
.breadcrumb .sep { opacity: .4; }
.breadcrumb .cur { color: var(--text-dark); font-weight: 700; }

.page-header { margin-bottom: 24px; }
.page-title { font-size: 24px; font-weight: 900; color: var(--text-dark); display: flex; align-items: center; gap: 10px; }
.page-sub { font-size: 14px; color: var(--text-muted); margin-top: 4px; }

.order-card {
    background: white; border: 1px solid var(--border); border-radius: 14px;
    margin-bottom: 14px; overflow: hidden; transition: box-shadow .2s;
}
.order-card:hover { box-shadow: var(--shadow-md); }

.order-card-header {
    display: flex; align-items: center; gap: 12px;
    padding: 14px 18px; border-bottom: 1px solid var(--border);
    background: var(--green-bg);
}
.order-no { font-size: 13px; font-weight: 900; color: var(--text-dark); }
.order-date { font-size: 12px; color: var(--text-muted); margin-top: 2px; }
.status-pill {
    margin-left: auto; padding: 5px 12px; border-radius: 20px;
    font-size: 12px; font-weight: 800; white-space: nowrap;
}

.order-card-body { padding: 14px 18px; }
.order-items-preview { display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 12px; }
.item-chip {
    display: flex; align-items: center; gap: 6px;
    background: var(--green-pale); border: 1px solid var(--border);
    border-radius: 8px; padding: 5px 10px; font-size: 12px; font-weight: 700; color: var(--text-mid);
}

.order-card-footer {
    display: flex; align-items: center; justify-content: space-between;
    padding-top: 12px; border-top: 1px dashed var(--border);
}
.order-total { font-size: 16px; font-weight: 900; color: var(--text-dark); }
.order-total span { font-size: 12px; color: var(--text-muted); font-weight: 600; }

.btn-detail {
    padding: 8px 18px; background: var(--green-main); color: white;
    font-size: 13px; font-weight: 800; border-radius: 8px; text-decoration: none;
    transition: background .2s; display: inline-flex; align-items: center; gap: 5px;
}
.btn-detail:hover { background: var(--green-dark); }

.empty-state { text-align: center; padding: 60px 20px; }
.empty-state .es-icon { font-size: 56px; margin-bottom: 16px; }
.empty-state .es-title { font-size: 18px; font-weight: 900; color: var(--text-dark); margin-bottom: 8px; }
.empty-state .es-sub { font-size: 14px; color: var(--text-muted); }
</style>
@endpush

@section('content')
<div class="orders-page">
    <div class="breadcrumb">
        <a href="{{ route('buyer.dashboard') }}">🏠 Beranda</a>
        <span class="sep">›</span>
        <span class="cur">Pesanan Saya</span>
    </div>

    <div class="page-header">
        <div class="page-title">📋 Pesanan Saya</div>
        <div class="page-sub">{{ $orders->total() }} pesanan ditemukan</div>
    </div>

    @if($orders->isEmpty())
    <div class="empty-state">
        <div class="es-icon">📦</div>
        <div class="es-title">Belum ada pesanan</div>
        <div class="es-sub">Yuk mulai belanja produk segar dari petani lokal!</div>
        <a href="{{ route('buyer.dashboard') }}" style="display:inline-block; margin-top:20px; padding:12px 24px; background:var(--green-main); color:white; border-radius:10px; font-weight:800; font-size:14px;">
            🛒 Mulai Belanja
        </a>
    </div>
    @else
        @foreach($orders as $order)
        @php
            $bgColor = match($order->status) {
                'pending_payment' => 'background:#fef9c3; color:#92400e;',
                'paid'            => 'background:#dbeafe; color:#1e40af;',
                'processing'      => 'background:#ede9fe; color:#5b21b6;',
                'shipped'         => 'background:#cffafe; color:#0e7490;',
                'delivered'       => 'background:#dcfce7; color:#166534;',
                'cancelled'       => 'background:#fee2e2; color:#991b1b;',
                default           => 'background:var(--border); color:var(--text-mid);',
            };
        @endphp
        <div class="order-card">
            <div class="order-card-header">
                <div>
                    <div class="order-no">{{ $order->order_number }}</div>
                    <div class="order-date">{{ $order->created_at->format('d M Y, H:i') }}</div>
                </div>
                <div class="status-pill" style="{{ $bgColor }}">{{ $order->statusLabel() }}</div>
            </div>
            <div class="order-card-body">
                <div class="order-items-preview">
                    @foreach($order->items->take(3) as $item)
                    <div class="item-chip">
                        🌿 {{ $item->product_name }} ×{{ $item->quantity }}
                    </div>
                    @endforeach
                    @if($order->items->count() > 3)
                    <div class="item-chip" style="background:var(--border);">+{{ $order->items->count() - 3 }} lainnya</div>
                    @endif
                </div>
                <div class="order-card-footer">
                    <div class="order-total">
                        <span>Total </span>Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                    </div>
                    <a href="{{ route('orders.show', $order) }}" class="btn-detail">
                        Lihat Detail →
                    </a>
                </div>
            </div>
        </div>
        @endforeach

        <div style="margin-top:20px;">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection
