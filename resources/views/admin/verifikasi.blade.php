{{-- resources/views/admin/verifikasi.blade.php --}}
@extends('layouts.admin')

@section('title', 'Pengajuan Seller')

@push('styles')
<style>
     /* ── MODALS ── */
        .modal-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 9999;
            background: rgba(0, 0, 0, .5);
            backdrop-filter: blur(4px);
            align-items: center;
            justify-content: center;
            padding: 16px;
        }

        .modal-backdrop.open {
            display: flex;
        }

        .modal-box {
            background: #fff;
            border-radius: 20px;
            width: 100%;
            box-shadow: 0 20px 60px rgba(0, 0, 0, .2);
            animation: modalIn .22s cubic-bezier(.4, 0, .2, 1);
            overflow: hidden;
            padding: 24px;
        }

        @keyframes modalIn {
            from {
                opacity: 0;
                transform: scale(.95) translateY(8px);
            }

            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        .modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 22px 24px 18px;
            border-bottom: 1px solid var(--border);
        }

        .modal-close {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            border: none;
            background: var(--surface2);
            color: var(--muted);
            font-size: 14px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background .15s;
        }

        .modal-close:hover {
            background: var(--border);
            color: var(--text);
        }

        .modal-avatar {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--accent), #1a6640);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            font-weight: 800;
            color: #fff;
            flex-shrink: 0;
        }

        .modal-body {
            padding: 20px 24px;
        }

        .modal-footer {
            padding: 16px 24px;
            border-top: 1px solid var(--border);
            display: flex;
            gap: 10px;
            justify-content: flex-end;
        }

        .modal-icon-circle {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
        }

        /* Detail rows */
        .detail-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 10px 0;
            border-bottom: 1px solid var(--border);
            font-size: 13px;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-key {
            color: var(--muted);
            font-weight: 600;
        }

        .detail-value {
            font-weight: 700;
            color: var(--text);
            text-align: right;
        }

        /* Modal buttons */
        .modal-btn {
            flex: 1;
            padding: 11px;
            border-radius: 12px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            border: none;
            transition: background .18s;
        }

        .modal-icon-danger {
            background: #fee2e2;
        }

        .modal-icon-success {
            background: #dcfce7;
        }

        .modal-btn.secondary {
            background: var(--surface2);
            color: var(--muted);
            border: 1.5px solid var(--border);
        }

        .modal-btn.secondary:hover {
            border-color: var(--accent);
            color: var(--text);
        }

        .modal-btn.primary {
            background: var(--accent);
            color: #fff;
        }

        .modal-btn.primary:hover {
            background: #34a46e;
        }

        .modal-btn.danger {
            background: var(--danger);
            color: #fff;
        }

        .modal-btn.danger:hover {
            background: #c94f4f;
        }

        /* Loading skeleton di modal detail */
        .skeleton {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: shimmer 1.2s infinite;
            border-radius: 6px;
            height: 14px;
        }

        @keyframes shimmer {
            from {
                background-position: 200% 0;
            }

            to {
                background-position: -200% 0;
            }
        }

        /* ── Page header ── */
        .page-header {
            margin-bottom: 22px;
        }

        .page-title {
            font-size: 26px;
            font-weight: 800;
            color: var(--text);
            letter-spacing: -.5px;
        }

        .page-sub {
            font-size: 13px;
            color: var(--muted);
            margin-top: 4px;
        }

        /* ── Stats ── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 12px;
            margin-bottom: 20px;
        }

        .stat-card {
            background: var(--surface);
            border: 1.5px solid var(--border);
            border-radius: 16px;
            padding: 16px;
            transition: box-shadow .2s, transform .2s;
        }

        .stat-card:hover {
            box-shadow: 0 6px 20px rgba(0, 0, 0, .07);
            transform: translateY(-2px);
        }

        .stat-label {
            font-size: 11px;
            font-weight: 700;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: .5px;
            margin-bottom: 8px;
        }

        .stat-num {
            font-size: 22px;
            font-weight: 800;
            color: var(--text);
            line-height: 1;
        }

        .stat-sub {
            font-size: 11px;
            color: var(--muted);
            margin-top: 4px;
        }

        /* ── Tabs ── */
        .tab-bar {
            display: flex;
            gap: 6px;
            margin-bottom: 16px;
            background: var(--surface);
            border: 1.5px solid var(--border);
            border-radius: 14px;
            padding: 6px;
        }

        .tab-btn {
            padding: 9px 18px;
            border-radius: 10px;
            border: none;
            background: transparent;
            font-family: inherit;
            font-size: 13px;
            font-weight: 600;
            color: var(--muted);
            cursor: pointer;
            transition: all .18s;
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .tab-btn:hover {
            background: var(--surface2);
            color: var(--text);
        }

        .tab-btn.active {
            background: var(--bg);
            color: #fff;
        }

        .tab-count {
            font-size: 11px;
            font-weight: 800;
            padding: 1px 8px;
            border-radius: 20px;
            background: rgba(255, 255, 255, .15);
        }

        .tab-btn:not(.active) .tab-count {
            background: var(--border);
            color: var(--muted);
        }

        /* ── Filters ── */
        .filter-bar {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 16px;
            flex-wrap: wrap;
        }

        .filter-select {
            padding: 9px 14px;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            font-family: inherit;
            font-size: 13px;
            color: var(--text);
            background: var(--surface);
            cursor: pointer;
            outline: none;
            transition: border-color .2s;
        }

        .filter-select:focus {
            border-color: var(--accent);
        }

        .btn-reset {
            padding: 9px 14px;
            border-radius: 10px;
            border: 1.5px solid var(--border);
            background: var(--surface);
            color: var(--muted);
            font-family: inherit;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all .2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }

        .btn-reset:hover {
            border-color: var(--accent);
            color: var(--text);
        }

        /* ── Table section ── */
        .section {
            background: var(--surface);
            border: 1.5px solid var(--border);
            border-radius: var(--radius);
            padding: 24px;
        }

        .section-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 18px;
        }

        .section-title {
            font-size: 16px;
            font-weight: 800;
            color: var(--text);
        }

        .section-meta {
            font-size: 13px;
            color: var(--muted);
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th {
            text-align: left;
            font-size: 11px;
            font-weight: 700;
            color: var(--muted);
            letter-spacing: .5px;
            text-transform: uppercase;
            padding: 0 14px 14px;
        }

        .data-table td {
            padding: 14px;
            font-size: 13px;
            font-weight: 500;
            color: var(--text);
            border-top: 1px solid var(--border);
        }

        .data-table tbody tr {
            transition: background .15s;
        }

        .data-table tbody tr:hover {
            background: var(--surface2);
        }

        .cell-primary {
            font-weight: 700;
            color: var(--text);
        }

        .cell-secondary {
            font-size: 11px;
            color: var(--muted);
            margin-top: 2px;
        }

        .user-cell {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .avatar-circle {
            width: 38px;
            height: 38px;
            border-radius: 11px;
            background: linear-gradient(135deg, var(--accent), #1a6640);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: 800;
            color: #fff;
            flex-shrink: 0;
            overflow: hidden;
        }

        .avatar-circle img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Badges */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
        }

        .badge-green {
            background: #dcfce7;
            color: #166534;
        }

        .badge-red {
            background: #fee2e2;
            color: #991b1b;
        }

        .badge-blue {
            background: #dbeafe;
            color: #1e40af;
        }

        .badge-gray {
            background: #f1f5f9;
            color: #475569;
        }

        .badge-orange {
            background: #fff7ed;
            color: #c2410c;
        }

        .role-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            display: inline-block;
            flex-shrink: 0;
        }

        .dot-buyer {
            background: #3dba7e;
        }

        .dot-seller {
            background: #f59e0b;
        }

        .shop-tag {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: #fff7ed;
            color: #c2410c;
            border-radius: 8px;
            padding: 3px 9px;
            font-size: 11px;
            font-weight: 700;
        }

        .shop-tag svg {
            width: 11px;
            height: 11px;
        }

        /* Action buttons */
        .action-btn {
            padding: 6px 12px;
            border-radius: 8px;
            border: none;
            font-family: inherit;
            font-size: 11px;
            font-weight: 700;
            cursor: pointer;
            transition: all .18s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }

        .action-btn.detail {
            background: #f1f5f9;
            color: #475569;
        }

        .action-btn.detail:hover {
            background: #e2e8f0;
            color: var(--text);
        }

        .action-btn.nonaktif {
            background: #fee2e2;
            color: #991b1b;
        }

        .action-btn.nonaktif:hover {
            background: #fca5a5;
        }

        .action-btn.aktifkan {
            background: #dcfce7;
            color: #166534;
        }

        .action-btn.aktifkan:hover {
            background: #bbf7d0;
        }

        .action-btn.hapus {
            background: #fff1f2;
            color: #be123c;
        }

        .action-btn.hapus:hover {
            background: #ffe4e6;
        }

        /* Pagination */
        .pagination-wrap {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 20px;
            padding-top: 16px;
            border-top: 1px solid var(--border);
        }

        .pagination-info {
            font-size: 13px;
            color: var(--muted);
        }

        .pagination-links {
            display: flex;
            gap: 6px;
        }

        .page-link {
            width: 34px;
            height: 34px;
            border-radius: 9px;
            border: 1.5px solid var(--border);
            background: var(--surface);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 600;
            color: var(--text);
            text-decoration: none;
            transition: all .18s;
        }

        .page-link:hover {
            border-color: var(--accent);
            color: var(--accent);
        }

        .page-link.active {
            background: var(--accent);
            border-color: var(--accent);
            color: #fff;
        }

        .page-link.disabled {
            opacity: .35;
            pointer-events: none;
        }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-icon {
            font-size: 48px;
            margin-bottom: 12px;
        }

        .empty-title {
            font-size: 16px;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 6px;
        }

        .empty-sub {
            font-size: 13px;
            color: var(--muted);
        }

        /* Alert */
        .alert {
            padding: 12px 18px;
            border-radius: 12px;
            margin-bottom: 16px;
            font-size: 13px;
            font-weight: 600;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
        }

        @media (max-width: 1280px) {
            .stats-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: 1fr 1fr;
            }
        }
    .modal-image {
        max-width: 100%;
        border-radius: 12px;
        border: 1px solid var(--border);
        margin-top: 8px;
    }
    .two-columns {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }
    @media (max-width: 640px) {
        .two-columns { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')
<div class="page-header">
    <h1 class="page-title">Pengajuan Seller</h1>
    <p class="page-sub">Tinjau dan verifikasi permohonan menjadi petani/penjual di NUSATANI.</p>
</div>

@if(session('success'))
    <div class="alert alert-success">✓ {{ session('success') }}</div>
@endif

{{-- Stats --}}
<div class="stats-grid">
    @php
        $total = $countByStatus['pending'] + $countByStatus['reviewing'] + $countByStatus['approved'] + $countByStatus['rejected'];
    @endphp
    <div class="stat-card"><div class="stat-label">Total Pengajuan</div><div class="stat-num">{{ number_format($total) }}</div></div>
    <div class="stat-card"><div class="stat-label">Pending</div><div class="stat-num" style="color:#f59e0b">{{ number_format($countByStatus['pending'] ?? 0) }}</div></div>
    <div class="stat-card"><div class="stat-label">Reviewing</div><div class="stat-num" style="color:#3b82f6">{{ number_format($countByStatus['reviewing'] ?? 0) }}</div></div>
    <div class="stat-card"><div class="stat-label">Disetujui</div><div class="stat-num" style="color:var(--accent)">{{ number_format($countByStatus['approved'] ?? 0) }}</div></div>
    <div class="stat-card"><div class="stat-label">Ditolak</div><div class="stat-num" style="color:var(--danger)">{{ number_format($countByStatus['rejected'] ?? 0) }}</div></div>
</div>

{{-- Tab Filter Status --}}
<div class="tab-bar">
    <a href="{{ route('admin.verifikasi.index', ['status' => 'all']) }}" class="tab-btn {{ $status === 'all' ? 'active' : '' }}">Semua</a>
    <a href="{{ route('admin.verifikasi.index', ['status' => 'pending']) }}" class="tab-btn {{ $status === 'pending' ? 'active' : '' }}">Pending</a>
    <a href="{{ route('admin.verifikasi.index', ['status' => 'reviewing']) }}" class="tab-btn {{ $status === 'reviewing' ? 'active' : '' }}">Reviewing</a>
    <a href="{{ route('admin.verifikasi.index', ['status' => 'approved']) }}" class="tab-btn {{ $status === 'approved' ? 'active' : '' }}">Disetujui</a>
    <a href="{{ route('admin.verifikasi.index', ['status' => 'rejected']) }}" class="tab-btn {{ $status === 'rejected' ? 'active' : '' }}">Ditolak</a>
</div>

{{-- Tabel --}}
<div class="section">
    <div class="section-head">
        <span class="section-title">Daftar Pengajuan</span>
        <span class="section-meta">{{ $applications->total() }} pengajuan</span>
    </div>

    @if($applications->isEmpty())
        <div class="empty-state"><div class="empty-icon">📋</div><div class="empty-title">Tidak ada pengajuan</div></div>
    @else
        <table class="data-table">
            <thead>
                <tr><th>Pemohon</th><th>Toko</th><th>Kategori</th><th>Status</th><th>Tanggal</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                @foreach($applications as $app)
                <tr>
                    <td>
                        <div class="user-cell">
                            <div class="avatar-circle">{{ strtoupper(substr($app->user->nama_lengkap, 0, 1)) }}</div>
                            <div><div class="cell-primary">{{ $app->user->nama_lengkap }}</div><div class="cell-secondary">{{ $app->user->email }}</div></div>
                        </div>
                    </td>
                    <td><div class="cell-primary">{{ $app->nama_toko }}</div></td>
                    <td>{{ $app->kategori_utama }}</td>
                    <td>
                        @php
                            $statusClass = match($app->status) {
                                'pending' => 'badge-orange',
                                'reviewing' => 'badge-blue',
                                'approved' => 'badge-green',
                                'rejected' => 'badge-red',
                                default => 'badge-gray'
                            };
                            $statusLabel = match($app->status) {
                                'pending' => 'Pending',
                                'reviewing' => 'Reviewing',
                                'approved' => 'Disetujui',
                                'rejected' => 'Ditolak',
                                default => ucfirst($app->status)
                            };
                        @endphp
                        <span class="badge {{ $statusClass }}">{{ $statusLabel }}</span>
                    </td>
                    <td><div class="cell-primary">{{ \Carbon\Carbon::parse($app->submitted_at)->format('d M Y') }}</div>
                    <td>
                        <button type="button" class="action-btn detail" onclick="openDetailModal({{ $app->id }})">Detail</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagination-wrap">{{ $applications->links() }}</div>
    @endif
</div>

{{-- MODAL DETAIL --}}
<div id="modalDetail" class="modal-backdrop" onclick="if(event.target===this)closeModal('modalDetail')">
    <div class="modal-box" style="max-width:700px; max-height:90vh; overflow-y:auto;">
        <div class="modal-header">
            <div><div id="modalNamaToko" style="font-size:18px;font-weight:800"></div><div id="modalPemohon" style="font-size:13px;color:var(--muted)"></div></div>
            <button class="modal-close" onclick="closeModal('modalDetail')">✕</button>
        </div>
        <div class="modal-body" id="modalDetailBody">Loading...</div>
        <div class="modal-footer" id="modalDetailFooter"></div>
    </div>
</div>

{{-- MODAL REJECT (alasan penolakan) --}}
<div id="modalReject" class="modal-backdrop" onclick="if(event.target===this)closeModal('modalReject')">
    <div class="modal-box" style="max-width:400px">
        <div class="modal-header"><span style="font-weight:800">Tolak Pengajuan</span><button class="modal-close" onclick="closeModal('modalReject')">✕</button></div>
        <div class="modal-body">
            <p style="margin-bottom:12px">Berikan alasan penolakan:</p>
            <textarea id="rejectReason" rows="4" class="form-control" placeholder="Contoh: Data KTP tidak jelas..."></textarea>
            <div id="rejectError" style="color:red;font-size:12px;margin-top:5px"></div>
        </div>
        <div class="modal-footer">
            <button class="modal-btn secondary" onclick="closeModal('modalReject')">Batal</button>
            <button class="modal-btn danger" id="confirmRejectBtn">Ya, Tolak</button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    let currentApplicationId = null;

    function openModal(id) { document.getElementById(id).classList.add('open'); }
    function closeModal(id) { document.getElementById(id).classList.remove('open'); }

    async function openDetailModal(id) {
        currentApplicationId = id;
        document.getElementById('modalDetailBody').innerHTML = '<div style="text-align:center;padding:40px">Memuat data...</div>';
        openModal('modalDetail');

        try {
            const res = await fetch(`/admin/verifikasi/${id}/detail`);
            const data = await res.json();

            const submittedFormatted = new Date(data.submitted_at).toLocaleString('id-ID');
const reviewedFormatted = data.reviewed_at ? new Date(data.reviewed_at).toLocaleString('id-ID') : null;
            // Header
            document.getElementById('modalNamaToko').innerText = data.nama_toko;
            document.getElementById('modalPemohon').innerHTML = `${data.user.nama_lengkap} · ${data.user.email}`;

            // Body
            let fotoHtml = '';
            if (data.foto_ktp_url) fotoHtml += `<div><strong>Foto KTP</strong><br><img src="${data.foto_ktp_url}" class="modal-image" style="max-height:200px"></div>`;
            if (data.foto_selfie_url) fotoHtml += `<div><strong>Selfie dengan KTP</strong><br><img src="${data.foto_selfie_url}" class="modal-image" style="max-height:200px"></div>`;

            let statusBadge = '';
            if (data.status === 'pending') statusBadge = '<span class="badge badge-orange">Pending</span>';
            else if (data.status === 'reviewing') statusBadge = '<span class="badge badge-blue">Reviewing</span>';
            else if (data.status === 'approved') statusBadge = '<span class="badge badge-green">Disetujui</span>';
            else if (data.status === 'rejected') statusBadge = '<span class="badge badge-red">Ditolak</span>';

            document.getElementById('modalDetailBody').innerHTML = `
                <div class="two-columns">
                    <div>
                        <div class="detail-row"><span class="detail-key">Status</span><span class="detail-value">${statusBadge}</span></div>
                        <div class="detail-row"><span class="detail-key">Kategori</span><span class="detail-value">${data.kategori_utama}</span></div>
                        <div class="detail-row"><span class="detail-key">Provinsi</span><span class="detail-value">${data.provinsi}</span></div>
                        <div class="detail-row"><span class="detail-key">Kota/Kab</span><span class="detail-value">${data.kota_kabupaten}</span></div>
                        <div class="detail-row"><span class="detail-key">Alamat Toko</span><span class="detail-value">${data.alamat_toko}</span></div>
                        <div class="detail-row"><span class="detail-key">Deskripsi</span><span class="detail-value">${data.deskripsi_toko}</span></div>
                    </div>
                    <div>
                        <div class="detail-row"><span class="detail-key">Bank</span><span class="detail-value">${data.nama_bank}</span></div>
                        <div class="detail-row"><span class="detail-key">No Rekening</span><span class="detail-value">${data.no_rekening}</span></div>
                        <div class="detail-row"><span class="detail-key">Atas Nama</span><span class="detail-value">${data.atas_nama_rekening}</span></div>
                        <div class="detail-row"><span class="detail-key">No KTP</span><span class="detail-value">${data.no_ktp}</span></div>
                        <div class="detail-row">
    <span class="detail-key">Diajukan</span>
    <span class="detail-value">${new Date(data.submitted_at).toLocaleString('id-ID')}</span>
</div>
                        ${data.reviewed_at ? `<div class="detail-row"><span class="detail-key">Direview</span><span class="detail-value">${data.reviewed_at}</span></div>` : ''}
                        ${data.catatan_penolakan ? `<div class="detail-row"><span class="detail-key">Catatan Tolak</span><span class="detail-value">${data.catatan_penolakan}</span></div>` : ''}
                    </div>
                </div>
                <div class="two-columns" style="margin-top:20px">
                    ${fotoHtml}
                </div>
            `;

            // Footer buttons based on status
            let footerHtml = `<button class="modal-btn secondary" onclick="closeModal('modalDetail')">Tutup</button>`;
            if (data.status === 'pending') {
                footerHtml = `
                    <button class="modal-btn secondary" onclick="closeModal('modalDetail')">Tutup</button>
                    <button class="modal-btn primary" onclick="setReviewing(${data.id})">Tandai Reviewing</button>
                    <button class="modal-btn primary" onclick="approveApplication(${data.id})">Setujui</button>
                    <button class="modal-btn danger" onclick="openRejectModal(${data.id})">Tolak</button>
                `;
            } else if (data.status === 'reviewing') {
                footerHtml = `
                    <button class="modal-btn secondary" onclick="closeModal('modalDetail')">Tutup</button>
                    <button class="modal-btn primary" onclick="approveApplication(${data.id})">Setujui</button>
                    <button class="modal-btn danger" onclick="openRejectModal(${data.id})">Tolak</button>
                `;
            } else {
                footerHtml = `<button class="modal-btn secondary" onclick="closeModal('modalDetail')">Tutup</button>`;
            }
            document.getElementById('modalDetailFooter').innerHTML = footerHtml;
        } catch(e) {
            document.getElementById('modalDetailBody').innerHTML = '<p style="color:red">Gagal memuat data.</p>';
        }
    }

    async function setReviewing(id) {
        if(!confirm('Tandai pengajuan ini sebagai "Sedang Direview"?')) return;
        const res = await fetch(`/admin/verifikasi/${id}/set-reviewing`, { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' } });
        const data = await res.json();
        if(data.success) { location.reload(); }
        else alert('Gagal: '+data.message);
    }

    async function approveApplication(id) {
        if(!confirm('Setujui pengajuan ini? Akun akan menjadi seller.')) return;
        const res = await fetch(`/admin/verifikasi/${id}/approve`, { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' } });
        const data = await res.json();
        if(data.success) { location.reload(); }
        else alert('Gagal: '+data.message);
    }

    function openRejectModal(id) {
        currentApplicationId = id;
        document.getElementById('rejectReason').value = '';
        document.getElementById('rejectError').innerText = '';
        openModal('modalReject');
    }

    document.getElementById('confirmRejectBtn')?.addEventListener('click', async () => {
        const reason = document.getElementById('rejectReason').value.trim();
        if(!reason) {
            document.getElementById('rejectError').innerText = 'Alasan penolakan harus diisi.';
            return;
        }
        const res = await fetch(`/admin/verifikasi/${currentApplicationId}/reject`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json', 'Content-Type': 'application/json' },
            body: JSON.stringify({ catatan_penolakan: reason })
        });
        const data = await res.json();
        if(data.success) { location.reload(); }
        else alert('Gagal: '+data.message);
    });
</script>
@endpush