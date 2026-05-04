{{-- resources/views/admin/dashboard.blade.php --}}
@php
    $stats = [
        'petani' => '1.782',
        'pembeli' => '12.321',
        'transaksi' => '8.540',
        'laporan' => '24',
    ];

    $laporans = [
        ['judul' => 'Indikasi Spam', 'deskripsi' => 'Akun petani melakukan manipulasi ulasan berkali-kali'],
        ['judul' => 'Pelaporan Barang Rusak', 'deskripsi' => 'Pembeli (PN2-160804-1) melaporkan barang rusak saat tiba'],
    ];

    $verifikasis = [
        ['nama_toko' => 'Sayur Segar', 'nama_pemilik' => 'Pak Sutarno', 'tanggal' => '30 April 2026', 'status_dokumen' => 'Lengkap', 'status_akun' => 'Menunggu Persetujuan'],
        ['nama_toko' => 'Tomat Pak', 'nama_pemilik' => 'Somat', 'tanggal' => '30 April 2026', 'status_dokumen' => 'Lengkap', 'status_akun' => 'Menunggu Persetujuan'],
        ['nama_toko' => 'Pak Sholeh', 'nama_pemilik' => 'Beras Pilihan', 'tanggal' => '29 April 2026', 'status_dokumen' => 'Kurang', 'status_akun' => 'Menunggu Persetujuan'],
    ];
