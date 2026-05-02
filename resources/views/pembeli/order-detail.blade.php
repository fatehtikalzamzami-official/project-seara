@extends('layouts.app')

@section('title', 'Detail Pesanan #{{ $order->order_number }} — SEARA')

@push('styles')
<style>
.order-page { max-width: 900px; margin: 0 auto; padding: 28px 20px 80px; }

.breadcrumb { display: flex; align-items: center; gap: 6px; font-size: 13px; color: var(--text-muted); margin-bottom: 24px; flex-wrap: wrap; }
.breadcrumb a { color: var(--text-muted); transition: color .2s; }
.breadcrumb a:hover { color: var(--green-main); }
.breadcrumb .sep { opacity: .4; }
.breadcrumb .cur { color: var(--text-dark); font-weight: 700; }

/* Status banner */
.status-banner {
    display: flex; align-items: center; gap: 16px;
    background: white; border: 1px solid var(--border);
    border-radius: 16px; padding: 20px 24px; margin-bottom: 20px;
    border-left: 5px solid var(--status-color, var(--green-main));
}
.status-icon { font-size: 36px; }
.status-info .order-no { font-size: 12px; color: var(--text-muted); font-weight: 700; letter-spacing: .5px; }
.status-info .status-label { font-size: 20px; font-weight: 900; color: var(--text-dark); margin-top: 2px; }
.status-info .status-sub { font-size: 13px; color: var(--text-mid); margin-top: 4px; }
.status-actions { margin-left: auto; display: flex; gap: 10px; flex-wrap: wrap; }

/* Section card */
.section-card { background: white; border: 1px solid var(--border); border-radius: 14px; padding: 20px 24px; margin-bottom: 16px; }
.section-title { font-size: 15px; font-weight: 900; color: var(--text-dark); margin-bottom: 16px; display: flex; align-items: center; gap: 8px; }
.section-title::before { content: ''; display: block; width: 3px; height: 16px; background: var(--green-main); border-radius: 2px; }

