<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Penarikan – SEARA</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('assets/LOGO_FIKS_LIGHT.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        :root {
            --green-dark: #1a4731; --green-main: #2d8653; --green-mid: #3dba7e;
            --green-light: #52dda0; --green-pale: #f0fdf6; --accent: #e05c2e;
            --yellow: #f5a623; --yellow-soft: #fffbeb; --blue: #2563eb; --blue-soft: #eff6ff;
            --purple: #7c3aed; --purple-soft: #f5f3ff; --text-dark: #0f2419;
            --text-mid: #3d5c49; --text-muted: #7a9585; --border: #e2ece7;
            --white: #ffffff; --bg: #f5f9f6; --r: 14px;
            --shadow-sm: 0 1px 4px rgba(0,0,0,.06); --shadow-md: 0 4px 18px rgba(0,0,0,.09);
        }
        * { box-sizing: border-box; margin: 0; padding: 0 }
        body { background: var(--bg); font-family: 'Nunito', sans-serif; color: var(--text-dark) }
        .seller-wrap { display: flex; min-height: 100vh }
        .seller-main { flex: 1; padding: 24px; overflow-x: hidden }
        .page-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 22px }
        .page-header h1 { font-family: 'Playfair Display', serif; font-size: 26px; font-weight: 700 }
        .page-header p { font-size: 13px; color: var(--text-muted); margin-top: 3px }
        .btn-green {
            background: var(--green-main); color: #fff; border: none; border-radius: 8px;
            padding: 10px 18px; font-size: 13px; font-weight: 700; cursor: pointer;
            display: inline-flex; align-items: center; gap: 7px; text-decoration: none;
        }
        .btn-outline {
            background: var(--white); color: var(--green-main); border: 1.5px solid var(--green-main);
            border-radius: 8px; padding: 9px 16px; font-size: 13px; font-weight: 700;
            cursor: pointer; display: inline-flex; align-items: center; gap: 7px; text-decoration: none;
        }
        /* Stats */
        .stats-bar { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 22px }
        .stat-card {
            background: var(--white); border-radius: var(--r); padding: 20px;
            border: 1.5px solid var(--border); box-shadow: var(--shadow-sm);
        }
        .stat-label { font-size: 12px; color: var(--text-muted); font-weight: 700; margin-bottom: 6px }
        .stat-value { font-size: 22px; font-weight: 900; color: var(--text-dark) }
        /* Table */
        .table-card {
            background: var(--white); border-radius: var(--r); border: 1.5px solid var(--border);
            box-shadow: var(--shadow-sm); overflow: hidden; margin-bottom: 20px;
        }
        .table-card-head {
            display: flex; align-items: center; justify-content: space-between;
            padding: 16px 20px; border-bottom: 1.5px solid var(--border);
        }
        .table-card-head h3 { font-size: 15px; font-weight: 800; display: flex; align-items: center; gap: 8px }
        .rw-table { width: 100%; border-collapse: collapse; font-size: 13px }
        .rw-table th {
            padding: 11px 16px; text-align: left; color: var(--text-muted);
            font-weight: 700; border-bottom: 1.5px solid var(--border); white-space: nowrap;
        }
        .rw-table td { padding: 13px 16px; border-bottom: 1px solid var(--border); vertical-align: middle }
        .rw-table tr:last-child td { border-bottom: none }
        .rw-table tr:hover td { background: var(--green-pale) }
        .badge {
            display: inline-block; font-size: 11px; font-weight: 700;
            padding: 3px 10px; border-radius: 20px; white-space: nowrap;
        }
        .badge-pending     { background: #fef3c7; color: #b45309 }
        .badge-approved    { background: #dbeafe; color: #1d4ed8 }
        .badge-transferred { background: #dcfce7; color: #15803d }
        .badge-rejected    { background: #fee2e2; color: #b91c1c }
        .filter-bar { display: flex; gap: 10px; align-items: center; padding: 14px 20px; border-bottom: 1px solid var(--border); flex-wrap: wrap }
        .filter-select {
            border: 1.5px solid var(--border); border-radius: 8px; padding: 8px 12px;
            font-size: 13px; font-family: inherit; color: var(--text-dark); background: var(--white); cursor: pointer;
        }
        .empty-state { text-align: center; padding: 60px 20px; color: var(--text-muted) }
        .empty-state i { font-size: 40px; margin-bottom: 12px; opacity: .5 }
        .empty-state p { font-size: 14px }
        .alert {
            padding: 13px 16px; border-radius: 10px; margin-bottom: 18px;
            display: flex; align-items: center; gap: 10px; font-size: 13px; font-weight: 700;
        }
        .alert-success { background: #dcfce7; color: #15803d }
        .alert-error   { background: #fee2e2; color: #b91c1c }
        .pagination { padding: 16px 20px; display: flex; justify-content: center }
        .pagination nav { display: flex; gap: 4px }
    </style>
</head>
<body>
<div class="seller-wrap">

    @include('partials.seller_sidebar')

    <main class="seller-main">

        @if(session('success'))
        <div class="alert alert-success"><i class="fa-solid fa-circle-check"></i> {{ session('success') }}</div>
        @endif
        @if(session('error'))
        <div class="alert alert-error"><i class="fa-solid fa-circle-xmark"></i> {{ session('error') }}</div>
        @endif

        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h1>Riwayat Penarikan <i class="fa-solid fa-money-bill-transfer" style="font-size:22px;color:var(--green-main)"></i></h1>
                <p>Lihat semua riwayat pengajuan penarikan dana Anda.</p>
            </div>
            <div style="display:flex;gap:10px">
                <a href="{{ route('seller.keuangan.index') }}" class="btn-outline">
                    <i class="fa-solid fa-arrow-left"></i> Kembali
                </a>
                <button class="btn-green" onclick="document.getElementById('withdrawModal').style.display='flex'">
                    <i class="fa-solid fa-plus"></i> Tarik Dana Baru
                </button>
            </div>
        </div>

        <!-- Stats -->
        <div class="stats-bar">
            <div class="stat-card">
                <div class="stat-label"><i class="fa-solid fa-arrow-up" style="color:var(--green-main)"></i> Total Diajukan</div>
                <div class="stat-value" style="color:var(--green-main)">Rp {{ number_format($totalDitarik, 0, ',', '.') }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label"><i class="fa-solid fa-check" style="color:#15803d"></i> Total Diterima (Cair)</div>
                <div class="stat-value" style="color:#15803d">Rp {{ number_format($totalSudahCair, 0, ',', '.') }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label"><i class="fa-solid fa-clock" style="color:#b45309"></i> Sedang Diproses</div>
                <div class="stat-value" style="color:#b45309">Rp {{ number_format($pendingWithdrawal, 0, ',', '.') }}</div>
            </div>
        </div>

        <!-- Table -->
        <div class="table-card">
            <div class="table-card-head">
                <h3>
                    <i class="fa-solid fa-list-check" style="color:var(--green-main)"></i>
                    Semua Pengajuan
                    <span style="background:var(--green-pale);color:var(--green-dark);font-size:11px;padding:2px 9px;border-radius:20px;font-weight:800">
                        {{ $withdrawals->total() }}
                    </span>
                </h3>
            </div>

            <!-- Filter -->
            <form method="GET" class="filter-bar">
                <select name="status" class="filter-select" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="pending"     {{ request('status') === 'pending'     ? 'selected' : '' }}>Menunggu</option>
                    <option value="approved"    {{ request('status') === 'approved'    ? 'selected' : '' }}>Disetujui</option>
                    <option value="transferred" {{ request('status') === 'transferred' ? 'selected' : '' }}>Sudah Cair</option>
                    <option value="rejected"    {{ request('status') === 'rejected'    ? 'selected' : '' }}>Ditolak</option>
                </select>
            </form>

            @if($withdrawals->isEmpty())
            <div class="empty-state">
                <i class="fa-solid fa-money-bill-transfer"></i>
                <p>Belum ada riwayat penarikan dana.</p>
            </div>
            @else
            <div style="overflow-x:auto">
            <table class="rw-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tanggal Pengajuan</th>
                        <th>Jumlah</th>
                        <th>Biaya Admin</th>
                        <th>Diterima</th>
                        <th>Rekening Tujuan</th>
                        <th>Status</th>
                        <th>Catatan Admin</th>
                        <th>Selesai</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($withdrawals as $wd)
                    <tr>
                        <td style="color:var(--text-muted);font-weight:700">{{ $withdrawals->firstItem() + $loop->index }}</td>
                        <td style="color:var(--text-mid)">{{ $wd->created_at->format('d/m/Y H:i') }}</td>
                        <td style="font-weight:800;color:var(--text-dark)">Rp {{ number_format($wd->jumlah, 0, ',', '.') }}</td>
                        <td style="color:var(--text-muted)">Rp {{ number_format($wd->biaya_admin, 0, ',', '.') }}</td>
                        <td style="font-weight:800;color:var(--green-main)">Rp {{ number_format($wd->diterima, 0, ',', '.') }}</td>
                        <td style="color:var(--text-mid)">
                            <strong>{{ $wd->nama_bank ?? '-' }}</strong><br>
                            <span style="font-size:12px">{{ $wd->no_rekening ?? '-' }}</span><br>
                            <span style="font-size:11px;color:var(--text-muted)">{{ $wd->atas_nama ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="badge badge-{{ $wd->status }}">
                                {{ $wd->status_label }}
                            </span>
                        </td>
                        <td style="color:var(--text-muted);font-size:12px;max-width:180px">
                            {{ $wd->admin_note ?? '-' }}
                        </td>
                        <td style="color:var(--text-muted);font-size:12px">
                            {{ $wd->transferred_at ? $wd->transferred_at->format('d/m/Y') : '-' }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>

            @if($withdrawals->hasPages())
            <div class="pagination">
                {{ $withdrawals->withQueryString()->links() }}
            </div>
            @endif
            @endif
        </div>

    </main>
</div>

<!-- Modal Tarik Dana (redirect ke keuangan.index untuk proses) -->
<script>
    // Redirect ke halaman keuangan utama untuk proses withdrawal
    document.querySelector('.btn-green').addEventListener('click', function(e) {
        e.preventDefault();
        window.location.href = '{{ route("seller.keuangan.index") }}';
    });
</script>
</body>
</html>