@endphp

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard Admin – SEARA</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>

    <style>
        *,
        *::before,
        *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --sidebar-w-open: 260px;
            --sidebar-w-closed: 76px;
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
            --sidebar-transition: 0.32s cubic-bezier(0.4, 0, 0.2, 1);
        }

        html,
        body {
            height: 100%;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--surface2);
            color: var(--text);
            overflow: hidden;
        }

        /* ── LAYOUT ── */
        .layout {
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        /* ── SIDEBAR ── */
        .sidebar {
            width: var(--sidebar-w-open);
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

        .sidebar.closed {
            width: var(--sidebar-w-closed);
        }

        /* Brand */
        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 28px 20px 24px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            overflow: hidden;
            white-space: nowrap;
            flex-shrink: 0;
        }

        .brand-icon {
            width: 36px;
            height: 36px;
            flex-shrink: 0;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .brand-icon svg {
            width: 18px;
            height: 18px;
            color: #fff;
        }

        .brand-text {
            overflow: hidden;
        }

        .brand-name {
            font-size: 15px;
            font-weight: 800;
            color: #fff;
            letter-spacing: 0.5px;
            white-space: nowrap;
        }

        .brand-sub {
            font-size: 10px;
            font-weight: 500;
            color: rgba(255, 255, 255, 0.35);
            letter-spacing: 1px;
            text-transform: uppercase;
            white-space: nowrap;
        }

        /* Toggle button */
        .sidebar-toggle {
            position: absolute;
            top: 26px;
            right: -14px;
            width: 28px;
            height: 28px;
            background: var(--accent);
            border-radius: 50%;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 12px rgba(61, 186, 126, 0.4);
            transition: background 0.2s, transform 0.32s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 10;
        }

        .sidebar-toggle:hover {
            background: var(--accent2);
        }

        .sidebar-toggle svg {
            width: 14px;
            height: 14px;
            color: #fff;
            transition: transform var(--sidebar-transition);
        }

        .sidebar.closed .sidebar-toggle svg {
            transform: rotate(180deg);
        }

        /* Nav */
        .sidebar-nav {
            flex: 1;
            padding: 16px 12px;
            overflow-y: auto;
            overflow-x: hidden;
        }

        .sidebar-nav::-webkit-scrollbar {
            width: 0;
        }

        .nav-section-label {
            font-size: 9px;
            font-weight: 700;
            color: rgba(255, 255, 255, 0.2);
            letter-spacing: 1.5px;
            text-transform: uppercase;
            padding: 12px 8px 6px;
            white-space: nowrap;
            overflow: hidden;
            transition: opacity var(--sidebar-transition);
        }

        .sidebar.closed .nav-section-label {
            opacity: 0;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 12px;
            border-radius: 12px;
            color: rgba(255, 255, 255, 0.45);
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            white-space: nowrap;
            transition: background 0.18s, color 0.18s;
            position: relative;
            cursor: pointer;
            margin-bottom: 2px;
            overflow: hidden;
        }

        .nav-item:hover {
            background: rgba(255, 255, 255, 0.07);
            color: rgba(255, 255, 255, 0.85);
        }

        .nav-item.active {
            background: linear-gradient(90deg, rgba(61, 186, 126, 0.22), rgba(61, 186, 126, 0.08));
            color: var(--accent2);
        }

        .nav-item.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 20%;
            bottom: 20%;
            width: 3px;
            background: var(--accent);
            border-radius: 0 3px 3px 0;
        }

        .nav-icon {
            width: 36px;
            height: 36px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 9px;
            background: rgba(255, 255, 255, 0.05);
            transition: background 0.18s;
        }

        .nav-item.active .nav-icon {
            background: rgba(61, 186, 126, 0.18);
        }

        .nav-item:hover .nav-icon {
            background: rgba(255, 255, 255, 0.10);
        }

        .nav-icon svg {
            width: 17px;
            height: 17px;
        }

        .nav-label {
            flex: 1;
            transition: opacity var(--sidebar-transition), transform var(--sidebar-transition);
        }

        .sidebar.closed .nav-label {
            opacity: 0;
            pointer-events: none;
        }

        /* Badge */
        .nav-badge {
            font-size: 10px;
            font-weight: 800;
            background: var(--danger);
            color: #fff;
            padding: 1px 7px;
            border-radius: 20px;
            line-height: 18px;
            flex-shrink: 0;
            transition: opacity var(--sidebar-transition);
        }

        .sidebar.closed .nav-badge {
            opacity: 0;
        }

        /* Tooltip on closed */
        .nav-item .tooltip {
            position: absolute;
            left: 72px;
            background: var(--bg2);
            color: #fff;
            font-size: 12px;
            font-weight: 600;
            padding: 6px 12px;
            border-radius: 8px;
            white-space: nowrap;
            pointer-events: none;
            opacity: 0;
            transform: translateX(-6px);
            transition: opacity 0.15s, transform 0.15s;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.3);
            z-index: 200;
        }

        .sidebar.closed .nav-item:hover .tooltip {
            opacity: 1;
            transform: translateX(0);
        }

        /* Sidebar footer */
        .sidebar-footer {
            padding: 12px;
            border-top: 1px solid rgba(255, 255, 255, 0.06);
            flex-shrink: 0;
        }

        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 10px;
            border-radius: 12px;
            overflow: hidden;
            white-space: nowrap;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            flex-shrink: 0;
            background: linear-gradient(135deg, var(--accent), #1a6640);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 800;
            color: #fff;
        }

        .user-info {
            overflow: hidden;
            transition: opacity var(--sidebar-transition);
        }

        .sidebar.closed .user-info {
            opacity: 0;
        }

        .user-name {
            font-size: 12px;
            font-weight: 700;
            color: rgba(255, 255, 255, 0.85);
            white-space: nowrap;
        }

        .user-role {
            font-size: 10px;
            color: rgba(255, 255, 255, 0.3);
            white-space: nowrap;
        }

        /* Logout button */
        .logout-btn {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 12px;
            border-radius: 12px;
            color: rgba(255, 100, 100, 0.6);
            font-size: 13px;
            font-weight: 600;
            white-space: nowrap;
            transition: background 0.18s, color 0.18s;
            cursor: pointer;
            background: none;
            border: none;
            width: 100%;
            font-family: 'Plus Jakarta Sans', sans-serif;
            margin-top: 4px;
            overflow: hidden;
        }

        .logout-btn:hover {
            background: rgba(224, 92, 92, 0.12);
            color: var(--danger);
        }

        .logout-btn .nav-icon {
            background: rgba(224, 92, 92, 0.08);
        }

        .logout-btn:hover .nav-icon {
            background: rgba(224, 92, 92, 0.18);
        }

        /* ── MAIN ── */
        .main {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        /* Topbar */
        .topbar {
            padding: 20px 32px 16px;
            display: flex;
            align-items: center;
            gap: 16px;
            flex-shrink: 0;
        }

        .search-wrap {
            flex: 1;
            max-width: 480px;
            display: flex;
            align-items: center;
            gap: 10px;
            background: var(--surface);
            border: 1.5px solid var(--border);
            border-radius: 12px;
            padding: 10px 16px;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .search-wrap:focus-within {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(61, 186, 126, 0.12);
        }

        .search-wrap svg {
            width: 16px;
            height: 16px;
            color: var(--muted);
            flex-shrink: 0;
        }

        .search-wrap input {
            border: none;
            outline: none;
            background: transparent;
            font-family: inherit;
            font-size: 13px;
            color: var(--text);
            width: 100%;
        }

        .search-wrap input::placeholder {
            color: var(--muted);
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-left: auto;
        }

        .icon-btn {
            width: 40px;
            height: 40px;
            background: var(--surface);
            border: 1.5px solid var(--border);
            border-radius: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
            position: relative;
        }

        .icon-btn:hover {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(61, 186, 126, 0.1);
        }

        .icon-btn svg {
            width: 17px;
            height: 17px;
            color: var(--muted);
        }

        .notif-dot {
            position: absolute;
            top: 6px;
            right: 6px;
            width: 8px;
            height: 8px;
            background: var(--danger);
            border-radius: 50%;
            border: 2px solid var(--surface);
        }

        .profile-chip {
            display: flex;
            align-items: center;
            gap: 10px;
            background: var(--surface);
            border: 1.5px solid var(--border);
            border-radius: 12px;
            padding: 7px 14px 7px 8px;
            cursor: pointer;
        }

        .profile-ava {
            width: 30px;
            height: 30px;
            background: linear-gradient(135deg, var(--accent), #1a6640);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 800;
            color: #fff;
        }

        .profile-name {
            font-size: 13px;
            font-weight: 700;
            color: var(--text);
        }

        .profile-role {
            font-size: 10px;
            color: var(--muted);
        }

        /* Content */
        .content {
            flex: 1;
            overflow-y: auto;
            padding: 0 32px 32px;
        }

        .content::-webkit-scrollbar {
            width: 5px;
        }

        .content::-webkit-scrollbar-thumb {
            background: var(--border);
            border-radius: 10px;
        }

        .page-header {
            margin-bottom: 28px;
        }

        .page-title {
            font-size: 26px;
            font-weight: 800;
            color: var(--text);
            letter-spacing: -0.5px;
        }

        .page-sub {
            font-size: 13px;
            color: var(--muted);
            margin-top: 4px;
        }

        /* Stats grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: var(--surface);
            border: 1.5px solid var(--border);
            border-radius: var(--radius);
            padding: 22px 20px;
            display: flex;
            flex-direction: column;
            gap: 14px;
            transition: box-shadow 0.2s, transform 0.2s;
        }

        .stat-card:hover {
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.07);
            transform: translateY(-2px);
        }

        .stat-card.dark {
            background: var(--bg);
            border-color: transparent;
        }

        .stat-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
        }

        .stat-icon {
            width: 40px;
            height: 40px;
            border-radius: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .stat-icon svg {
            width: 19px;
            height: 19px;
        }

        .stat-icon.green {
            background: rgba(61, 186, 126, 0.12);
            color: var(--accent);
        }

        .stat-icon.gold {
            background: rgba(232, 201, 126, 0.15);
            color: var(--gold);
        }

        .stat-icon.red {
            background: rgba(224, 92, 92, 0.12);
            color: var(--danger);
        }

        .stat-icon.blue {
            background: rgba(96, 165, 250, 0.12);
            color: #60a5fa;
        }

        .stat-icon.white {
            background: rgba(255, 255, 255, 0.10);
            color: #fff;
        }

        .stat-num {
            font-size: 28px;
            font-weight: 800;
            line-height: 1;
        }

        .stat-card.dark .stat-num {
            color: #fff;
        }

        .stat-label {
            font-size: 12px;
            font-weight: 600;
            color: var(--muted);
        }

        .stat-card.dark .stat-label {
            color: rgba(255, 255, 255, 0.4);
        }

        .stat-pill {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: rgba(61, 186, 126, 0.1);
            color: var(--accent);
            font-size: 11px;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 20px;
            width: fit-content;
        }

        .stat-card.dark .stat-pill {
            background: rgba(255, 255, 255, 0.08);
            color: var(--accent2);
        }

        /* Section */
        .section {
            background: var(--surface);
            border: 1.5px solid var(--border);
            border-radius: var(--radius);
            padding: 24px;
            margin-bottom: 20px;
        }

        .section-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .section-title-wrap {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-icon {
            width: 34px;
            height: 34px;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .section-icon.red {
            background: rgba(224, 92, 92, 0.1);
            color: var(--danger);
        }

        .section-icon svg {
            width: 17px;
            height: 17px;
        }

        .section-title {
            font-size: 16px;
            font-weight: 800;
            color: var(--text);
        }

        .section-link {
            font-size: 12px;
            font-weight: 700;
            color: var(--accent);
            text-decoration: none;
        }

        .section-link:hover {
            text-decoration: underline;
        }

        /* Laporan cards */
        .laporan-card {
            background: var(--bg);
            border-radius: 14px;
            padding: 18px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 10px;
        }

        .laporan-card:last-child {
            margin-bottom: 0;
        }

        .laporan-title {
            font-size: 14px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 4px;
        }

        .laporan-desc {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.4);
            max-width: 400px;
        }

        .btn-tindak {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.12);
            color: rgba(255, 255, 255, 0.8);
            padding: 9px 20px;
            border-radius: 10px;
            font-family: inherit;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            white-space: nowrap;
            transition: background 0.2s, border-color 0.2s;
        }

        .btn-tindak:hover {
            background: rgba(61, 186, 126, 0.2);
            border-color: var(--accent);
            color: var(--accent2);
        }

        /* Table */
        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th {
            text-align: left;
            font-size: 11px;
            font-weight: 700;
            color: var(--muted);
            letter-spacing: 0.5px;
            text-transform: uppercase;
            padding: 0 14px 14px;
        }

        .data-table td {
            padding: 13px 14px;
            font-size: 13px;
            font-weight: 500;
            color: var(--text);
            border-top: 1px solid var(--border);
        }

        .data-table tr:last-child td {
            border-bottom: none;
        }

        .data-table tbody tr {
            transition: background 0.15s;
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

        .badge {
            display: inline-flex;
            align-items: center;
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

        .badge-yellow {
            background: #fef9c3;
            color: #854d0e;
        }

        .badge-gray {
            background: #f1f5f9;
            color: #475569;
        }

        /* Scrollbar global */
        ::-webkit-scrollbar {
            width: 5px;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--border);
            border-radius: 10px;
        }

        /* Overlay mobile */
        .overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.45);
            z-index: 50;
        }

        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                left: 0;
                top: 0;
                bottom: 0;
                z-index: 100;
            }

            .sidebar.closed {
                width: 0;
            }

            .overlay.show {
                display: block;
            }

            .stats-grid {
                grid-template-columns: 1fr 1fr;
            }
        }
    </style>