/* Order items */
.order-item { display: flex; gap: 12px; align-items: center; padding: 12px 0; border-bottom: 1px solid var(--border); }
.order-item:last-child { border-bottom: none; }
.oi-img { width: 54px; height: 54px; border-radius: 10px; background: var(--green-pale); display: flex; align-items: center; justify-content: center; font-size: 26px; flex-shrink: 0; border: 1px solid var(--border); }
.oi-body { flex: 1; min-width: 0; }
.oi-name { font-size: 14px; font-weight: 800; color: var(--text-dark); }
.oi-seller { font-size: 11px; color: var(--text-muted); margin-top: 2px; }
.oi-qty { font-size: 12px; color: var(--text-mid); margin-top: 4px; font-weight: 600; }
.oi-price { font-size: 14px; font-weight: 900; color: var(--green-main); text-align: right; }
.offer-tag { display: inline-block; font-size: 10px; font-weight: 800; background: #fef3c7; color: #d97706; border: 1px solid #fde68a; padding: 2px 7px; border-radius: 5px; margin-top: 3px; }

/* Info rows */
.info-row { display: flex; gap: 8px; padding: 8px 0; border-bottom: 1px dashed var(--border); font-size: 14px; }
.info-row:last-child { border-bottom: none; }
.info-label { width: 160px; flex-shrink: 0; color: var(--text-muted); font-weight: 700; }
.info-val { flex: 1; color: var(--text-dark); font-weight: 600; }

/* Summary */
.sum-row { display: flex; justify-content: space-between; font-size: 14px; padding: 7px 0; color: var(--text-mid); }
.sum-row.total { font-size: 18px; font-weight: 900; color: var(--text-dark); border-top: 2px solid var(--border); padding-top: 12px; margin-top: 4px; }
.sum-row.discount { color: #16a34a; font-weight: 700; }

/* Payment proof upload */
.proof-upload-area {
    border: 2px dashed var(--border); border-radius: 12px; padding: 24px;
    text-align: center; cursor: pointer; transition: all .2s;
    background: var(--green-bg);
}
.proof-upload-area:hover { border-color: var(--green-main); background: var(--green-pale); }
.proof-upload-area input[type=file] { display: none; }
.proof-upload-icon { font-size: 36px; margin-bottom: 8px; }
.proof-upload-label { font-size: 14px; font-weight: 700; color: var(--text-mid); }
.proof-upload-sub { font-size: 12px; color: var(--text-muted); margin-top: 4px; }

/* Buttons */
.btn-primary {
    padding: 10px 20px; background: var(--green-main); color: white;
    font-size: 14px; font-weight: 800; border: none; border-radius: 10px;
    cursor: pointer; font-family: 'Nunito', sans-serif;
    transition: background .2s; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;
}
.btn-primary:hover { background: var(--green-dark); }
.btn-danger {
    padding: 10px 20px; background: #fef2f2; color: #dc2626;
    font-size: 14px; font-weight: 800; border: 1.5px solid #fecaca; border-radius: 10px;
    cursor: pointer; font-family: 'Nunito', sans-serif; transition: background .2s;
    text-decoration: none; display: inline-flex; align-items: center; gap: 6px;
}
.btn-danger:hover { background: #fee2e2; }

/* Success flash */
.flash-success { background: #dcfce7; border: 1px solid #bbf7d0; color: #166534; padding: 14px 18px; border-radius: 12px; font-size: 14px; font-weight: 700; margin-bottom: 20px; display: flex; align-items: center; gap: 8px; }

/* Steps */
.steps { display: flex; align-items: center; gap: 0; margin: 16px 0; overflow-x: auto; }
.step { display: flex; flex-direction: column; align-items: center; gap: 6px; min-width: 80px; }
.step-dot { width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 14px; font-weight: 900; border: 2.5px solid var(--border); background: white; color: var(--text-muted); flex-shrink: 0; }
.step-dot.active { background: var(--green-main); border-color: var(--green-main); color: white; }
.step-dot.done { background: #dcfce7; border-color: #16a34a; color: #16a34a; }
.step-label { font-size: 10px; font-weight: 700; color: var(--text-muted); text-align: center; white-space: nowrap; }
.step-label.active { color: var(--green-main); }
.step-line { flex: 1; height: 2px; background: var(--border); min-width: 24px; }
.step-line.done { background: #16a34a; }

/* Cancel modal */
.modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,.5); z-index: 1000; align-items: center; justify-content: center; }
.modal-overlay.active { display: flex; }
.modal-box { background: white; border-radius: 16px; padding: 28px; max-width: 400px; width: 90%; }
.modal-title { font-size: 18px; font-weight: 900; color: var(--text-dark); margin-bottom: 12px; }
</style>
@endpush

@section('content')
<div class="order-page">
    {{-- Breadcrumb --}}
    <div class="breadcrumb">
        <a href="{{ route('buyer.dashboard') }}">🏠 Beranda</a>
        <span class="sep">›</span>
        <a href="{{ route('orders.index') }}">📋 Pesanan Saya</a>
        <span class="sep">›</span>
        <span class="cur">{{ $order->order_number }}</span>
    </div>

    @if(session('success'))
    <div class="flash-success">✅ {{ session('success') }}</div>
    @endif

    {{-- Status banner --}}
    @php
        $statusIcon = match($order->status) {
            'pending_payment' => '⏳',
            'paid'            => '💳',
            'processing'      => '📦',
            'shipped'         => '🚚',
            'delivered'       => '✅',
            'cancelled'       => '❌',
            default           => '📋',
        };
        $statusSub = match($order->status) {
            'pending_payment' => 'Lakukan pembayaran sebelum pesanan diproses.',
            'paid'            => 'Pembayaran diterima. Pesanan sedang diproses penjual.',
            'processing'      => 'Penjual sedang menyiapkan pesanan kamu.',
            'shipped'         => 'Pesanan sedang dalam perjalanan ke alamatmu.',
            'delivered'       => 'Pesanan sudah diterima. Terima kasih!',
            'cancelled'       => 'Pesanan ini telah dibatalkan.',
            default           => '',
        };
    @endphp

    <div class="status-banner" style="--status-color: {{ $order->statusColor() }}">
        <div class="status-icon">{{ $statusIcon }}</div>
        <div class="status-info">
            <div class="order-no">#{{ $order->order_number }}</div>
            <div class="status-label">{{ $order->statusLabel() }}</div>
            <div class="status-sub">{{ $statusSub }}</div>
        </div>
        <div class="status-actions">
            @if($order->isPendingPayment())
                <button class="btn-danger" onclick="document.getElementById('cancelModal').classList.add('active')">
                    ❌ Batalkan
                </button>
            @endif
        </div>
    </div>

    {{-- Progress steps --}}
    @php
        $stepOrder = ['pending_payment','paid','processing','shipped','delivered'];
        $curIdx = array_search($order->status, $stepOrder);
    @endphp
    @if(!$order->isCancelled())
    <div class="section-card" style="padding: 16px 24px;">
        <div class="steps">
            @php $steps = [
                ['pending_payment', '⏳', 'Menunggu\nBayar'],
                ['paid', '💳', 'Dibayar'],
                ['processing', '📦', 'Diproses'],
                ['shipped', '🚚', 'Dikirim'],
                ['delivered', '✅', 'Diterima'],
            ]; @endphp
            @foreach($steps as $i => [$key, $icon, $label])
                @if($i > 0)
                    <div class="step-line {{ $curIdx >= $i ? 'done' : '' }}"></div>
                @endif
                <div class="step">
                    <div class="step-dot {{ $curIdx == $i ? 'active' : ($curIdx > $i ? 'done' : '') }}">
                        {{ $curIdx > $i ? '✓' : $icon }}
                    </div>
                    <div class="step-label {{ $curIdx == $i ? 'active' : '' }}">{{ $label }}</div>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Upload bukti bayar --}}
    @if($order->isPendingPayment() && $order->payment_method !== 'cod')
    <div class="section-card">
        <div class="section-title">📤 Upload Bukti Pembayaran</div>
        <p style="font-size:13px; color:var(--text-muted); margin-bottom:16px;">
            Setelah transfer, upload foto bukti pembayaran untuk mempercepat proses pesanan.
        </p>
        <form method="POST" action="{{ route('orders.payment-proof', $order) }}" enctype="multipart/form-data" id="proofForm">
            @csrf
            <label class="proof-upload-area" for="proof-file">
                <input type="file" id="proof-file" name="payment_proof" accept="image/*" onchange="previewProof(this)">
                <div id="proof-preview-area">
                    <div class="proof-upload-icon">📸</div>
                    <div class="proof-upload-label">Klik untuk pilih foto bukti transfer</div>
                    <div class="proof-upload-sub">JPG, PNG, maks. 5MB</div>
                </div>
            </label>
            <button type="submit" class="btn-primary" style="margin-top:12px; display:none;" id="btnUpload">
                📤 Upload Bukti Bayar
            </button>
        </form>
    </div>
    @endif

    @if($order->payment_proof && $order->isPaid())
    <div class="section-card">
        <div class="section-title">✅ Bukti Pembayaran</div>
        <img src="{{ asset('storage/' . $order->payment_proof) }}"
            alt="Bukti Bayar" style="max-width:300px; border-radius:10px; border:1px solid var(--border);">
    </div>
    @endif

    {{-- Produk --}}
    <div class="section-card">
        <div class="section-title">📦 Produk yang Dipesan</div>
        @foreach($order->items as $item)
        <div class="order-item">
            <div class="oi-img">{{ $item->harvest->product->category->icon ?? '🌿' }}</div>
            <div class="oi-body">
                <div class="oi-name">{{ $item->product_name }}</div>
                <div class="oi-seller">🏪 {{ $item->seller_name }}</div>
                <div class="oi-qty">{{ $item->quantity }} {{ $item->product_unit }} × Rp {{ number_format($item->price_per_unit, 0, ',', '.') }}</div>
                @if($item->is_offer_price)
                    <span class="offer-tag">🏷️ Harga Tawar</span>
                @endif
            </div>
            <div class="oi-price">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</div>
        </div>
        @endforeach
    </div>

    {{-- Alamat & Pembayaran --}}
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
        <div class="section-card">
            <div class="section-title">📍 Alamat Pengiriman</div>
            <div class="info-row">
                <div class="info-label">Penerima</div>
                <div class="info-val">{{ $order->recipient_name }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">No. HP</div>
                <div class="info-val">{{ $order->recipient_phone }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Alamat</div>
                <div class="info-val">{{ $order->shipping_address }}</div>
            </div>
            @if($order->city)
            <div class="info-row">
                <div class="info-label">Kota</div>
                <div class="info-val">{{ $order->city }}{{ $order->province ? ', ' . $order->province : '' }} {{ $order->postal_code }}</div>
            </div>
            @endif
        </div>

        <div class="section-card">
            <div class="section-title">💳 Pembayaran</div>
            <div class="info-row">
                <div class="info-label">Metode</div>
                <div class="info-val">{{ match($order->payment_method) { 'transfer' => '🏦 Transfer Bank', 'e-wallet' => '📱 E-Wallet', 'cod' => '💵 COD', default => $order->payment_method } }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Tanggal Pesan</div>
                <div class="info-val">{{ $order->created_at->format('d M Y, H:i') }}</div>
            </div>
            @if($order->paid_at)
            <div class="info-row">
                <div class="info-label">Dibayar</div>
                <div class="info-val">{{ $order->paid_at->format('d M Y, H:i') }}</div>
            </div>
            @endif

            <div style="margin-top:12px; border-top:1px dashed var(--border); padding-top:12px;">
                <div class="sum-row"><span>Subtotal</span><span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span></div>
                <div class="sum-row"><span>Ongkir</span><span>{{ $order->shipping_cost > 0 ? 'Rp ' . number_format($order->shipping_cost, 0, ',', '.') : 'GRATIS' }}</span></div>
                @if($order->discount_amount > 0)
                <div class="sum-row discount"><span>💰 Diskon Tawar</span><span>-Rp {{ number_format($order->discount_amount, 0, ',', '.') }}</span></div>
                @endif
                <div class="sum-row total"><span>Total</span><span>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span></div>
            </div>
        </div>
    </div>

    @if($order->buyer_notes)
    <div class="section-card">
        <div class="section-title">📝 Catatan Pembeli</div>
        <p style="font-size:14px; color:var(--text-mid);">{{ $order->buyer_notes }}</p>
    </div>
    @endif

    @if($order->isCancelled() && $order->cancel_reason)
    <div class="section-card" style="border-left:4px solid #ef4444;">
        <div class="section-title" style="color:#dc2626;">❌ Alasan Pembatalan</div>
        <p style="font-size:14px; color:var(--text-mid);">{{ $order->cancel_reason }}</p>
    </div>
    @endif
</div>

{{-- Cancel Modal --}}
<div class="modal-overlay" id="cancelModal">
    <div class="modal-box">
        <div class="modal-title">❌ Batalkan Pesanan?</div>
        <p style="font-size:14px; color:var(--text-mid); margin-bottom:16px;">
            Apakah kamu yakin ingin membatalkan pesanan <strong>{{ $order->order_number }}</strong>?
            Stok produk akan dikembalikan.
        </p>
        <form method="POST" action="{{ route('orders.cancel', $order) }}">
            @csrf
            <div class="form-group" style="margin-bottom:14px;">
                <label style="font-size:13px; font-weight:700; color:var(--text-mid); display:block; margin-bottom:6px;">Alasan (opsional)</label>
                <textarea name="cancel_reason" style="width:100%; padding:10px; border:1.5px solid var(--border); border-radius:8px; font-family:'Nunito',sans-serif; font-size:13px; resize:vertical; min-height:70px;" placeholder="Kenapa kamu membatalkan?"></textarea>
            </div>
            <div style="display:flex; gap:10px;">
                <button type="button" class="btn-primary" onclick="document.getElementById('cancelModal').classList.remove('active')" style="flex:1; background:var(--border); color:var(--text-mid);">
                    Kembali
                </button>
                <button type="submit" class="btn-danger" style="flex:1;">
                    Ya, Batalkan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function previewProof(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('proof-preview-area').innerHTML =
                `<img src="${e.target.result}" style="max-height:120px; border-radius:8px; margin-bottom:8px;"><div style="font-size:12px; font-weight:700; color:var(--green-main);">✅ Foto dipilih</div>`;
            document.getElementById('btnUpload').style.display = 'inline-flex';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
