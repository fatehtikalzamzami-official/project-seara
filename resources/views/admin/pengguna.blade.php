{{-- resources/views/admin/pengguna.blade.php --}}
@extends('layouts.admin')

@section('title', 'Data Pengguna')

{{-- Override search bar di topbar dengan form yang punya debounce --}}
@section('topbar_search')
    <form style="flex:1;max-width:440px" method="GET" action="{{ route('admin.pengguna') }}" id="searchForm">
        <input type="hidden" name="role" value="{{ request('role') }}">
        <input type="hidden" name="status" value="{{ request('status') }}">
        <input type="hidden" name="login_method" value="{{ request('login_method') }}">
        <input type="hidden" name="sort" value="{{ request('sort') }}">
        <div class="search-wrap">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8" />
                <path stroke-linecap="round" d="m21 21-4.35-4.35" />
            </svg>
            <input type="text" name="search" placeholder="Cari nama, email, atau WhatsApp..."
                value="{{ request('search') }}" oninput="searchDebounce()">
        </div>
    </form>
@endsection

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
    </style>
@endpush

@section('content')

    <div class="page-header">
        <h1 class="page-title">Data Pengguna</h1>
        <p class="page-sub">Kelola semua pengguna platform SEARA — pembeli maupun seller.</p>
    </div>

    @if(session('success'))
    <div class="alert alert-success">✓ {{ session('success') }}</div>@endif
    @if(session('error'))
    <div class="alert alert-error">✕ {{ session('error') }}</div>@endif

    {{-- Stats --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-label">Total Pengguna</div>
            <div class="stat-num">{{ number_format($stats['total']) }}</div>
            <div class="stat-sub">Semua role</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Pembeli</div>
            <div class="stat-num" style="color:var(--accent)">{{ number_format($stats['buyer']) }}</div>
            <div class="stat-sub">Role buyer</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Seller</div>
            <div class="stat-num" style="color:#f59e0b">{{ number_format($stats['seller']) }}</div>
            <div class="stat-sub">Role seller</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Akun Terdaftar</div>
            <div class="stat-num" style="color:#3b82f6">{{ number_format($stats['aktif']) }}</div>
            <div class="stat-sub">Pengguna yang terdaftar</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Nonaktif</div>
            <div class="stat-num" style="color:var(--danger)">{{ number_format($stats['nonaktif']) }}</div>
            <div class="stat-sub">Diblokir / suspended</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Baru Bulan Ini</div>
            <div class="stat-num" style="color:var(--gold)">{{ number_format($stats['baru_bulan_ini']) }}</div>
            <div class="stat-sub">{{ now()->translatedFormat('F Y') }}</div>
        </div>
    </div>

    {{-- Tab Role --}}
    <div class="tab-bar">
        <a href="{{ request()->fullUrlWithQuery(['role' => '', 'page' => 1]) }}"
            class="tab-btn {{ !request('role') ? 'active' : '' }}">
            Semua <span class="tab-count">{{ number_format($stats['total']) }}</span>
        </a>
        <a href="{{ request()->fullUrlWithQuery(['role' => 'buyer', 'page' => 1]) }}"
            class="tab-btn {{ request('role') === 'buyer' ? 'active' : '' }}">
            <span class="role-dot dot-buyer"></span> Pembeli
            <span class="tab-count">{{ number_format($stats['buyer']) }}</span>
        </a>
        <a href="{{ request()->fullUrlWithQuery(['role' => 'seller', 'page' => 1]) }}"
            class="tab-btn {{ request('role') === 'seller' ? 'active' : '' }}">
            <span class="role-dot dot-seller"></span> Seller
            <span class="tab-count">{{ number_format($stats['seller']) }}</span>
        </a>
    </div>

    {{-- Filter --}}
    <form method="GET" action="{{ route('admin.pengguna') }}" class="filter-bar">
        <input type="hidden" name="role" value="{{ request('role') }}">
        <input type="hidden" name="search" value="{{ request('search') }}">
        <select name="status" class="filter-select" onchange="this.form.submit()">
            <option value="">Semua Status</option>
            <option value="aktif" {{ request('status') === 'aktif' ? 'selected' : '' }}>Aktif</option>
            <option value="nonaktif" {{ request('status') === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
        </select>
        <select name="login_method" class="filter-select" onchange="this.form.submit()">
            <option value="">Semua Login</option>
            <option value="email" {{ request('login_method') === 'email' ? 'selected' : '' }}>Email</option>
            <option value="google" {{ request('login_method') === 'google' ? 'selected' : '' }}>Google</option>
        </select>
        <select name="sort" class="filter-select" onchange="this.form.submit()">
            <option value="terbaru" {{ request('sort', 'terbaru') === 'terbaru' ? 'selected' : '' }}>Terbaru</option>
            <option value="terlama" {{ request('sort') === 'terlama' ? 'selected' : '' }}>Terlama</option>
            <option value="nama_az" {{ request('sort') === 'nama_az' ? 'selected' : '' }}>Nama A–Z</option>
            <option value="nama_za" {{ request('sort') === 'nama_za' ? 'selected' : '' }}>Nama Z–A</option>
        </select>
        @if(request()->hasAny(['search', 'status', 'login_method', 'sort']))
            <a href="{{ route('admin.pengguna', ['role' => request('role')]) }}" class="btn-reset">Reset</a>
        @endif
    </form>

    {{-- Table --}}
    <div class="section">
        <div class="section-head">
            <span class="section-title">Daftar Pengguna</span>
            <span class="section-meta">
                {{ $users->total() }} pengguna
                @if(request('search')) · "<strong>{{ request('search') }}</strong>" @endif
            </span>
        </div>

        @if($users->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">👥</div>
                <div class="empty-title">Tidak ada pengguna ditemukan</div>
                <div class="empty-sub">Coba ubah filter atau kata kunci pencarian.</div>
            </div>
        @else
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Pengguna</th>
                        <th>Role</th>
                        <th>WhatsApp</th>
                        <th>Login</th>
                        <th>Transaksi</th>
                        <th>Status</th>
                        <th>Bergabung</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>
                                <div class="user-cell">
                                    <div class="avatar-circle">
                                        @if($user->avatar)
                                            <img src="{{ $user->avatar }}" alt="">
                                        @else
                                            {{ strtoupper(substr($user->nama_lengkap, 0, 1)) }}
                                        @endif
                                    </div>
                                    <div>
                                        <div class="cell-primary">{{ $user->nama_lengkap }}</div>
                                        <div class="cell-secondary">{{ $user->email }}</div>
                                        @if($user->role === 'seller' && $user->sellerProfile)
                                            <div class="shop-tag" style="margin-top:4px">
                                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                                </svg>
                                                {{ $user->sellerProfile->nama_toko }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($user->role === 'buyer')
                                    <span class="badge badge-green"><span class="role-dot dot-buyer"></span> Pembeli</span>
                                @elseif($user->role === 'seller')
                                    <span class="badge badge-orange"><span class="role-dot dot-seller"></span> Seller</span>
                                @endif
                            </td>
                            <td>{{ $user->no_whatsapp ?? '—' }}</td>
                            <td>
                                @if($user->google_id)
                                    <span class="badge badge-blue">Google</span>
                                @else
                                    <span class="badge badge-gray">Email</span>
                                @endif
                            </td>
                            <td>
                                @if($user->role === 'buyer')
                                    <div class="cell-primary">{{ $user->orders_count }}</div>
                                    <div class="cell-secondary">{{ $user->selesai_count }} selesai</div>
                                @elseif($user->role === 'seller' && $user->sellerProfile)
                                    <div class="cell-primary">{{ $user->sellerProfile->total_transaksi }}</div>
                                    <div class="cell-secondary">⭐ {{ $user->sellerProfile->rating }}</div>
                                @else
                                    <span style="color:var(--muted)">—</span>
                                @endif
                            </td>
                            <td>
                                @if($user->is_active)
                                    <span class="badge badge-green">Aktif</span>
                                @else
                                    <span class="badge badge-red">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <div class="cell-primary">{{ $user->created_at->format('d M Y') }}</div>
                                <div class="cell-secondary">
                                    {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Belum login' }}
                                </div>
                            </td>
                            {{-- GANTI bagian <td> aksi yang lama dengan ini: --}}
                            <td>
                                <div style="display:flex;gap:5px;flex-wrap:wrap">

                                    {{-- Trigger modal detail --}}
                                    <button type="button" class="action-btn detail" onclick="openDetailModal({{ $user->id }})">
                                        Detail
                                    </button>

                                    {{-- Trigger modal toggle --}}
                                    <button type="button" class="action-btn {{ $user->is_active ? 'nonaktif' : 'aktifkan' }}"
                                        onclick="openToggleModal(
                                                                                                                    {{ $user->id }},
                                                                                                                    '{{ addslashes($user->nama_lengkap) }}',
                                                                                                                    {{ $user->is_active ? 'true' : 'false' }}
                                                                                                                )">
                                        {{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                    </button>

                                    {{-- Trigger modal hapus --}}
                                    <button type="button" class="action-btn hapus" onclick="openHapusModal(
                                                                                                                    {{ $user->id }},
                                                                                                                    '{{ addslashes($user->nama_lengkap) }}'
                                                                                                                )">
                                        Hapus
                                    </button>

                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @if($users->hasPages())
                <div class="pagination-wrap">
                    <div class="pagination-info">Menampilkan {{ $users->firstItem() }}–{{ $users->lastItem() }} dari
                        {{ $users->total() }}
                    </div>
                    <div class="pagination-links">
                        @if($users->onFirstPage())
                            <span class="page-link disabled">‹</span>
                        @else
                            <a href="{{ $users->previousPageUrl() }}" class="page-link">‹</a>
                        @endif
                        @foreach($users->getUrlRange(max(1, $users->currentPage() - 2), min($users->lastPage(), $users->currentPage() + 2)) as $page => $url)
                            <a href="{{ $url }}" class="page-link {{ $page == $users->currentPage() ? 'active' : '' }}">{{ $page }}</a>
                        @endforeach
                        @if($users->hasMorePages())
                            <a href="{{ $users->nextPageUrl() }}" class="page-link">›</a>
                        @else
                            <span class="page-link disabled">›</span>
                        @endif
                    </div>
                </div>
            @endif
        @endif
    </div>

    {{-- ════════════════════════════════════════════
    MODAL: DETAIL PENGGUNA
    ════════════════════════════════════════════ --}}
    <div id="modalDetail" class="modal-backdrop" onclick="if(event.target===this)closeModal('modalDetail')">
        <div class="modal-box" style="max-width:480px">

            <div class="modal-header">
                <div style="display:flex;align-items:center;gap:12px">
                    <div id="detailAvatar" class="modal-avatar"></div>
                    <div>
                        <div id="detailNama" style="font-size:16px;font-weight:800;color:var(--text)"></div>
                        <div id="detailEmail" style="font-size:12px;color:var(--muted);margin-top:2px"></div>
                    </div>
                </div>
                <button class="modal-close" onclick="closeModal('modalDetail')">✕</button>
            </div>

            <div class="modal-body" id="detailBody">
                {{-- Diisi JS --}}
            </div>

            <div class="modal-footer">
                <button class="modal-btn secondary" onclick="closeModal('modalDetail')">Tutup</button>
            </div>

        </div>
    </div>

    {{-- ════════════════════════════════════════════
    MODAL: TOGGLE AKTIF / NONAKTIF
    ════════════════════════════════════════════ --}}
    <div id="modalToggle" class="modal-backdrop" onclick="if(event.target===this)closeModal('modalToggle')">
        <div class="modal-box" style="max-width:380px;text-align:center">

            <div style="margin-bottom:20px">
                <div id="toggleIcon" class="modal-icon-circle"></div>
                <div id="toggleTitle" style="font-size:17px;font-weight:800;color:var(--text);margin-bottom:6px"></div>
                <div id="toggleDesc" style="font-size:13px;color:var(--muted)"></div>
            </div>

            {{-- Form submit PATCH --}}
            <form id="formToggle" method="POST">
                @csrf
                @method('PATCH')
                <div style="display:flex;gap:10px">
                    <button type="button" class="modal-btn secondary" onclick="closeModal('modalToggle')">Batal</button>
                    <button type="submit" id="toggleSubmitBtn" class="modal-btn primary">Konfirmasi</button>
                </div>
            </form>

        </div>
    </div>

    {{-- ════════════════════════════════════════════
    MODAL: HAPUS PENGGUNA
    ════════════════════════════════════════════ --}}
    <div id="modalHapus" class="modal-backdrop" onclick="if(event.target===this)closeModal('modalHapus')">
        <div class="modal-box" style="max-width:380px;text-align:center">

            <div style="margin-bottom:20px">
                <div class="modal-icon-circle" style="background:#fee2e2;margin:0 auto 14px">
                    <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="#e05c5c" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </div>
                <div style="font-size:17px;font-weight:800;color:var(--text);margin-bottom:6px">Hapus Akun?</div>
                <div id="hapusDesc" style="font-size:13px;color:var(--muted)"></div>
                <div
                    style="margin-top:10px;padding:10px 14px;background:#fff5f5;border-radius:10px;font-size:12px;color:#991b1b;font-weight:600">
                    ⚠ Tindakan ini permanen dan tidak dapat dibatalkan.
                </div>
            </div>

            <form id="formHapus" method="POST">
                @csrf
                @method('DELETE')
                <div style="display:flex;gap:10px">
                    <button type="button" class="modal-btn secondary" onclick="closeModal('modalHapus')">Batal</button>
                    <button type="submit" class="modal-btn danger">Ya, Hapus</button>
                </div>
            </form>

        </div>
    </div>

@endsection

@push('scripts')
    <script>
        let _searchTimer;
        function searchDebounce() {
            clearTimeout(_searchTimer);
            _searchTimer = setTimeout(() => document.getElementById('searchForm').submit(), 600);
        }

        // ── Helpers ────────────────────────────────────────────────
        function openModal(id) { document.getElementById(id).classList.add('open'); }
        function closeModal(id) { document.getElementById(id).classList.remove('open'); }

        // Tutup modal dengan tombol Escape
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') {
                ['modalDetail', 'modalToggle', 'modalHapus'].forEach(closeModal);
            }
        });

        // ── MODAL DETAIL ───────────────────────────────────────────
        function openDetailModal(userId) {
            // Reset & tampilkan skeleton loading
            document.getElementById('detailNama').textContent = '...';
            document.getElementById('detailEmail').textContent = '...';
            document.getElementById('detailAvatar').textContent = '';
            document.getElementById('detailBody').innerHTML =
                ['', '', '', '', ''].map(() =>
                    `<div class="detail-row">
                                    <span class="skeleton" style="width:90px"></span>
                                    <span class="skeleton" style="width:130px"></span>
                                </div>`
                ).join('');

            openModal('modalDetail');

            // Fetch data dari controller
            fetch(`/admin/pengguna/${userId}/detail`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
                .then(r => r.json())
                .then(u => {
                    // Header
                    document.getElementById('detailAvatar').textContent =
                        u.nama_lengkap.charAt(0).toUpperCase();
                    document.getElementById('detailNama').textContent = u.nama_lengkap;
                    document.getElementById('detailEmail').textContent = u.email;

                    // Body — rows info
                    const roleBadge = u.role === 'buyer'
                        ? '<span class="badge badge-green">Pembeli</span>'
                        : '<span class="badge badge-orange">Seller</span>';

                    const statusBadge = u.is_active
                        ? '<span class="badge badge-green">Aktif</span>'
                        : '<span class="badge badge-red">Nonaktif</span>';

                    const loginBadge = u.google_id
                        ? '<span class="badge badge-blue">Google</span>'
                        : '<span class="badge badge-gray">Email</span>';

                    let sellerRow = '';
                    if (u.seller_profile) {
                        sellerRow = `
                                    <div class="detail-row">
                                        <span class="detail-key">Nama Toko</span>
                                        <span class="detail-value">${u.seller_profile.nama_toko}</span>
                                    </div>
                                    <div class="detail-row">
                                        <span class="detail-key">Total Transaksi</span>
                                        <span class="detail-value">${u.seller_profile.total_transaksi}</span>
                                    </div>
                                    <div class="detail-row">
                                        <span class="detail-key">Rating</span>
                                        <span class="detail-value">⭐ ${u.seller_profile.rating}</span>
                                    </div>`;
                    } else if (u.role === 'buyer') {
                        sellerRow = `
                                    <div class="detail-row">
                                        <span class="detail-key">Total Order</span>
                                        <span class="detail-value">${u.orders_count} (${u.selesai_count} selesai)</span>
                                    </div>`;
                    }

                    document.getElementById('detailBody').innerHTML = `
                                <div class="detail-row">
                                    <span class="detail-key">Role</span>
                                    <span class="detail-value">${roleBadge}</span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-key">Status</span>
                                    <span class="detail-value">${statusBadge}</span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-key">WhatsApp</span>
                                    <span class="detail-value">${u.no_whatsapp}</span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-key">Login via</span>
                                    <span class="detail-value">${loginBadge}</span>
                                </div>
                                ${sellerRow}
                                <div class="detail-row">
                                    <span class="detail-key">Bergabung</span>
                                    <span class="detail-value">${u.created_at}</span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-key">Login terakhir</span>
                                    <span class="detail-value">${u.last_login_at}</span>
                                </div>`;
                })
                .catch(() => {
                    document.getElementById('detailBody').innerHTML =
                        '<p style="color:var(--danger);text-align:center;padding:20px">Gagal memuat data.</p>';
                });
        }

        // ── MODAL TOGGLE ───────────────────────────────────────────
        function openToggleModal(userId, nama, isActive) {
            const form = document.getElementById('formToggle');
            const icon = document.getElementById('toggleIcon');
            const title = document.getElementById('toggleTitle');
            const desc = document.getElementById('toggleDesc');
            const btn = document.getElementById('toggleSubmitBtn');

            form.action = `/admin/pengguna/${userId}/toggle`;

            if (isActive) {
                icon.style.background = '#fee2e2';
                icon.innerHTML = `<svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="#e05c5c" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                            </svg>`;
                title.textContent = 'Nonaktifkan Akun?';
                desc.textContent = `Akun ${nama} akan dinonaktifkan dan tidak bisa login.`;
                btn.className = 'modal-btn danger';
                btn.textContent = 'Nonaktifkan';
            } else {
                icon.style.background = '#dcfce7';
                icon.innerHTML = `<svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="#166534" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>`;
                title.textContent = 'Aktifkan Akun?';
                desc.textContent = `Akun ${nama} akan diaktifkan kembali.`;
                btn.className = 'modal-btn primary';
                btn.textContent = 'Aktifkan';
            }

            openModal('modalToggle');
        }

        // ── MODAL HAPUS ────────────────────────────────────────────
        function openHapusModal(userId, nama) {
            document.getElementById('formHapus').action = `/admin/pengguna/${userId}`;
            document.getElementById('hapusDesc').textContent =
                `Akun atas nama "${nama}" akan dihapus secara permanen beserta seluruh datanya.`;

            openModal('modalHapus');
        }
    </script>
@endpush