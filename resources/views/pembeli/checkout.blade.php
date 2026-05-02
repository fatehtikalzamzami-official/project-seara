@extends('layouts.app')

@section('title', 'Checkout — SEARA')

@push('styles')
<style>
.checkout-page { max-width: 1100px; margin: 0 auto; padding: 28px 20px 80px; }

/* Breadcrumb */
.breadcrumb { display: flex; align-items: center; gap: 6px; font-size: 13px; color: var(--text-muted); margin-bottom: 24px; flex-wrap: wrap; }
.breadcrumb a { color: var(--text-muted); transition: color .2s; }
.breadcrumb a:hover { color: var(--green-main); }
.breadcrumb .sep { opacity: .4; }
.breadcrumb .cur { color: var(--text-dark); font-weight: 700; }

/* Grid */
.checkout-grid { display: grid; grid-template-columns: 1fr 380px; gap: 24px; align-items: start; }
@media(max-width: 900px) { .checkout-grid { grid-template-columns: 1fr; } }

/* Section card */
.section-card { background: white; border: 1px solid var(--border); border-radius: 16px; padding: 24px; margin-bottom: 16px; }
.section-title { font-size: 16px; font-weight: 900; color: var(--text-dark); margin-bottom: 18px; display: flex; align-items: center; gap: 8px; }
.section-title::before { content: ''; display: block; width: 3px; height: 18px; background: var(--green-main); border-radius: 2px; }

/* Form */
.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
@media(max-width: 600px) { .form-row { grid-template-columns: 1fr; } }
.form-group { display: flex; flex-direction: column; gap: 6px; margin-bottom: 14px; }
.form-group label { font-size: 13px; font-weight: 700; color: var(--text-mid); }
.form-control {
    width: 100%; padding: 10px 14px;
    border: 1.5px solid var(--border); border-radius: 10px;
    font-size: 14px; font-family: 'Nunito', sans-serif;
    color: var(--text-dark); background: white;
    transition: border-color .2s, box-shadow .2s;
    outline: none;
}
.form-control:focus { border-color: var(--green-main); box-shadow: 0 0 0 3px rgba(58,125,68,.12); }
textarea.form-control { resize: vertical; min-height: 80px; }