</head>

<body>

    <div class="overlay" id="overlay" onclick="closeSidebar()"></div>

    <div class="layout">

        {{-- ── SIDEBAR ── --}}
        <aside class="sidebar" id="sidebar">

            {{-- Brand --}}
            <div class="sidebar-brand">
                <div class="brand-icon">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10 10-4.5 10-10S17.5 2 12 2zM7 13l3 3 7-7" />
                    </svg>
                </div>
                <div class="brand-text">
                    <div class="brand-name">SEARA Admin</div>
                    <div class="brand-sub">Panel Pengelola</div>
                </div>
            </div>

            {{-- Toggle Button --}}
            <button class="sidebar-toggle" id="sidebarToggle" onclick="toggleSidebar()" title="Toggle sidebar">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </button>

            {{-- Navigation --}}
            <nav class="sidebar-nav">

                <div class="nav-section-label">UTAMA</div>

                {{-- 1. Dashboard --}}
                <a href="{{ route('admin.dashboard') }}" class="nav-item active">
                    <div class="nav-icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                    </div>
                    <span class="nav-label">Dashboard</span>
                    <span class="tooltip">Dashboard</span>
                </a>

                <div class="nav-section-label">MANAJEMEN PENGGUNA</div>

                {{-- 2. Data Pembeli --}}
                <a href="{{ route('admin.users') }}" class="nav-item">
                    <div class="nav-icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <span class="nav-label">Data Pembeli</span>
                    <span class="tooltip">Data Pembeli</span>
                </a>

                {{-- 3. Data Seller --}}
                <a href="{{ route('admin.sellers') }}" class="nav-item">
                    <div class="nav-icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="nav-label">Data Seller</span>
                    <span class="tooltip">Data Seller</span>
                </a>

                {{-- 4. Pengajuan Seller --}}
                <a href="{{ route('admin.verifikasi') }}" class="nav-item">
                    <div class="nav-icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <span class="nav-label">Pengajuan Seller</span>
                    <span class="tooltip">Pengajuan Seller</span>
                </a>

                <div class="nav-section-label">MODERASI</div>

                {{-- 5. Laporan Aktif --}}
                <a href="{{ route('admin.laporan') }}" class="nav-item">
                    <div class="nav-icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <span class="nav-label">Laporan Aktif</span>
                    <div class="nav-badge">24</div>
                    <span class="tooltip">Laporan Aktif</span>
                </a>

            </nav>

            {{-- Footer --}}
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
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </div>
                        <span class="nav-label">Keluar</span>
                    </button>
                </form>
            </div>

        </aside>

        {{-- ── MAIN ── --}}
        <div class="main">

            {{-- Topbar --}}
            <div class="topbar">
                {{-- Mobile hamburger --}}
                <button class="icon-btn" id="mobileMenuBtn" onclick="openSidebar()" style="display:none">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <div class="search-wrap">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8" />
                        <path stroke-linecap="round" d="m21 21-4.35-4.35" />
                    </svg>
                    <input type="text" placeholder="Cari pengguna, laporan, seller...">
                </div>

                <div class="topbar-right">
                    <div class="icon-btn">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div class="icon-btn">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
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

            {{-- Content --}}
            <div class="content">

                <div class="page-header">
                    <h1 class="page-title">Dashboard</h1>
                    <p class="page-sub">Selamat datang kembali — berikut ringkasan data terkini platform SEARA.</p>
                </div>

                {{-- Stats --}}
                <div class="stats-grid">
                    <div class="stat-card dark">
                        <div class="stat-top">
                            <div class="stat-icon white">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <div>
                            <div class="stat-num">{{ $stats['petani'] }}</div>
                            <div class="stat-label">Total Seller / Petani</div>
                        </div>
                        <div class="stat-pill">↑ 8% bulan ini</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-top">
                            <div class="stat-icon green">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                        </div>
                        <div>
                            <div class="stat-num">{{ $stats['pembeli'] }}</div>
                            <div class="stat-label">Total Pembeli</div>
                        </div>
                        <div class="stat-pill">↑ 50% bulan ini</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-top">
                            <div class="stat-icon gold">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                            </div>
                        </div>
                        <div>
                            <div class="stat-num">{{ $stats['transaksi'] }}</div>
                            <div class="stat-label">Total Transaksi</div>
                        </div>
                        <div class="stat-pill">↑ 22% bulan ini</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-top">
                            <div class="stat-icon red">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                        </div>
                        <div>
                            <div class="stat-num">{{ $stats['laporan'] }}</div>
                            <div class="stat-label">Laporan Aktif</div>
                        </div>
                        <div class="stat-pill" style="background:rgba(224,92,92,0.1);color:var(--danger);">Perlu
                            ditinjau</div>
                    </div>
                </div>

                {{-- Laporan Aktif --}}
                <div class="section">
                    <div class="section-head">
                        <div class="section-title-wrap">
                            <div class="section-icon red">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <span class="section-title">Laporan Aktif</span>
                        </div>
                        <a href="{{ route('admin.laporan') }}" class="section-link">Lihat Semua →</a>
                    </div>

                    @foreach ($laporans as $laporan)
                        <div class="laporan-card">
                            <div>
                                <div class="laporan-title">{{ $laporan['judul'] }}</div>
                                <div class="laporan-desc">{{ $laporan['deskripsi'] }}</div>
                            </div>
                            <button class="btn-tindak">Tindak Lanjuti</button>
                        </div>
                    @endforeach
                </div>

                {{-- Verifikasi Pengajuan Seller --}}
                <div class="section">
                    <div class="section-head">
                        <div class="section-title-wrap">
                            <div class="section-icon" style="background:rgba(61,186,126,0.1);color:var(--accent);">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <span class="section-title">Pengajuan Seller — Menunggu Verifikasi</span>
                        </div>
                        <a href="{{ route('admin.verifikasi') }}" class="section-link">Lihat Semua →</a>
                    </div>

                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Nama Toko / Pemilik</th>
                                <th>Tanggal Daftar</th>
                                <th>Kelengkapan Dok.</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($verifikasis as $verif)
                                <tr>
                                    <td>
                                        <div class="cell-primary">{{ $verif['nama_toko'] }}</div>
                                        <div class="cell-secondary">{{ $verif['nama_pemilik'] }}</div>
                                    </td>
                                    <td>{{ $verif['tanggal'] }}</td>
                                    <td>
                                        @if ($verif['status_dokumen'] === 'Lengkap')
                                            <span class="badge badge-green">✓ Lengkap</span>
                                        @else
                                            <span class="badge badge-red">✗ Kurang</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-yellow">{{ $verif['status_akun'] }}</span>
                                    </td>
                                    <td>
                                        <div style="display:flex;gap:6px;">
                                            <button
                                                style="background:#dcfce7;color:#166534;border:none;padding:5px 12px;border-radius:8px;font-size:11px;font-weight:700;cursor:pointer;font-family:inherit;">ACC</button>
                                            <button
                                                style="background:#fee2e2;color:#991b1b;border:none;padding:5px 12px;border-radius:8px;font-size:11px;font-weight:700;cursor:pointer;font-family:inherit;">Tolak</button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
        <!-- Modal Logout -->
        <div id="logoutModal" style="
    display:none; position:fixed; inset:0; z-index:9999;
    background:rgba(0,0,0,0.5); backdrop-filter:blur(4px);
    align-items:center; justify-content:center;
