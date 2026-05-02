@extends('layouts.app')

@section('title', 'Pesanan #' . $order->order_number . ' — SEARA')

@push('styles')
<style>
/* ── Layout ─────────────────────────────────────────────────────── */
.order-page { max-width: 920px; margin: 0 auto; padding: 28px 20px 80px; }

/* ── Breadcrumb ─────────────────────────────────────────────────── */
.breadcrumb { display: flex; align-items: center; gap: 6px; font-size: 13px; color: var(--text-muted); margin-bottom: 24px; flex-wrap: wrap; }
.breadcrumb a { color: var(--text-muted); transition: color .2s; }
.breadcrumb a:hover { color: var(--green-main); }
.breadcrumb .sep { opacity: .4; }
.breadcrumb .cur { color: var(--text-dark); font-weight: 700; }

/* ── Flash ───────────────────────────────────────────────────────── */
.flash-success { background: #dcfce7; border: 1px solid #bbf7d0; color: #166534; padding: 14px 18px; border-radius: 12px; font-size: 14px; font-weight: 700; margin-bottom: 20px; display: flex; align-items: center; gap: 8px; }
.flash-error   { background: #fee2e2; border: 1px solid #fecaca; color: #991b1b; padding: 14px 18px; border-radius: 12px; font-size: 14px; font-weight: 700; margin-bottom: 20px; display: flex; align-items: center; gap: 8px; }

/* ── Status banner ───────────────────────────────────────────────── */
.status-banner {
    display: flex; align-items: center; gap: 16px;
    background: white; border: 1px solid var(--border);
    border-radius: 16px; padding: 20px 24px; margin-bottom: 16px;
    border-left: 5px solid var(--status-color, var(--green-main));
    box-shadow: var(--shadow-sm);
}
.status-icon { font-size: 40px; flex-shrink: 0; }
.status-info { flex: 1; min-width: 0; }
.status-info .sinfo-no { font-size: 12px; color: var(--text-muted); font-weight: 700; letter-spacing: .5px; font-family: monospace; }
.status-info .sinfo-label { font-size: 20px; font-weight: 900; color: var(--text-dark); margin-top: 3px; }
.status-info .sinfo-sub { font-size: 13px; color: var(--text-mid); margin-top: 4px; line-height: 1.5; }
.status-actions { display: flex; gap: 8px; flex-wrap: wrap; flex-shrink: 0; }

/* ── Progress tracker ────────────────────────────────────────────── */
.progress-card { background: white; border: 1px solid var(--border); border-radius: 14px; padding: 20px 24px; margin-bottom: 16px; }
.progress-steps { display: flex; align-items: center; gap: 0; overflow-x: auto; padding-bottom: 4px; }
.progress-steps::-webkit-scrollbar { height: 3px; }
.progress-steps::-webkit-scrollbar-thumb { background: var(--border); border-radius: 10px; }

.step { display: flex; flex-direction: column; align-items: center; gap: 7px; min-width: 72px; }
.step-dot {
    width: 34px; height: 34px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 14px; font-weight: 900;
    border: 2.5px solid var(--border); background: white; color: var(--text-muted);
    flex-shrink: 0; transition: all .3s;
}
.step-dot.done   { background: #dcfce7; border-color: #16a34a; color: #16a34a; }
.step-dot.active { background: var(--green-main); border-color: var(--green-main); color: white; box-shadow: 0 0 0 4px rgba(58,125,68,.15); }
.step-label { font-size: 10px; font-weight: 700; color: var(--text-muted); text-align: center; line-height: 1.3; }
.step-label.active { color: var(--green-main); }
.step-label.done { color: #16a34a; }
.step-line { flex: 1; height: 2.5px; background: var(--border); min-width: 20px; border-radius: 2px; transition: background .3s; }
.step-line.done { background: #16a34a; }

/* ── Section card ────────────────────────────────────────────────── */
.section-card { background: white; border: 1px solid var(--border); border-radius: 14px; padding: 20px 24px; margin-bottom: 16px; }
.section-title { font-size: 15px; font-weight: 900; color: var(--text-dark); margin-bottom: 16px; display: flex; align-items: center; gap: 8px; }
.section-title::before { content: ''; display: block; width: 3px; height: 18px; background: var(--green-main); border-radius: 2px; flex-shrink: 0; }

/* ── Order items ─────────────────────────────────────────────────── */
.order-item { display: flex; gap: 14px; align-items: center; padding: 14px 0; border-bottom: 1px solid var(--border); }
.order-item:last-child { border-bottom: none; padding-bottom: 0; }
.oi-img {
    width: 58px; height: 58px; border-radius: 12px;
    background: var(--green-pale); display: flex; align-items: center;
    justify-content: center; font-size: 28px; flex-shrink: 0; border: 1px solid var(--border);
}
.oi-body { flex: 1; min-width: 0; }
.oi-name { font-size: 15px; font-weight: 800; color: var(--text-dark); }
.oi-seller { font-size: 12px; color: var(--text-muted); margin-top: 2px; font-weight: 600; }
.oi-qty { font-size: 13px; color: var(--text-mid); margin-top: 5px; font-weight: 700; }
.oi-price { text-align: right; flex-shrink: 0; }
.oi-price-val { font-size: 15px; font-weight: 900; color: var(--green-main); }
.oi-price-unit { font-size: 11px; color: var(--text-muted); margin-bottom: 4px; }
.offer-tag { display: inline-block; font-size: 10px; font-weight: 800; background: #fef3c7; color: #d97706; border: 1px solid #fde68a; padding: 2px 8px; border-radius: 5px; margin-top: 4px; }
.original-price-tag { display: inline-block; font-size: 11px; color: var(--text-muted); text-decoration: line-through; margin-top: 2px; }

/* ── Two column grid ─────────────────────────────────────────────── */
.two-col { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }

/* ── Info rows ───────────────────────────────────────────────────── */
.info-row { display: flex; gap: 10px; padding: 9px 0; border-bottom: 1px dashed var(--border); font-size: 13px; }
.info-row:last-child { border-bottom: none; padding-bottom: 0; }
.info-label { width: 130px; flex-shrink: 0; color: var(--text-muted); font-weight: 700; }
.info-val { flex: 1; color: var(--text-dark); font-weight: 600; word-break: break-word; }

/* ── Summary rows ────────────────────────────────────────────────── */
.sum-row { display: flex; justify-content: space-between; align-items: center; font-size: 14px; padding: 7px 0; color: var(--text-mid); }
.sum-row.total { font-size: 17px; font-weight: 900; color: var(--text-dark); border-top: 2px solid var(--border); padding-top: 12px; margin-top: 4px; }
.sum-row.discount { color: #16a34a; font-weight: 700; }
.sum-free { font-size: 12px; font-weight: 800; background: #dcfce7; color: #166534; padding: 2px 8px; border-radius: 5px; }

/* ── Payment proof upload ────────────────────────────────────────── */
.proof-upload-area {
    border: 2.5px dashed var(--border); border-radius: 14px;
    padding: 28px; text-align: center; cursor: pointer;
    transition: all .2s; background: var(--green-bg); display: block;
}
.proof-upload-area:hover { border-color: var(--green-main); background: var(--green-pale); }
.proof-upload-area input[type=file] { display: none; }
.proof-upload-icon { font-size: 42px; margin-bottom: 10px; }
.proof-upload-label { font-size: 14px; font-weight: 800; color: var(--text-mid); }
.proof-upload-sub { font-size: 12px; color: var(--text-muted); margin-top: 5px; }

/* ── Buttons ─────────────────────────────────────────────────────── */
.btn-primary {
    padding: 10px 20px; background: var(--green-main); color: white;
    font-size: 13px; font-weight: 800; border: none; border-radius: 10px;
    cursor: pointer; font-family: 'Nunito', sans-serif; transition: all .2s;
    text-decoration: none; display: inline-flex; align-items: center; gap: 6px;
}
.btn-primary:hover { background: var(--green-dark); transform: translateY(-1px); }
.btn-secondary {
    padding: 10px 20px; background: white; color: var(--text-mid);
    font-size: 13px; font-weight: 800; border: 1.5px solid var(--border); border-radius: 10px;
    cursor: pointer; font-family: 'Nunito', sans-serif; transition: all .2s;
    text-decoration: none; display: inline-flex; align-items: center; gap: 6px;
}
.btn-secondary:hover { border-color: var(--green-main); color: var(--green-main); background: var(--green-pale); }
.btn-danger {
    padding: 10px 20px; background: #fef2f2; color: #dc2626;
    font-size: 13px; font-weight: 800; border: 1.5px solid #fecaca; border-radius: 10px;
    cursor: pointer; font-family: 'Nunito', sans-serif; transition: all .2s;
    text-decoration: none; display: inline-flex; align-items: center; gap: 6px;
}
.btn-danger:hover { background: #fee2e2; }

/* ── Payment method info ─────────────────────────────────────────── */
.pay-info-box {
    background: #fffbeb; border: 1px solid #fde68a; border-radius: 12px;
    padding: 14px 16px; margin-bottom: 16px; font-size: 13px; color: #92400e;
}
.pay-info-box strong { display: block; font-size: 14px; font-weight: 900; margin-bottom: 4px; }
.pay-info-box .bank-detail { margin-top: 8px; font-size: 13px; line-height: 1.8; }
.pay-info-box .copy-btn {
    display: inline-flex; align-items: center; gap: 5px;
    background: #fef3c7; border: 1px solid #fde68a; color: #92400e;
    font-size: 11px; font-weight: 800; padding: 3px 10px; border-radius: 5px;
    cursor: pointer; border-style: solid; font-family: 'Nunito', sans-serif; margin-left: 8px;
    transition: background .15s;
}
.pay-info-box .copy-btn:hover { background: #fde68a; }

/* ── Cancelled banner ────────────────────────────────────────────── */
.cancelled-card { background: #fef2f2; border: 1px solid #fecaca; border-radius: 14px; padding: 18px 22px; margin-bottom: 16px; }
.cancelled-card .c-title { font-size: 14px; font-weight: 900; color: #dc2626; margin-bottom: 6px; }
.cancelled-card .c-reason { font-size: 13px; color: #7f1d1d; }

/* ── Modal ───────────────────────────────────────────────────────── */
.modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,.55); z-index: 1000; align-items: center; justify-content: center; padding: 16px; }
.modal-overlay.active { display: flex; }
.modal-box { background: white; border-radius: 18px; padding: 28px; max-width: 420px; width: 100%; box-shadow: 0 20px 60px rgba(0,0,0,.2); }
.modal-title { font-size: 18px; font-weight: 900; color: var(--text-dark); margin-bottom: 8px; display: flex; align-items: center; gap: 8px; }
.modal-sub { font-size: 13px; color: var(--text-muted); margin-bottom: 18px; line-height: 1.6; }
.modal-actions { display: flex; gap: 10px; margin-top: 20px; }
.modal-actions button, .modal-actions a { flex: 1; justify-content: center; }

@media (max-width: 640px) {
    .two-col { grid-template-columns: 1fr; }
    .status-banner { flex-wrap: wrap; }
    .status-actions { width: 100%; }
}
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

    {{-- Flash --}}
    @if(session('success'))
    <div class="flash-success">✅ {{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="flash-error">❌ {{ session('error') }}</div>
    @endif

    {{-- Status banner --}}
    @php
        $statusMeta = [
            'pending_payment' => ['⏳', '#f59e0b', 'Menunggu Pembayaran',  'Lakukan pembayaran agar pesanan segera diproses penjual.'],
            'paid'            => ['💳', '#3b82f6', 'Pembayaran Diterima',  'Pembayaran berhasil dikonfirmasi. Penjual sedang menyiapkan pesananmu.'],
            'processing'      => ['📦', '#8b5cf6', 'Sedang Diproses',       'Penjual sedang menyiapkan dan mengemas produkmu.'],
            'shipped'         => ['🚚', '#06b6d4', 'Dalam Pengiriman',      'Pesananmu sedang dalam perjalanan. Segera tiba di tanganmu!'],
            'delivered'       => ['✅', '#10b981', 'Pesanan Selesai',        'Pesanan berhasil diterima. Terima kasih sudah belanja di SEARA! 🌾'],
            'cancelled'       => ['❌', '#ef4444', 'Pesanan Dibatalkan',     'Pesanan ini telah dibatalkan. Stok produk sudah dikembalikan.'],
            'refunded'        => ['↩️','#6b7280', 'Dana Dikembalikan',      'Dana sudah dikembalikan ke metode pembayaran asal.'],
        ];
        [$sIcon, $sColor, $sLabel, $sSub] = $statusMeta[$order->status] ?? ['📋', '#6b7280', $order->status, ''];
    @endphp

    <div class="status-banner" style="--status-color: {{ $sColor }}">
        <div class="status-icon">{{ $sIcon }}</div>
        <div class="status-info">
            <div class="sinfo-no">#{{ $order->order_number }}</div>
            <div class="sinfo-label">{{ $sLabel }}</div>
            <div class="sinfo-sub">{{ $sSub }}</div>
        </div>
        <div class="status-actions">
            @if($order->isPendingPayment())
                @if($order->payment_method !== 'cod')
                    <button class="btn-primary" onclick="document.getElementById('proofSection').scrollIntoView({behavior:'smooth'})">
                        📤 Upload Bukti Bayar
                    </button>
                @endif
                <button class="btn-danger" onclick="document.getElementById('cancelModal').classList.add('active')">
                    ❌ Batalkan
                </button>
            @endif
            @if($order->isDelivered())
                <a href="{{ route('buyer.dashboard') }}" class="btn-secondary">🛒 Beli Lagi</a>
            @endif
        </div>
    </div>

    {{-- Progress tracker --}}
    @if(!$order->isCancelled())
    @php
        $stepOrder = ['pending_payment', 'paid', 'processing', 'shipped', 'delivered'];
        $curIdx    = array_search($order->status, $stepOrder);
        $steps     = [
            ['pending_payment', '⏳', "Menunggu\nBayar"],
            ['paid',            '💳', "Dibayar"],
            ['processing',      '📦', "Diproses"],
            ['shipped',         '🚚', "Dikirim"],
            ['delivered',       '✅', "Diterima"],
        ];
    @endphp
    <div class="progress-card">
        <div class="progress-steps">
            @foreach($steps as $i => [$key, $icon, $label])
                @if($i > 0)
                    <div class="step-line {{ $curIdx !== false && $curIdx >= $i ? 'done' : '' }}"></div>
                @endif
                @php
                    $isDone   = $curIdx !== false && $curIdx > $i;
                    $isActive = $curIdx !== false && $curIdx === $i;
                @endphp
                <div class="step">
                    <div class="step-dot {{ $isActive ? 'active' : ($isDone ? 'done' : '') }}">
                        {{ $isDone ? '✓' : $icon }}
                    </div>
                    <div class="step-label {{ $isActive ? 'active' : ($isDone ? 'done' : '') }}">{{ $label }}</div>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Dibatalkan --}}
    @if($order->isCancelled())
    <div class="cancelled-card">
        <div class="c-title">❌ Pesanan Dibatalkan</div>
        <div class="c-reason">
            @if($order->cancel_reason)
                Alasan: {{ $order->cancel_reason }}
            @else
                Tidak ada alasan yang dicantumkan.
            @endif
        </div>
    </div>
    @endif

    {{-- Instruksi pembayaran --}}
    @if($order->isPendingPayment() && $order->payment_method === 'transfer')
    <div class="section-card" id="proofSection">
        <div class="section-title">🏦 Instruksi Transfer</div>
        <div class="pay-info-box">
            <strong>Transfer ke rekening berikut:</strong>
            <div class="bank-detail">
                <div><b>Bank BCA</b> — 123-456-7890</div>
                <div>a/n <b>SEARA Marketplace</b></div>
                <div style="margin-top:6px;">
                    Jumlah: <b>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</b>
                    <button class="copy-btn" onclick="copyAmount()">📋 Salin</button>
                </div>
            </div>
        </div>
        <p style="font-size:12px; color:var(--text-muted); margin-bottom:16px;">
            Setelah transfer, upload foto bukti pembayaran di bawah agar pesanan segera diproses.
        </p>
        <form method="POST" action="{{ route('orders.payment-proof', $order) }}" enctype="multipart/form-data" id="proofForm">
            @csrf
            <label class="proof-upload-area" for="proof-file">
                <input type="file" id="proof-file" name="payment_proof" accept="image/*" onchange="previewProof(this)">
                <div id="proof-preview-area">
                    <div class="proof-upload-icon">📸</div>
                    <div class="proof-upload-label">Klik atau drag foto bukti transfer</div>
                    <div class="proof-upload-sub">JPG, PNG — maks. 5MB</div>
                </div>
            </label>
            <div style="display:flex; gap:10px; margin-top:14px;">
                <button type="submit" class="btn-primary" id="btnUpload" style="display:none; flex:1; justify-content:center;">
                    📤 Upload Bukti Pembayaran
                </button>
            </div>
        </form>
    </div>
    @endif

    @if($order->isPendingPayment() && $order->payment_method === 'e-wallet')
    <div class="section-card" id="proofSection">
        <div class="section-title">📱 Instruksi E-Wallet</div>
        <div class="pay-info-box">
            <strong>Transfer ke GoPay / OVO / DANA:</strong>
            <div class="bank-detail">
                <div>No. HP: <b>0812-3456-7890</b>
                    <button class="copy-btn" onclick="navigator.clipboard.writeText('081234567890').then(()=>showToast('Nomor disalin!'))">📋 Salin</button>
                </div>
                <div>a/n <b>SEARA Marketplace</b></div>
                <div style="margin-top:6px;">
                    Jumlah: <b>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</b>
                    <button class="copy-btn" onclick="copyAmount()">📋 Salin</button>
                </div>
            </div>
        </div>
        <form method="POST" action="{{ route('orders.payment-proof', $order) }}" enctype="multipart/form-data" id="proofForm">
            @csrf
            <label class="proof-upload-area" for="proof-file">
                <input type="file" id="proof-file" name="payment_proof" accept="image/*" onchange="previewProof(this)">
                <div id="proof-preview-area">
                    <div class="proof-upload-icon">📸</div>
                    <div class="proof-upload-label">Upload screenshot bukti pembayaran</div>
                    <div class="proof-upload-sub">JPG, PNG — maks. 5MB</div>
                </div>
            </label>
            <button type="submit" class="btn-primary" id="btnUpload" style="display:none; margin-top:14px;">
                📤 Upload Bukti Pembayaran
            </button>
        </form>
    </div>
    @endif

    @if($order->isPendingPayment() && $order->payment_method === 'cod')
    <div class="section-card">
        <div class="section-title">💵 Pembayaran COD</div>
        <div style="font-size:13px; color:var(--text-mid); line-height:1.7;">
            <p>🚚 Bayar tunai saat barang tiba di alamatmu.</p>
            <p>Siapkan uang pas sebesar <strong>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong>.</p>
        </div>
    </div>
    @endif

    {{-- Bukti bayar sudah diupload --}}
    @if($order->payment_proof && !$order->isPendingPayment())
    <div class="section-card">
        <div class="section-title">📎 Bukti Pembayaran</div>
        <img src="{{ asset('storage/' . $order->payment_proof) }}"
             alt="Bukti Bayar"
             style="max-width:280px; border-radius:12px; border:1px solid var(--border); cursor:pointer;"
             onclick="window.open(this.src,'_blank')">
        <div style="font-size:11px; color:var(--text-muted); margin-top:6px;">Klik gambar untuk memperbesar</div>
    </div>
    @endif

    {{-- Produk yang dipesan --}}
    <div class="section-card">
        <div class="section-title">📦 Produk yang Dipesan</div>
        @foreach($order->items as $item)
        <div class="order-item">
            <div class="oi-img">
                {{ $item->harvest->product->category->icon ?? '🌿' }}
            </div>
            <div class="oi-body">
                <div class="oi-name">{{ $item->product_name }}</div>
                <div class="oi-seller">🏪 {{ $item->seller_name }}</div>
                <div class="oi-qty">
                    {{ $item->quantity }} {{ $item->product_unit }}
                    × Rp {{ number_format($item->price_per_unit, 0, ',', '.') }}
                </div>
                @if($item->is_offer_price)
                    @php $originalPpu = optional($item->priceOffer)->original_price ?? null; @endphp
                    @if($originalPpu && $originalPpu > $item->price_per_unit)
                        <div class="original-price-tag">Rp {{ number_format($originalPpu, 0, ',', '.') }}</div>
                    @endif
                    <span class="offer-tag">🏷️ Harga Tawar</span>
                @endif
            </div>
            <div class="oi-price">
                <div class="oi-price-unit">Subtotal</div>
                <div class="oi-price-val">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Alamat + Pembayaran (2 kolom) --}}
    <div class="two-col">
        {{-- Alamat --}}
        <div class="section-card" style="margin-bottom:0;">
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
                <div class="info-val">
                    {{ $order->city }}{{ $order->province ? ', '.$order->province : '' }}
                    @if($order->postal_code) · {{ $order->postal_code }} @endif
                </div>
            </div>
            @endif
        </div>

        {{-- Rincian pembayaran --}}
        <div class="section-card" style="margin-bottom:0;">
            <div class="section-title">💳 Rincian Pembayaran</div>
            <div class="info-row">
                <div class="info-label">Metode</div>
                <div class="info-val">
                    {{ match($order->payment_method) {
                        'transfer' => '🏦 Transfer Bank',
                        'e-wallet' => '📱 E-Wallet',
                        'cod'      => '💵 Bayar di Tempat (COD)',
                        default    => $order->payment_method,
                    } }}
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">Tanggal Pesan</div>
                <div class="info-val">{{ $order->created_at->translatedFormat('d F Y, H:i') }}</div>
            </div>
            @if($order->paid_at)
            <div class="info-row">
                <div class="info-label">Dibayar</div>
                <div class="info-val">{{ $order->paid_at->translatedFormat('d F Y, H:i') }}</div>
            </div>
            @endif

            {{-- Summary --}}
            <div style="margin-top:14px; border-top: 1.5px dashed var(--border); padding-top:12px;">
                <div class="sum-row">
                    <span>Subtotal ({{ $order->items->sum('quantity') }} item)</span>
                    <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                </div>
                <div class="sum-row">
                    <span>Ongkos Kirim</span>
                    @if($order->shipping_cost > 0)
                        <span>Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                    @else
                        <span class="sum-free">✅ GRATIS</span>
                    @endif
                </div>
                @if($order->discount_amount > 0)
                <div class="sum-row discount">
                    <span>💰 Diskon Penawaran</span>
                    <span>−Rp {{ number_format($order->discount_amount, 0, ',', '.') }}</span>
                </div>
                @endif
                <div class="sum-row total">
                    <span>Total Bayar</span>
                    <span>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Catatan pembeli --}}
    @if($order->buyer_notes)
    <div class="section-card" style="margin-top:16px;">
        <div class="section-title">📝 Catatan Pesanan</div>
        <p style="font-size:14px; color:var(--text-mid); line-height:1.6;">{{ $order->buyer_notes }}</p>
    </div>
    @endif

    {{-- Tombol aksi bawah --}}
    <div style="display:flex; gap:10px; margin-top:20px; flex-wrap:wrap;">
        <a href="{{ route('orders.index') }}" class="btn-secondary">
            ← Kembali ke Pesanan
        </a>
        @if($order->isPendingPayment())
        <button class="btn-danger" onclick="document.getElementById('cancelModal').classList.add('active')">
            ❌ Batalkan Pesanan
        </button>
        @endif
        @if($order->isDelivered())
        <a href="{{ route('buyer.dashboard') }}" class="btn-primary">
            🛒 Beli Lagi
        </a>
        @endif
    </div>

</div>

{{-- ══ MODAL BATALKAN ══════════════════════════════════════════════════ --}}
<div class="modal-overlay" id="cancelModal" onclick="if(event.target===this)this.classList.remove('active')">
    <div class="modal-box">
        <div class="modal-title">❌ Batalkan Pesanan?</div>
        <div class="modal-sub">
            Apakah kamu yakin ingin membatalkan pesanan
            <strong>#{{ $order->order_number }}</strong>?
            Stok produk akan dikembalikan secara otomatis.
        </div>
        <form method="POST" action="{{ route('orders.cancel', $order) }}">
            @csrf
            <label style="font-size:12px; font-weight:700; color:var(--text-mid); display:block; margin-bottom:6px;">
                Alasan pembatalan (opsional)
            </label>
            <textarea name="cancel_reason" rows="3"
                style="width:100%; padding:10px 12px; border:1.5px solid var(--border); border-radius:10px; font-family:'Nunito',sans-serif; font-size:13px; resize:vertical; outline:none; transition:border-color .2s; box-sizing:border-box;"
                placeholder="Misal: barang tidak dibutuhkan lagi..."
                onfocus="this.style.borderColor='var(--green-main)'" onblur="this.style.borderColor='var(--border)'"></textarea>
            <div class="modal-actions">
                <button type="button" class="btn-secondary"
                    onclick="document.getElementById('cancelModal').classList.remove('active')">
                    Kembali
                </button>
                <button type="submit" class="btn-danger">Ya, Batalkan</button>
            </div>
        </form>
    </div>
</div>

{{-- Toast --}}
<div id="toast" style="position:fixed;bottom:28px;left:50%;transform:translateX(-50%) translateY(20px);background:var(--green-dark);color:white;padding:10px 22px;border-radius:50px;font-size:13px;font-weight:700;opacity:0;transition:all .35s;z-index:9999;pointer-events:none;white-space:nowrap;"></div>

@endsection

@push('scripts')
<script>
function previewProof(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('proof-preview-area').innerHTML =
                `<img src="${e.target.result}" style="max-height:130px; border-radius:10px; margin-bottom:10px;">
                 <div style="font-size:12px; font-weight:700; color:var(--green-main);">✅ Foto dipilih — klik Upload</div>`;
            const btn = document.getElementById('btnUpload');
            if (btn) btn.style.display = 'inline-flex';
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function copyAmount() {
    const amount = '{{ $order->total_amount }}';
    navigator.clipboard.writeText(Math.round(amount)).then(() => showToast('✅ Jumlah berhasil disalin!'));
}

function showToast(msg) {
    const t = document.getElementById('toast');
    t.textContent = msg;
    t.style.opacity = '1';
    t.style.transform = 'translateX(-50%) translateY(0)';
    clearTimeout(t._tid);
    t._tid = setTimeout(() => {
        t.style.opacity = '0';
        t.style.transform = 'translateX(-50%) translateY(20px)';
    }, 2800);
}
</script>
@endpush