/* Order item list */
.order-item { display: flex; gap: 12px; align-items: center; padding: 12px 0; border-bottom: 1px solid var(--border); }
.order-item:last-child { border-bottom: none; }
.order-item-img { width: 56px; height: 56px; border-radius: 10px; background: var(--green-pale); display: flex; align-items: center; justify-content: center; font-size: 28px; flex-shrink: 0; border: 1px solid var(--border); }
.order-item-body { flex: 1; min-width: 0; }
.order-item-name { font-size: 14px; font-weight: 800; color: var(--text-dark); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.order-item-seller { font-size: 11px; color: var(--text-muted); margin-top: 2px; }
.order-item-qty { font-size: 12px; color: var(--text-mid); margin-top: 4px; font-weight: 600; }
.order-item-price { font-size: 14px; font-weight: 900; color: var(--green-main); white-space: nowrap; }
.offer-badge { display: inline-block; font-size: 10px; font-weight: 800; background: #fef3c7; color: #d97706; border: 1px solid #fde68a; padding: 2px 7px; border-radius: 6px; letter-spacing: .5px; margin-top: 3px; }

/* Summary card */
.summary-card { position: sticky; top: 24px; }
.summary-row { display: flex; justify-content: space-between; align-items: center; font-size: 14px; padding: 8px 0; }
.summary-row.subtotal { color: var(--text-mid); }
.summary-row.shipping { color: var(--text-mid); }
.summary-row.discount { color: #16a34a; font-weight: 700; }
.summary-row.total { font-size: 18px; font-weight: 900; color: var(--text-dark); border-top: 2px solid var(--border); padding-top: 14px; margin-top: 4px; }
.free-shipping { font-size: 11px; color: #16a34a; font-weight: 700; background: #dcfce7; padding: 3px 8px; border-radius: 6px; }

/* Payment options */
.payment-options { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 10px; }
.payment-opt { display: flex; flex-direction: column; align-items: center; gap: 6px; padding: 14px 10px; border: 2px solid var(--border); border-radius: 12px; cursor: pointer; transition: all .2s; text-align: center; }
.payment-opt:hover { border-color: var(--green-mid); background: var(--green-pale); }
.payment-opt input[type=radio] { display: none; }
.payment-opt.selected { border-color: var(--green-main); background: var(--green-pale); }
.payment-opt .pay-icon { font-size: 26px; }
.payment-opt .pay-label { font-size: 12px; font-weight: 800; color: var(--text-mid); }
.payment-opt.selected .pay-label { color: var(--green-dark); }

/* Submit button */
.btn-checkout {
    width: 100%; padding: 15px;
    background: linear-gradient(135deg, var(--green-main), var(--green-dark));
    color: white; font-size: 16px; font-weight: 900;
    border: none; border-radius: 12px; cursor: pointer;
    font-family: 'Nunito', sans-serif;
    transition: transform .15s, box-shadow .15s;
    box-shadow: 0 4px 14px rgba(58,125,68,.35);
    display: flex; align-items: center; justify-content: center; gap: 8px;
    margin-top: 16px;
}
.btn-checkout:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(58,125,68,.4); }
.btn-checkout:active { transform: translateY(0); }

/* Offer highlight */
.offer-highlight {
    background: linear-gradient(135deg, #fefce8, #fef9c3);
    border: 1.5px solid #fde68a;
    border-radius: 12px; padding: 14px 16px;
    display: flex; align-items: center; gap: 12px;
    margin-bottom: 16px;
}
.offer-highlight .oh-icon { font-size: 28px; flex-shrink: 0; }
.offer-highlight .oh-title { font-size: 13px; font-weight: 900; color: #92400e; }
.offer-highlight .oh-sub { font-size: 12px; color: #b45309; margin-top: 2px; }
.oh-prices { margin-left: auto; text-align: right; flex-shrink: 0; }
.oh-original { font-size: 11px; color: var(--text-muted); text-decoration: line-through; }
.oh-final { font-size: 16px; font-weight: 900; color: #16a34a; }
.oh-saving { font-size: 11px; font-weight: 700; color: #16a34a; background: #dcfce7; padding: 2px 6px; border-radius: 5px; }

.page-title { font-size: 26px; font-weight: 900; color: var(--text-dark); margin-bottom: 6px; display: flex; align-items: center; gap: 10px; }
.page-subtitle { font-size: 14px; color: var(--text-muted); margin-bottom: 28px; }
</style>
@endpush

@section('content')
<div class="checkout-page">
    {{-- Breadcrumb --}}
    <div class="breadcrumb">
        <a href="{{ route('buyer.dashboard') }}">🏠 Beranda</a>
        <span class="sep">›</span>
        <a href="{{ route('cart.index') }}">🛒 Keranjang</a>
        <span class="sep">›</span>
        <span class="cur">Checkout</span>
    </div>

    <div class="page-title">🛍️ Checkout</div>
    <div class="page-subtitle">Periksa pesanan dan isi data pengiriman kamu</div>

    {{-- Kalau dari offer, tampilkan highlight --}}
    @if($source === 'offer' && $offer)
    @php
        $savingAmount = ($offer->original_price - $finalPrice) * $offer->quantity;
    @endphp
    <div class="offer-highlight">
        <div class="oh-icon">🤝</div>
        <div>
            <div class="oh-title">Pesanan dari Penawaran Harga</div>
            <div class="oh-sub">{{ $harvest->product->name }} · {{ $offer->quantity }} {{ $harvest->product->unit }}</div>
        </div>
        <div class="oh-prices">
            <div class="oh-original">Rp {{ number_format($offer->original_price, 0, ',', '.') }}</div>
            <div class="oh-final">Rp {{ number_format($finalPrice, 0, ',', '.') }}/{{ $harvest->product->unit }}</div>
            <div class="oh-saving">Hemat Rp {{ number_format($savingAmount, 0, ',', '.') }}</div>
        </div>
    </div>
    @endif

    <form method="POST" action="{{ route('orders.store') }}" id="checkoutForm">
        @csrf
        <input type="hidden" name="source" value="{{ $source }}">
        @if($source === 'offer')
            <input type="hidden" name="price_offer_id" value="{{ $offer->id }}">
        @else
            @foreach($cartItemIds as $id)
                <input type="hidden" name="cart_item_ids[]" value="{{ $id }}">
            @endforeach
        @endif

        <div class="checkout-grid">
            {{-- Kolom kiri --}}
            <div>
                {{-- Ringkasan produk --}}
                <div class="section-card">
                    <div class="section-title">📦 Produk Dipesan</div>

                    @if($source === 'cart')
                        @foreach($items as $item)
                        @php $harvest = $item->harvest; $product = $harvest->product; @endphp
                        <div class="order-item">
                            <div class="order-item-img">
                                {{ $product->category->icon ?? '🌿' }}
                            </div>
                            <div class="order-item-body">
                                <div class="order-item-name">{{ $product->name }}</div>
                                <div class="order-item-seller">🏪 {{ $harvest->seller->farm_name ?? 'Petani' }}</div>
                                <div class="order-item-qty">{{ $item->quantity }} {{ $product->unit }} × Rp {{ number_format($harvest->price_per_unit, 0, ',', '.') }}</div>
                            </div>
                            <div class="order-item-price">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</div>
                        </div>
                        @endforeach

                    @else
                        {{-- Dari offer --}}
                        <div class="order-item">
                            <div class="order-item-img">
                                {{ $harvest->product->category->icon ?? '🌿' }}
                            </div>
                            <div class="order-item-body">
                                <div class="order-item-name">{{ $harvest->product->name }}</div>
                                <div class="order-item-seller">🏪 {{ $harvest->seller->farm_name ?? 'Petani' }}</div>
                                <div class="order-item-qty">{{ $offer->quantity }} {{ $harvest->product->unit }} × Rp {{ number_format($finalPrice, 0, ',', '.') }}</div>
                                <div><span class="offer-badge">🏷️ Harga Tawar</span></div>
                            </div>
                            <div class="order-item-price">Rp {{ number_format($subtotal, 0, ',', '.') }}</div>
                        </div>
                    @endif
                </div>

                {{-- Alamat Pengiriman --}}
                <div class="section-card">
                    <div class="section-title">📍 Alamat Pengiriman</div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Nama Penerima *</label>
                            <input type="text" name="recipient_name" class="form-control"
                                value="{{ old('recipient_name', Auth::user()->name) }}"
                                placeholder="Nama lengkap penerima" required>
                        </div>
                        <div class="form-group">
                            <label>Nomor HP *</label>
                            <input type="text" name="recipient_phone" class="form-control"
                                value="{{ old('recipient_phone') }}"
                                placeholder="08xxxxxxxxxx" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Alamat Lengkap *</label>
                        <textarea name="shipping_address" class="form-control"
                            placeholder="Jl., RT/RW, Kel., Kec." required>{{ old('shipping_address') }}</textarea>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Provinsi</label>
                            <input type="text" name="province" class="form-control"
                                value="{{ old('province') }}" placeholder="Sumatera Selatan">
                        </div>
                        <div class="form-group">
                            <label>Kota / Kabupaten</label>
                            <input type="text" name="city" class="form-control"
                                value="{{ old('city') }}" placeholder="Palembang">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Kode Pos</label>
                            <input type="text" name="postal_code" class="form-control"
                                value="{{ old('postal_code') }}" placeholder="30111" maxlength="10">
                        </div>
                    </div>
                </div>

                {{-- Catatan --}}
                <div class="section-card">
                    <div class="section-title">📝 Catatan (opsional)</div>
                    <div class="form-group" style="margin-bottom:0">
                        <textarea name="buyer_notes" class="form-control"
                            placeholder="Catatan untuk penjual, misal: tolong dikemas dengan baik...">{{ old('buyer_notes') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Kolom kanan: ringkasan & pembayaran --}}
            <div class="summary-card">
                {{-- Metode Pembayaran --}}
                <div class="section-card">
                    <div class="section-title">💳 Metode Pembayaran</div>
                    <div class="payment-options">
                        <label class="payment-opt" id="opt-transfer">
                            <input type="radio" name="payment_method" value="transfer" checked>
                            <div class="pay-icon">🏦</div>
                            <div class="pay-label">Transfer Bank</div>
                        </label>
                        <label class="payment-opt" id="opt-ewallet">
                            <input type="radio" name="payment_method" value="e-wallet">
                            <div class="pay-icon">📱</div>
                            <div class="pay-label">E-Wallet</div>
                        </label>
                        <label class="payment-opt" id="opt-cod">
                            <input type="radio" name="payment_method" value="cod">
                            <div class="pay-icon">💵</div>
                            <div class="pay-label">COD</div>
                        </label>
                    </div>

                    {{-- Info transfer --}}
                    <div id="transfer-info" style="margin-top:14px; padding:12px; background:var(--green-pale); border-radius:10px; border:1px solid var(--border);">
                        <div style="font-size:12px; font-weight:800; color:var(--green-dark); margin-bottom:6px;">Rekening Transfer SEARA:</div>
                        <div style="font-size:13px; color:var(--text-mid);">🏦 BCA — <strong>1234-5678-90</strong> a.n. SEARA AGRI</div>
                        <div style="font-size:13px; color:var(--text-mid); margin-top:4px;">🏦 Mandiri — <strong>0987-6543-21</strong> a.n. SEARA AGRI</div>
                        <div style="font-size:11px; color:var(--text-muted); margin-top:8px;">Setelah checkout, upload bukti transfer di halaman detail pesanan.</div>
                    </div>
                    <div id="ewallet-info" style="display:none; margin-top:14px; padding:12px; background:var(--green-pale); border-radius:10px; border:1px solid var(--border);">
                        <div style="font-size:12px; font-weight:800; color:var(--green-dark); margin-bottom:6px;">E-Wallet SEARA:</div>
                        <div style="font-size:13px; color:var(--text-mid);">📱 GoPay / OVO / DANA — <strong>0812-3456-7890</strong> a.n. SEARA AGRI</div>
                    </div>
                    <div id="cod-info" style="display:none; margin-top:14px; padding:12px; background:#fef9c3; border-radius:10px; border:1px solid #fde68a;">
                        <div style="font-size:12px; font-weight:800; color:#92400e; margin-bottom:4px;">Catatan COD:</div>
                        <div style="font-size:12px; color:#b45309;">Bayar tunai saat barang tiba. Pastikan kamu ada di rumah saat pengiriman.</div>
                    </div>
                </div>

                {{-- Ringkasan harga --}}
                <div class="section-card">
                    <div class="section-title">🧾 Ringkasan Pembayaran</div>

                    <div class="summary-row subtotal">
                        <span>Subtotal</span>
                        <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="summary-row shipping">
                        <span>Ongkir</span>
                        <span>
                            @if($shippingCost == 0)
                                <span class="free-shipping">GRATIS</span>
                            @else
                                Rp {{ number_format($shippingCost, 0, ',', '.') }}
                            @endif
                        </span>
                    </div>
                    @if($source === 'offer' && isset($savingAmount) && $savingAmount > 0)
                    <div class="summary-row discount">
                        <span>💰 Hemat Harga Tawar</span>
                        <span>-Rp {{ number_format($savingAmount, 0, ',', '.') }}</span>
                    </div>
                    @endif
                    <div class="summary-row total">
                        <span>Total</span>
                        <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>

                    @if($shippingCost > 0)
                    <div style="font-size:11px; color:var(--text-muted); text-align:center; margin-top:8px;">
                        💡 Gratis ongkir untuk pembelian ≥ Rp 50.000
                    </div>
                    @endif

                    <button type="submit" class="btn-checkout" id="btnCheckout">
                        <span>✅</span> Buat Pesanan
                    </button>

                    <div style="text-align:center; margin-top:12px;">
                        <a href="{{ route('cart.index') }}" style="font-size:13px; color:var(--text-muted);">
                            ← Kembali ke keranjang
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
// Payment method toggle
document.querySelectorAll('.payment-opt').forEach(opt => {
    opt.addEventListener('click', function() {
        document.querySelectorAll('.payment-opt').forEach(o => o.classList.remove('selected'));
        this.classList.add('selected');

        const val = this.querySelector('input').value;
        document.getElementById('transfer-info').style.display = val === 'transfer' ? 'block' : 'none';
        document.getElementById('ewallet-info').style.display  = val === 'e-wallet'  ? 'block' : 'none';
        document.getElementById('cod-info').style.display      = val === 'cod'       ? 'block' : 'none';
    });
});
// Set default selected
document.getElementById('opt-transfer').classList.add('selected');

// Prevent double submit
document.getElementById('checkoutForm').addEventListener('submit', function() {
    const btn = document.getElementById('btnCheckout');
    btn.disabled = true;
    btn.innerHTML = '<span>⏳</span> Memproses...';
});
</script>
@endpush