">
            <div style="
        background:#fff; border-radius:20px; padding:32px 28px;
        width:100%; max-width:360px; margin:16px;
        box-shadow:0 20px 60px rgba(0,0,0,0.2);
        animation:modalIn .25s cubic-bezier(0.4,0,0.2,1);
    ">
                <div style="text-align:center; margin-bottom:20px;">
                    <div style="
                width:56px; height:56px; background:#fee2e2;
                border-radius:50%; display:flex; align-items:center;
                justify-content:center; margin:0 auto 14px;
            ">
                        <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="#e05c5c" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </div>
                    <div style="font-size:17px; font-weight:800; color:#1a2e24; margin-bottom:6px;">Keluar dari Panel
                        Admin?</div>
                    <div style="font-size:13px; color:#7a9488; font-weight:500;">Sesi Anda akan diakhiri. Pastikan semua
                        pekerjaan sudah tersimpan.</div>
                </div>
                <div style="display:flex; gap:10px;">
                    <button onclick="closeLogoutModal()" style="
                flex:1; padding:11px; border-radius:12px;
                border:1.5px solid #e8eeeb; background:#fff;
                font-family:'Plus Jakarta Sans',sans-serif;
                font-size:13px; font-weight:700; color:#7a9488;
                cursor:pointer; transition:all .2s;
            " onmouseover="this.style.borderColor='#3dba7e';this.style.color='#1a2e24'"
                        onmouseout="this.style.borderColor='#e8eeeb';this.style.color='#7a9488'">
                        Batal
                    </button>
                    <button onclick="document.getElementById('adminLogoutForm').submit()" style="
                flex:1; padding:11px; border-radius:12px;
                border:none; background:#e05c5c;
                font-family:'Plus Jakarta Sans',sans-serif;
                font-size:13px; font-weight:700; color:#fff;
                cursor:pointer; transition:all .2s;
            " onmouseover="this.style.background='#c94f4f'" onmouseout="this.style.background='#e05c5c'">
                        Ya, Keluar
                    </button>
                </div>
            </div>
        </div>

        <style>
            @keyframes modalIn {
                from {
                    opacity: 0;
                    transform: scale(0.93) translateY(10px);
                }

                to {
                    opacity: 1;
                    transform: scale(1) translateY(0);
                }
            }
        </style>
    </div>{{-- end .layout --}}

    <script>
        // ── Sidebar toggle ──────────────────────────────────────
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const STORAGE_KEY = 'seara_sidebar_closed';

        function toggleSidebar() {
            sidebar.classList.toggle('closed');
            localStorage.setItem(STORAGE_KEY, sidebar.classList.contains('closed') ? '1' : '0');
        }

        function openSidebar() {
            sidebar.classList.remove('closed');
            overlay.classList.add('show');
        }

        function closeSidebar() {
            sidebar.classList.add('closed');
            overlay.classList.remove('show');
        }

        // Restore state dari localStorage
        if (localStorage.getItem(STORAGE_KEY) === '1') {
            sidebar.classList.add('closed');
        }

        // Mobile: tampilkan hamburger, sembunyikan toggle bawaan
        function handleResize() {
            const isMobile = window.innerWidth <= 768;
            document.getElementById('mobileMenuBtn').style.display = isMobile ? 'flex' : 'none';
            document.getElementById('sidebarToggle').style.display = isMobile ? 'none' : 'flex';
            if (isMobile) {
                sidebar.classList.add('closed');
            }
        }
        handleResize();
        window.addEventListener('resize', handleResize);

        // ── Logout ─────────────────────────────────────────────
        // Hapus ini:
        function confirmAdminLogout() {
            if (confirm('Yakin ingin keluar dari panel admin?')) {
                document.getElementById('adminLogoutForm').submit();
            }
        }

        // Ganti dengan ini:
        function confirmAdminLogout() {
            const modal = document.getElementById('logoutModal');
            modal.style.display = 'flex';
        }

        function closeLogoutModal() {
            document.getElementById('logoutModal').style.display = 'none';
        }

        // Tutup modal jika klik area luar
        document.getElementById('logoutModal').addEventListener('click', function (e) {
            if (e.target === this) closeLogoutModal();
        });
    </script>

</body>

</html>