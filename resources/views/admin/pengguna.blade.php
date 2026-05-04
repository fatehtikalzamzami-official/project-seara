{{-- resources/views/admin/pengguna.blade.php --}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Data Pengguna – SEARA Admin</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        *, *::before, *::after { margin:0; padding:0; box-sizing:border-box; }

        :root {
            --sidebar-w-open: 260px;
            --sidebar-w-closed: 72px;
            --bg: #0d1f17;
            --bg2: #132b1e;
            --accent: #3dba7e;
            --accent2: #52dda0;
            --gold: #e8c97e;
            --surface: #ffffff;
            --surface2: #f5f7f6;
            --border: #e8eeeb;
            --text: #1a2e24;
            --muted: #7a9488;
            --danger: #e05c5c;
            --warn: #f59e0b;
            --radius: 20px;
            --sidebar-transition: 0.28s cubic-bezier(0.4,0,0.2,1);
        }

        html, body {
            height: 100%;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--surface2);
            color: var(--text);
            overflow: hidden;
        }

        .layout { display:flex; height:100vh; overflow:hidden; }

        /* ── SIDEBAR (sama persis dengan dashboard) ── */
        .sidebar {
            width: var(--sidebar-w-closed);
            background: var(--bg);
            display: flex;
            flex-direction: column;
            height: 100vh;
            flex-shrink: 0;
            overflow: hidden;
            transition: width var(--sidebar-transition);
            position: relative;
            z-index: 100;
        }

        @media (min-width: 769px) {
            .sidebar:hover { width: var(--sidebar-w-open); }
            .sidebar:hover .nav-label,
            .sidebar:hover .nav-badge,
            .sidebar:hover .brand-text,
            .sidebar:hover .user-info,
            .sidebar:hover .nav-section-label,
            .sidebar:hover .logout-label {
                opacity: 1;
                pointer-events: auto;
                transform: translateX(0);
            }
            .sidebar:not(:hover) .nav-item:hover .tooltip { opacity:1; transform:translateX(0); }
            .sidebar:hover .tooltip { opacity:0 !important; pointer-events:none; }
        }

        .sidebar.mobile-open { width: var(--sidebar-w-open); }

        .sidebar-brand {
            display:flex; align-items:center; gap:12px;
            padding:28px 18px 24px;
            border-bottom:1px solid rgba(255,255,255,0.06);
            overflow:hidden; white-space:nowrap; flex-shrink:0;
        }

        .brand-icon {
            width:36px; height:36px; flex-shrink:0;
            background:linear-gradient(135deg, var(--accent), var(--accent2));
            border-radius:10px; display:flex; align-items:center; justify-content:center;
        }
        .brand-icon svg { width:18px; height:18px; color:#fff; }

        .brand-text {
            overflow:hidden; opacity:0;
            transition:opacity var(--sidebar-transition), transform var(--sidebar-transition);
            transform:translateX(-4px);
        }
        .brand-name { font-size:15px; font-weight:800; color:#fff; letter-spacing:0.5px; white-space:nowrap; }
        .brand-sub  { font-size:10px; font-weight:500; color:rgba(255,255,255,0.35); letter-spacing:1px; text-transform:uppercase; white-space:nowrap; }

        .sidebar-nav { flex:1; padding:16px 10px; overflow-y:auto; overflow-x:hidden; }
        .sidebar-nav::-webkit-scrollbar { width:0; }

        .nav-section-label {
            font-size:9px; font-weight:700; color:rgba(255,255,255,0.2);
            letter-spacing:1.5px; text-transform:uppercase;
            padding:12px 8px 6px; white-space:nowrap; overflow:hidden;
            opacity:0; transition:opacity var(--sidebar-transition);
        }

        .nav-item {
            display:flex; align-items:center; gap:12px;
            padding:10px 8px; border-radius:12px;
            color:rgba(255,255,255,0.45); text-decoration:none;
            font-size:13px; font-weight:600; white-space:nowrap;
            transition:background 0.18s, color 0.18s;
            position:relative; cursor:pointer; margin-bottom:2px; overflow:hidden;
        }
        .nav-item:hover { background:rgba(255,255,255,0.07); color:rgba(255,255,255,0.85); }
        .nav-item.active {
            background:linear-gradient(90deg, rgba(61,186,126,0.22), rgba(61,186,126,0.08));
            color:var(--accent2);
        }
        .nav-item.active::before {
            content:''; position:absolute; left:0; top:20%; bottom:20%;
            width:3px; background:var(--accent); border-radius:0 3px 3px 0;
        }

        .nav-icon {
            width:36px; height:36px; flex-shrink:0; display:flex;
            align-items:center; justify-content:center;
            border-radius:9px; background:rgba(255,255,255,0.05);
            transition:background 0.18s;
        }
        .nav-item.active .nav-icon { background:rgba(61,186,126,0.18); }
        .nav-item:hover .nav-icon  { background:rgba(255,255,255,0.10); }
        .nav-icon svg { width:17px; height:17px; }

        .nav-label {
            flex:1; opacity:0;
            transition:opacity var(--sidebar-transition), transform var(--sidebar-transition);
            transform:translateX(-4px); pointer-events:none;
        }

        .nav-badge {
            font-size:10px; font-weight:800; background:var(--danger); color:#fff;
            padding:1px 7px; border-radius:20px; line-height:18px;
            flex-shrink:0; opacity:0; transition:opacity var(--sidebar-transition);
        }

        .nav-item .tooltip {
            position:absolute; left:58px;
            background:var(--bg2); color:#fff;
            font-size:12px; font-weight:600;
            padding:6px 12px; border-radius:8px; white-space:nowrap;
            pointer-events:none; opacity:0; transform:translateX(-6px);
            transition:opacity 0.15s, transform 0.15s;
            box-shadow:0 4px 16px rgba(0,0,0,0.3); z-index:200;
        }

        .sidebar-footer { padding:10px; border-top:1px solid rgba(255,255,255,0.06); flex-shrink:0; }

        .sidebar-user {
            display:flex; align-items:center; gap:10px;
            padding:10px 8px; border-radius:12px;
            overflow:hidden; white-space:nowrap;
        }

        .user-avatar {
            width:36px; height:36px; flex-shrink:0;
            background:linear-gradient(135deg, var(--accent), #1a6640);
            border-radius:10px; display:flex; align-items:center;
            justify-content:center; font-size:13px; font-weight:800; color:#fff;
        }

        .user-info { overflow:hidden; opacity:0; transition:opacity var(--sidebar-transition); }
        .user-name { font-size:12px; font-weight:700; color:rgba(255,255,255,0.85); white-space:nowrap; }
        .user-role { font-size:10px; color:rgba(255,255,255,0.3); white-space:nowrap; }

        .logout-btn {
            display:flex; align-items:center; gap:12px;
            padding:10px 8px; border-radius:12px;
            color:rgba(255,100,100,0.6);
            font-size:13px; font-weight:600; white-space:nowrap;
            transition:background 0.18s, color 0.18s;
            cursor:pointer; background:none; border:none; width:100%;
            font-family:'Plus Jakarta Sans',sans-serif;
            margin-top:4px; overflow:hidden;
        }
        .logout-btn:hover { background:rgba(224,92,92,0.12); color:var(--danger); }
        .logout-btn .nav-icon { background:rgba(224,92,92,0.08); }
        .logout-btn:hover .nav-icon { background:rgba(224,92,92,0.18); }

        .logout-label { opacity:0; transition:opacity var(--sidebar-transition); white-space:nowrap; }
        .sidebar:hover .logout-label { opacity:1; }

        /* ── MAIN ── */
        .main { flex:1; display:flex; flex-direction:column; overflow:hidden; }

        .topbar {
            padding:20px 32px 16px;
            display:flex; align-items:center; gap:16px; flex-shrink:0;
        }

        .search-wrap {
            flex:1; max-width:480px;
            display:flex; align-items:center; gap:10px;
            background:var(--surface); border:1.5px solid var(--border);
            border-radius:12px; padding:10px 16px;
            transition:border-color 0.2s, box-shadow 0.2s;
        }
        .search-wrap:focus-within { border-color:var(--accent); box-shadow:0 0 0 3px rgba(61,186,126,0.12); }
        .search-wrap svg { width:16px; height:16px; color:var(--muted); flex-shrink:0; }
        .search-wrap input { border:none; outline:none; background:transparent; font-family:inherit; font-size:13px; color:var(--text); width:100%; }
        .search-wrap input::placeholder { color:var(--muted); }

        .topbar-right { display:flex; align-items:center; gap:10px; margin-left:auto; }

        .icon-btn {
            width:40px; height:40px; background:var(--surface);
            border:1.5px solid var(--border); border-radius:11px;
            display:flex; align-items:center; justify-content:center;
            cursor:pointer; transition:all 0.2s; position:relative;
        }
        .icon-btn:hover { border-color:var(--accent); box-shadow:0 0 0 3px rgba(61,186,126,0.1); }
        .icon-btn svg { width:17px; height:17px; color:var(--muted); }

        .notif-dot { position:absolute; top:6px; right:6px; width:8px; height:8px; background:var(--danger); border-radius:50%; border:2px solid var(--surface); }

        .profile-chip {
            display:flex; align-items:center; gap:10px;
            background:var(--surface); border:1.5px solid var(--border);
            border-radius:12px; padding:7px 14px 7px 8px; cursor:pointer;
        }
        .profile-ava {
            width:30px; height:30px;
            background:linear-gradient(135deg, var(--accent), #1a6640);
            border-radius:8px; display:flex; align-items:center; justify-content:center;
            font-size:12px; font-weight:800; color:#fff;
        }
        .profile-name { font-size:13px; font-weight:700; color:var(--text); }
        .profile-role { font-size:10px; color:var(--muted); }

        /* ── CONTENT ── */
        .content { flex:1; overflow-y:auto; padding:0 32px 32px; }
        .content::-webkit-scrollbar { width:5px; }
        .content::-webkit-scrollbar-thumb { background:var(--border); border-radius:10px; }

        .page-header { margin-bottom:24px; }
        .page-title { font-size:26px; font-weight:800; color:var(--text); letter-spacing:-0.5px; }
        .page-sub { font-size:13px; color:var(--muted); margin-top:4px; }

        /* Stats */
        .stats-grid {
            display:grid; grid-template-columns:repeat(5,1fr);
            gap:14px; margin-bottom:20px;
        }

        .stat-card {
            background:var(--surface); border:1.5px solid var(--border);
            border-radius:16px; padding:18px 16px;
            transition:box-shadow 0.2s, transform 0.2s;
        }
        .stat-card:hover { box-shadow:0 8px 24px rgba(0,0,0,0.07); transform:translateY(-2px); }

        .stat-card-label { font-size:11px; font-weight:700; color:var(--muted); text-transform:uppercase; letter-spacing:0.5px; margin-bottom:8px; }
        .stat-card-num   { font-size:24px; font-weight:800; color:var(--text); line-height:1; }
        .stat-card-sub   { font-size:11px; color:var(--muted); margin-top:4px; }

        /* Filter bar */
        .filter-bar {
            display:flex; align-items:center; gap:10px;
            margin-bottom:16px; flex-wrap:wrap;
        }

        .filter-select {
            padding:9px 14px; border:1.5px solid var(--border);
            border-radius:10px; font-family:inherit; font-size:13px;
            color:var(--text); background:var(--surface); cursor:pointer;
            outline:none; transition:border-color 0.2s;
        }
        .filter-select:focus { border-color:var(--accent); }

        .btn-filter {
            padding:9px 18px; border-radius:10px;
            border:none; background:var(--accent);
            color:#fff; font-family:inherit; font-size:13px;
            font-weight:700; cursor:pointer;
            transition:background 0.2s;
        }
        .btn-filter:hover { background:var(--accent2); }

        .btn-reset {
            padding:9px 14px; border-radius:10px;
            border:1.5px solid var(--border); background:var(--surface);
            color:var(--muted); font-family:inherit; font-size:13px;
            font-weight:600; cursor:pointer; transition:all 0.2s; text-decoration:none;
            display:inline-flex; align-items:center;
        }
        .btn-reset:hover { border-color:var(--accent); color:var(--text); }

        /* Table section */
        .section {
            background:var(--surface); border:1.5px solid var(--border);
            border-radius:var(--radius); padding:24px;
        }

        .section-head {
            display:flex; align-items:center; justify-content:space-between;
            margin-bottom:18px;
        }

        .section-title { font-size:16px; font-weight:800; color:var(--text); }
        .section-count { font-size:13px; color:var(--muted); font-weight:500; }

        .data-table { width:100%; border-collapse:collapse; }

        .data-table th {
            text-align:left; font-size:11px; font-weight:700;
            color:var(--muted); letter-spacing:0.5px; text-transform:uppercase;
            padding:0 14px 14px;
        }

        .data-table td {
            padding:14px; font-size:13px; font-weight:500;
            color:var(--text); border-top:1px solid var(--border);
        }

        .data-table tbody tr { transition:background 0.15s; }
        .data-table tbody tr:hover { background:var(--surface2); }

        .cell-primary { font-weight:700; color:var(--text); }
        .cell-secondary { font-size:11px; color:var(--muted); margin-top:2px; }

        .avatar-circle {
            width:36px; height:36px; border-radius:10px;
            background:linear-gradient(135deg, var(--accent), #1a6640);
            display:flex; align-items:center; justify-content:center;
            font-size:13px; font-weight:800; color:#fff; flex-shrink:0;
        }

        .user-cell { display:flex; align-items:center; gap:12px; }

        .badge {
            display:inline-flex; align-items:center;
            padding:3px 10px; border-radius:20px;
            font-size:11px; font-weight:700;
        }
        .badge-green  { background:#dcfce7; color:#166534; }
        .badge-red    { background:#fee2e2; color:#991b1b; }
        .badge-gray   { background:#f1f5f9; color:#475569; }
        .badge-blue   { background:#dbeafe; color:#1e40af; }

        .action-btn {
            padding:6px 12px; border-radius:8px; border:none;
            font-family:inherit; font-size:11px; font-weight:700;
            cursor:pointer; transition:all 0.18s; text-decoration:none;
            display:inline-flex; align-items:center;
        }

        .action-btn.detail { background:#f1f5f9; color:#475569; }
        .action-btn.detail:hover { background:#e2e8f0; color:var(--text); }

        .action-btn.nonaktif { background:#fee2e2; color:#991b1b; }
        .action-btn.nonaktif:hover { background:#fca5a5; }

        .action-btn.aktifkan { background:#dcfce7; color:#166534; }
        .action-btn.aktifkan:hover { background:#bbf7d0; }

        .action-btn.hapus { background:#fff1f2; color:#be123c; }
        .action-btn.hapus:hover { background:#ffe4e6; }

        /* Pagination */
        .pagination-wrap {
            display:flex; align-items:center; justify-content:space-between;
            margin-top:20px; padding-top:16px;
            border-top:1px solid var(--border);
        }

        .pagination-info { font-size:13px; color:var(--muted); }

        .pagination-links { display:flex; gap:6px; }

        .page-link {
            width:34px; height:34px; border-radius:9px;
            border:1.5px solid var(--border); background:var(--surface);
            display:flex; align-items:center; justify-content:center;
            font-size:13px; font-weight:600; color:var(--text);
            text-decoration:none; transition:all 0.18s; cursor:pointer;
        }
        .page-link:hover    { border-color:var(--accent); color:var(--accent); }
        .page-link.active   { background:var(--accent); border-color:var(--accent); color:#fff; }
        .page-link.disabled { opacity:0.35; pointer-events:none; }

        /* Empty state */
        .empty-state {
            text-align:center; padding:60px 20px;
        }
        .empty-icon { font-size:48px; margin-bottom:12px; }
        .empty-title { font-size:16px; font-weight:700; color:var(--text); margin-bottom:6px; }
        .empty-sub   { font-size:13px; color:var(--muted); }

        /* Alert */
        .alert {
            padding:12px 18px; border-radius:12px;
            margin-bottom:16px; font-size:13px; font-weight:600;
        }
        .alert-success { background:#dcfce7; color:#166534; }
        .alert-error   { background:#fee2e2; color:#991b1b; }

        /* Overlay */
        .overlay { display:none; position:fixed; inset:0; background:rgba(0,0,0,0.45); z-index:50; }

        @media (max-width: 1024px) { .stats-grid { grid-template-columns:repeat(3,1fr); } }

        @media (max-width: 768px) {
            .sidebar { position:fixed; left:0; top:0; bottom:0; z-index:100; width:0; overflow:hidden; }
            .sidebar.mobile-open { width:var(--sidebar-w-open); }
            .sidebar.mobile-open .nav-label,
            .sidebar.mobile-open .nav-badge,
            .sidebar.mobile-open .brand-text,
            .sidebar.mobile-open .user-info,
            .sidebar.mobile-open .nav-section-label,
            .sidebar.mobile-open .logout-label {
                opacity:1; pointer-events:auto; transform:translateX(0);
            }
            .overlay.show { display:block; }
            .stats-grid { grid-template-columns:1fr 1fr; }
            .topbar { padding:16px 16px 12px; }
            .content { padding:0 16px 24px; }
        }

        ::-webkit-scrollbar { width:5px; }
        ::-webkit-scrollbar-thumb { background:var(--border); border-radius:10px; }
    </style>
</head>

<body>

    <div class="overlay" id="overlay" onclick="closeSidebar()"></div>

    <div class="layout">

        {{-- ── SIDEBAR ── --}}
        <aside class="sidebar" id="sidebar">

            <div class="sidebar-brand">
                <div class="brand-icon">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10 10-4.5 10-10S17.5 2 12 2zM7 13l3 3 7-7" />
                    </svg>
                </div>
                <div class="brand-text">
                    <div class="brand-name">SEARA Admin</div>
                    <div class="brand-sub">Panel Pengelola</div>
                </div>
            </div>

            <nav class="sidebar-nav">

                <div class="nav-section-label">UTAMA</div>

                <a href="{{ route('admin.dashboard') }}" class="nav-item">
                    <div class="nav-icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                    </div>
                    <span class="nav-label">Dashboard</span>
                    <span class="tooltip">Dashboard</span>
                </a>

                <div class="nav-section-label">MANAJEMEN PENGGUNA</div>

                {{-- AKTIF: Data Pengguna --}}
                <a href="{{ route('admin.pengguna') }}" class="nav-item active">
                    <div class="nav-icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <span class="nav-label">Data Pengguna</span>
                    <span class="tooltip">Data Pengguna</span>
                </a>

                <a href="{{ route('admin.users') }}" class="nav-item">
                    <div class="nav-icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <span class="nav-label">Data Pembeli</span>
                    <span class="tooltip">Data Pembeli</span>
                </a>

                <a href="{{ route('admin.sellers') }}" class="nav-item">
                    <div class="nav-icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="nav-label">Data Seller</span>
                    <span class="tooltip">Data Seller</span>
                </a>

                <a href="{{ route('admin.verifikasi') }}" class="nav-item">
                    <div class="nav-icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <span class="nav-label">Pengajuan Seller</span>
                    <span class="tooltip">Pengajuan Seller</span>
                </a>

                <div class="nav-section-label">MODERASI</div>

                <a href="{{ route('admin.laporan') }}" class="nav-item">
                    <div class="nav-icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <span class="nav-label">Laporan Aktif</span>
                    <div class="nav-badge">24</div>
                    <span class="tooltip">Laporan Aktif</span>
                </a>

            </nav>

            <div class="sidebar-footer">
                <div class="sidebar-user">
                    <div class="user-avatar">
                        {{ strtoupper(substr(Auth::user()->nama_lengkap ?? 'A', 0, 1)) }}
                    </div>
                    <div class="user-info">
                        <div class="user-name">{{ Auth::user()->nama_lengkap ?? 'Admin' }}</div>
                        <div class="user-role">Administrator</div>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" id="adminLogoutForm">
                    @csrf
                    <button type="button" class="logout-btn" onclick="confirmAdminLogout()">
                        <div class="nav-icon">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </div>
                        <span class="logout-label">Keluar</span>
                    </button>
                </form>
            </div>

        </aside>

        {{-- ── MAIN ── --}}
        <div class="main">

            <div class="topbar">
                <button class="icon-btn" id="mobileMenuBtn" onclick="openSidebar()" style="display:none">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                {{-- Search terintegrasi langsung dengan form filter --}}
                <form method="GET" action="{{ route('admin.pengguna') }}" id="filterForm"
                      style="flex:1;max-width:480px;">
                    <div class="search-wrap">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="8"/>
                            <path stroke-linecap="round" d="m21 21-4.35-4.35"/>
                        </svg>
                        <input type="text" name="search" placeholder="Cari nama, email, atau WhatsApp..."
                               value="{{ request('search') }}"
                               oninput="debounceSearch(this)">
                    </div>
                </form>

                <div class="topbar-right">
                    <div class="icon-btn">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <div class="notif-dot"></div>
                    </div>
                    <div class="profile-chip">
                        <div class="profile-ava">
                            {{ strtoupper(substr(Auth::user()->nama_lengkap ?? 'A', 0, 1)) }}
                        </div>
                        <div>
                            <div class="profile-name">{{ Auth::user()->nama_lengkap ?? 'Admin' }}</div>
                            <div class="profile-role">Administrator</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── CONTENT ── --}}
            <div class="content">

                <div class="page-header">
                    <h1 class="page-title">Data Pengguna Umum</h1>
                    <p class="page-sub">Kelola seluruh pengguna dengan role <strong>buyer</strong> yang terdaftar di platform SEARA.</p>
                </div>

                {{-- Flash messages --}}
                @if (session('success'))
                    <div class="alert alert-success">✓ {{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="alert alert-error">✕ {{ session('error') }}</div>
                @endif

                {{-- Stats --}}
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-card-label">Total Pengguna</div>
                        <div class="stat-card-num">{{ number_format($stats['total']) }}</div>
                        <div class="stat-card-sub">Semua pengguna terdaftar</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-card-label">Aktif</div>
                        <div class="stat-card-num" style="color:var(--accent)">{{ number_format($stats['aktif']) }}</div>
                        <div class="stat-card-sub">Akun tidak diblokir</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-card-label">Nonaktif</div>
                        <div class="stat-card-num" style="color:var(--danger)">{{ number_format($stats['nonaktif']) }}</div>
                        <div class="stat-card-sub">Akun diblokir / suspended</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-card-label">Login Google</div>
                        <div class="stat-card-num" style="color:#3b82f6">{{ number_format($stats['google']) }}</div>
                        <div class="stat-card-sub">Menggunakan OAuth</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-card-label">Baru Bulan Ini</div>
                        <div class="stat-card-num" style="color:var(--gold)">{{ number_format($stats['baru_bulan_ini']) }}</div>
                        <div class="stat-card-sub">{{ now()->translatedFormat('F Y') }}</div>
                    </div>
                </div>

                {{-- Filter bar --}}
                <form method="GET" action="{{ route('admin.pengguna') }}" class="filter-bar">
                    <input type="hidden" name="search" value="{{ request('search') }}">

                    <select name="status" class="filter-select" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="aktif"    {{ request('status') === 'aktif'    ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ request('status') === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>

                    <select name="login_method" class="filter-select" onchange="this.form.submit()">
                        <option value="">Semua Metode Login</option>
                        <option value="email"  {{ request('login_method') === 'email'  ? 'selected' : '' }}>Email & Password</option>
                        <option value="google" {{ request('login_method') === 'google' ? 'selected' : '' }}>Google OAuth</option>
                    </select>

                    <select name="sort" class="filter-select" onchange="this.form.submit()">
                        <option value="terbaru"   {{ request('sort','terbaru') === 'terbaru'   ? 'selected' : '' }}>Terbaru</option>
                        <option value="terlama"   {{ request('sort') === 'terlama'   ? 'selected' : '' }}>Terlama</option>
                        <option value="nama_az"   {{ request('sort') === 'nama_az'   ? 'selected' : '' }}>Nama A–Z</option>
                        <option value="nama_za"   {{ request('sort') === 'nama_za'   ? 'selected' : '' }}>Nama Z–A</option>
                        <option value="transaksi" {{ request('sort') === 'transaksi' ? 'selected' : '' }}>Transaksi Terbanyak</option>
                    </select>

                    @if(request()->hasAny(['search','status','login_method','sort']))
                        <a href="{{ route('admin.pengguna') }}" class="btn-reset">Reset</a>
                    @endif
                </form>

                {{-- Table --}}
                <div class="section">
                    <div class="section-head">
                        <span class="section-title">Daftar Pengguna</span>
                        <span class="section-count">
                            {{ $users->total() }} pengguna ditemukan
                            @if(request('search'))
                                · kata kunci: "<strong>{{ request('search') }}</strong>"
                            @endif
                        </span>
                    </div>

                    @if ($users->isEmpty())
                        <div class="empty-state">
                            <div class="empty-icon">👤</div>
                            <div class="empty-title">Tidak ada pengguna ditemukan</div>
                            <div class="empty-sub">Coba ubah filter atau kata kunci pencarian.</div>
                        </div>
                    @else
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Pengguna</th>
                                    <th>WhatsApp</th>
                                    <th>Login</th>
                                    <th>Transaksi</th>
                                    <th>Status</th>
                                    <th>Bergabung</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>
                                            <div class="user-cell">
                                                <div class="avatar-circle">
                                                    @if($user->avatar)
                                                        <img src="{{ $user->avatar }}" style="width:100%;height:100%;object-fit:cover;border-radius:10px;" alt="">
                                                    @else
                                                        {{ strtoupper(substr($user->nama_lengkap, 0, 1)) }}
                                                    @endif
                                                </div>
                                                <div>
                                                    <div class="cell-primary">{{ $user->nama_lengkap }}</div>
                                                    <div class="cell-secondary">{{ $user->email }}</div>
                                                </div>
                                            </div>
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
                                            <div class="cell-primary">{{ $user->orders_count }}</div>
                                            <div class="cell-secondary">{{ $user->selesai_count }} selesai</div>
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
                                                {{ $user->last_login_at ? 'Login ' . $user->last_login_at->diffForHumans() : 'Belum pernah login' }}
                                            </div>
                                        </td>
                                        <td>
                                            <div style="display:flex;gap:6px;flex-wrap:wrap;">
                                                {{-- Detail --}}
                                                <a href="{{ route('admin.pengguna.show', $user) }}"
                                                   class="action-btn detail">Detail</a>

                                                {{-- Toggle Status --}}
                                                <form method="POST"
                                                      action="{{ route('admin.pengguna.toggle', $user) }}"
                                                      onsubmit="return confirm('{{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }} akun ini?')">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"
                                                            class="action-btn {{ $user->is_active ? 'nonaktif' : 'aktifkan' }}">
                                                        {{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                                    </button>
                                                </form>

                                                {{-- Hapus --}}
                                                <form method="POST"
                                                      action="{{ route('admin.pengguna.destroy', $user) }}"
                                                      onsubmit="return confirm('Hapus akun {{ addslashes($user->nama_lengkap) }}? Aksi ini tidak dapat dibatalkan.')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="action-btn hapus">Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{-- Pagination --}}
                        @if ($users->hasPages())
                            <div class="pagination-wrap">
                                <div class="pagination-info">
                                    Menampilkan {{ $users->firstItem() }}–{{ $users->lastItem() }}
                                    dari {{ $users->total() }} pengguna
                                </div>
                                <div class="pagination-links">
                                    {{-- Prev --}}
                                    @if ($users->onFirstPage())
                                        <span class="page-link disabled">‹</span>
                                    @else
                                        <a href="{{ $users->previousPageUrl() }}" class="page-link">‹</a>
                                    @endif

                                    {{-- Pages --}}
                                    @foreach ($users->getUrlRange(max(1,$users->currentPage()-2), min($users->lastPage(),$users->currentPage()+2)) as $page => $url)
                                        <a href="{{ $url }}"
                                           class="page-link {{ $page == $users->currentPage() ? 'active' : '' }}">
                                            {{ $page }}
                                        </a>
                                    @endforeach

                                    {{-- Next --}}
                                    @if ($users->hasMorePages())
                                        <a href="{{ $users->nextPageUrl() }}" class="page-link">›</a>
                                    @else
                                        <span class="page-link disabled">›</span>
                                    @endif
                                </div>
                            </div>
                        @endif
                    @endif
                </div>

            </div>
        </div>

        {{-- Modal Logout --}}
        <div id="logoutModal" style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(0,0,0,0.5);backdrop-filter:blur(4px);align-items:center;justify-content:center;">
            <div style="background:#fff;border-radius:20px;padding:32px 28px;width:100%;max-width:360px;margin:16px;box-shadow:0 20px 60px rgba(0,0,0,0.2);">
                <div style="text-align:center;margin-bottom:20px;">
                    <div style="width:56px;height:56px;background:#fee2e2;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 14px;">
                        <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="#e05c5c" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </div>
                    <div style="font-size:17px;font-weight:800;color:#1a2e24;margin-bottom:6px;">Keluar dari Panel Admin?</div>
                    <div style="font-size:13px;color:#7a9488;">Sesi Anda akan diakhiri.</div>
                </div>
                <div style="display:flex;gap:10px;">
                    <button onclick="closeLogoutModal()" style="flex:1;padding:11px;border-radius:12px;border:1.5px solid #e8eeeb;background:#fff;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:#7a9488;cursor:pointer;">Batal</button>
                    <button onclick="document.getElementById('adminLogoutForm').submit()" style="flex:1;padding:11px;border-radius:12px;border:none;background:#e05c5c;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:#fff;cursor:pointer;">Ya, Keluar</button>
                </div>
            </div>
        </div>

    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');

        function openSidebar()  { sidebar.classList.add('mobile-open');    overlay.classList.add('show'); }
        function closeSidebar() { sidebar.classList.remove('mobile-open'); overlay.classList.remove('show'); }

        function handleResize() {
            const isMobile = window.innerWidth <= 768;
            document.getElementById('mobileMenuBtn').style.display = isMobile ? 'flex' : 'none';
            if (!isMobile) { sidebar.classList.remove('mobile-open'); overlay.classList.remove('show'); }
        }

        handleResize();
        window.addEventListener('resize', handleResize);

        // Debounce search — submit form 600ms setelah berhenti mengetik
        let searchTimer;
        function debounceSearch(input) {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(() => {
                document.getElementById('filterForm').submit();
            }, 600);
        }

        function confirmAdminLogout() { document.getElementById('logoutModal').style.display = 'flex'; }
        function closeLogoutModal()   { document.getElementById('logoutModal').style.display = 'none'; }

        document.getElementById('logoutModal').addEventListener('click', function(e) {
            if (e.target === this) closeLogoutModal();
        });
    </script>

</body>
</html>