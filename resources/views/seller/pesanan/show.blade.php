<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan #{{ $order->order_number }} – SEARA</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Nunito:wght@400;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('assets/LOGO_FIKS_LIGHT.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        :root {
            --green-dark: #1a4731;
            --green-main: #2d8653;
            --green-mid: #3dba7e;
            --green-light: #52dda0;
            --green-pale: #f0fdf6;
            --accent: #e05c2e;
            --accent-soft: #fff0eb;
            --yellow: #f5a623;
            --yellow-soft: #fffbeb;
            --blue: #2563eb;
            --blue-soft: #eff6ff;
            --text-dark: #0f2419;
            --text-mid: #3d5c49;
            --text-muted: #7a9585;
            --bg: #f8fdfb;
            --card: #ffffff;
            --border: #d4ead9;
            font-family: 'Nunito', sans-serif;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body { background: var(--bg); color: var(--text-dark); min-height: 100vh; }

        .seller-wrap { display: flex; min-height: 100vh; }

        .seller-main {
            flex: 1;
            padding: 28px 32px;
            margin-left: 240px;
            max-width: calc(100% - 240px);
        }

        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
            flex-wrap: wrap;
            gap: 12px;
        }

        .page-header h1 { font-size: 22px; font-weight: 800; color: var(--green-dark); }
        .page-header p  { font-size: 13px; color: var(--text-muted); margin-top: 2px; }

        .btn-green {
            background: var(--green-main);
            color: #fff;
            border: none;
            padding: 9px 18px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: background .2s;
        }
        .btn-green:hover { background: var(--green-dark); }

        .btn-outline {
            background: #fff;
            color: var(--green-main);
            border: 1.5px solid var(--green-main);
            padding: 9px 18px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all .2s;
        }
        .btn-outline:hover { background: var(--green-pale); }

        .card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 24px;
            margin-bottom: 20px;
        }

        .card-title {
            font-size: 15px;
            font-weight: 800;
            color: var(--green-dark);
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 16px;
        }

        .info-item label {
            font-size: 11px;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: .5px;
            display: block;
            margin-bottom: 4px;
        }

        .info-item span {
            font-size: 14px;
            font-weight: 700;
            color: var(--text-dark);
        }

        .badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 800;
        }

        /* Status badges */
        .badge-pending_payment { background:#fef9c3; color:#854d0e; }
        .badge-paid            { background:#dbeafe; color:#1e40af; }
        .badge-processing      { background:#f3e8ff; color:#7e22ce; }
        .badge-shipped         { background:#ffedd5; color:#9a3412; }
        .badge-delivered       { background:#dcfce7; color:#166534; }
        .badge-cancelled       { background:#fee2e2; color:#991b1b; }
        .badge-refunded        { background:#f3f4f6; color:#374151; }

        /* Items table */
        .items-table { width: 100%; border-collapse: collapse; }
        .items-table th {
            text-align: left;
            font-size: 11px;
            font-weight: 800;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: .5px;
            padding: 8px 12px;
            background: var(--green-pale);
            border-bottom: 1.5px solid var(--border);
        }
        .items-table td {
            padding: 12px;
            border-bottom: 1px solid var(--border);
            font-size: 13px;
            color: var(--text-dark);
        }
        .items-table tr:last-child td { border-bottom: none; }

        .total-row {
            display: flex;
            justify-content: flex-end;
            gap: 32px;
            padding: 16px 12px 0;
            border-top: 1.5px solid var(--border);
            margin-top: 8px;
        }
        .total-row .label { font-size: 13px; color: var(--text-muted); font-weight: 600; }
        .total-row .value { font-size: 16px; font-weight: 900; color: var(--green-dark); }

        .alert-success {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #86efac;
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 18px;
            font-size: 14px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 18px;
            font-size: 14px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        @media (max-width: 768px) {
            .seller-main { margin-left: 0; max-width: 100%; padding: 16px; }
        }
    </style>
</head>

<body>
    <div class="seller-wrap">

        @include('partials.seller_sidebar')

        <main class="seller-main">

            @if(session('success'))
                <div class="alert-success">
                    <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert-error">
                    <i class="fa-solid fa-circle-xmark"></i> {{ session('error') }}
                </div>
            @endif

            <!-- Header -->
            <div class="page-header">
                <div>
                    <h1>Detail Pesanan <i class="fa-solid fa-box-open" style="font-size:20px;color:var(--green-main)"></i></h1>
                    <p>#{{ $order->order_number }}</p>
                </div>
                <div style="display:flex;gap:10px;flex-wrap:wrap">
                    <a href="{{ route('seller.orders.index') }}" class="btn-outline">
                        <i class="fa-solid fa-arrow-left"></i> Kembali
                    </a>
                    <a href="{{ route('seller.orders.print', $order->id) }}" class="btn-outline" target="_blank">
                        <i class="fa-solid fa-print"></i> Cetak
                    </a>
                    @if(in_array($order->status, ['delivered', 'shipped', 'processing']))
                        <a href="{{ route('seller.keuangan.invoice', $order->id) }}" class="btn-green" target="_blank">
                            <i class="fa-solid fa-file-invoice"></i> Invoice
                        </a>
                    @endif
                </div>
            </div>

            <!-- Info Pesanan -->
            <div class="card">
                <div class="card-title">
                    <i class="fa-solid fa-circle-info" style="color:var(--green-main)"></i>
                    Informasi Pesanan
                </div>
                <div class="info-grid">
                    <div class="info-item">
                        <label>No. Pesanan</label>
                        <span>{{ $order->order_number }}</span>
                    </div>
                    <div class="info-item">
                        <label>Status</label>
                        <span>
                            <span class="badge badge-{{ $order->status }}">
                                {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                            </span>
                        </span>
                    </div>
                    <div class="info-item">
                        <label>Tanggal Pesanan</label>
                        <span>{{ $order->created_at->isoFormat('D MMMM YYYY, HH:mm') }}</span>
                    </div>
                    <div class="info-item">
                        <label>Metode Pembayaran</label>
                        <span>{{ $order->payment_method ?? '-' }}</span>
                    </div>
                    @if($order->kurir)
                    <div class="info-item">
                        <label>Kurir</label>
                        <span>{{ $order->kurir }}</span>
                    </div>
                    @endif
                    @if($order->nomor_resi)
                    <div class="info-item">
                        <label>Nomor Resi</label>
                        <span>{{ $order->nomor_resi }}</span>
                    </div>
                    @endif
                    @if($order->cancel_reason)
                    <div class="info-item" style="grid-column:1/-1">
                        <label>Alasan Dibatalkan</label>
                        <span style="color:var(--accent)">{{ $order->cancel_reason }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Info Pembeli -->
            <div class="card">
                <div class="card-title">
                    <i class="fa-solid fa-user" style="color:var(--green-main)"></i>
                    Informasi Pembeli
                </div>
                <div class="info-grid">
                    <div class="info-item">
                        <label>Nama Pembeli</label>
                        <span>{{ $order->buyer->nama_lengkap ?? '-' }}</span>
                    </div>
                    <div class="info-item">
                        <label>Email</label>
                        <span>{{ $order->buyer->email ?? '-' }}</span>
                    </div>
                    @if($order->recipient_name)
                    <div class="info-item">
                        <label>Nama Penerima</label>
                        <span>{{ $order->recipient_name }}</span>
                    </div>
                    @endif
                    @if($order->recipient_phone)
                    <div class="info-item">
                        <label>Telepon</label>
                        <span>{{ $order->recipient_phone }}</span>
                    </div>
                    @endif
                    @if($order->shipping_address)
                    <div class="info-item" style="grid-column:1/-1">
                        <label>Alamat Pengiriman</label>
                        <span>{{ $order->shipping_address }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Item Produk -->
            <div class="card">
                <div class="card-title">
                    <i class="fa-solid fa-basket-shopping" style="color:var(--green-main)"></i>
                    Item Pesanan
                </div>
                <div style="overflow-x:auto">
                    <table class="items-table">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Harga Satuan</th>
                                <th>Qty</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                            <tr>
                                <td>
                                    <div style="font-weight:700">{{ $item->product_name }}</div>
                                    @if($item->harvest && $item->harvest->product)
                                        <div style="font-size:11px;color:var(--text-muted)">
                                            {{ $item->harvest->product->category->nama ?? '' }}
                                        </div>
                                    @endif
                                </td>
                                <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                <td>{{ $item->quantity }} {{ $item->satuan ?? 'kg' }}</td>
                                <td style="font-weight:800;color:var(--green-dark)">
                                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="total-row">
                    <div>
                        <div class="label">Total Pesanan</div>
                        <div class="value">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</div>
                    </div>
                </div>
            </div>

            <!-- Aksi Update Status -->
            @php
                $allowedTransitions = [
                    'paid'        => ['processing', 'cancelled'],
                    'processing'  => ['shipped'],
                ];
                $nextStatuses = $allowedTransitions[$order->status] ?? [];
            @endphp

            @if(count($nextStatuses) > 0)
            <div class="card">
                <div class="card-title">
                    <i class="fa-solid fa-arrows-rotate" style="color:var(--green-main)"></i>
                    Update Status Pesanan
                </div>

                @foreach($nextStatuses as $next)
                <form method="POST" action="{{ route('seller.orders.updateStatus', $order->id) }}"
                      style="margin-bottom:12px">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="{{ $next }}">

                    @if($next === 'shipped')
                    <div style="display:flex;gap:12px;flex-wrap:wrap;margin-bottom:12px">
                        <div style="flex:1;min-width:160px">
                            <label style="font-size:12px;font-weight:700;color:var(--text-muted);display:block;margin-bottom:4px">Kurir *</label>
                            <input type="text" name="kurir" required placeholder="cth. JNE, TIKI"
                                style="width:100%;padding:9px 12px;border:1.5px solid var(--border);border-radius:8px;font-size:13px;font-family:inherit">
                        </div>
                        <div style="flex:1;min-width:160px">
                            <label style="font-size:12px;font-weight:700;color:var(--text-muted);display:block;margin-bottom:4px">No. Resi *</label>
                            <input type="text" name="nomor_resi" required placeholder="Nomor resi pengiriman"
                                style="width:100%;padding:9px 12px;border:1.5px solid var(--border);border-radius:8px;font-size:13px;font-family:inherit">
                        </div>
                    </div>
                    @endif

                    @if($next === 'cancelled')
                    <div style="margin-bottom:12px">
                        <label style="font-size:12px;font-weight:700;color:var(--text-muted);display:block;margin-bottom:4px">Alasan Penolakan *</label>
                        <textarea name="cancel_reason" required rows="2" placeholder="Tulis alasan penolakan..."
                            style="width:100%;padding:9px 12px;border:1.5px solid var(--border);border-radius:8px;font-size:13px;font-family:inherit;resize:vertical"></textarea>
                    </div>
                    @endif

                    @php
                        $btnColors = [
                            'processing' => 'background:#7c3aed;color:#fff',
                            'shipped'    => 'background:#ea580c;color:#fff',
                            'cancelled'  => 'background:#dc2626;color:#fff',
                        ];
                        $btnLabels = [
                            'processing' => '<i class="fa-solid fa-gear"></i> Proses Pesanan',
                            'shipped'    => '<i class="fa-solid fa-truck"></i> Tandai Dikirim',
                            'cancelled'  => '<i class="fa-solid fa-xmark"></i> Tolak Pesanan',
                        ];
                    @endphp
                    <button type="submit"
                        style="{{ $btnColors[$next] ?? 'background:var(--green-main);color:#fff' }};border:none;padding:10px 20px;border-radius:8px;font-size:13px;font-weight:800;cursor:pointer;font-family:inherit">
                        {!! $btnLabels[$next] ?? ucfirst($next) !!}
                    </button>
                </form>
                @endforeach
            </div>
            @endif

        </main>
    </div>
</body>
</html>
