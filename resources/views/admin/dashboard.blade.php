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

@extends('layouts.admin')

@section('title', 'Dashboard')

@push('styles')
    <style>
        /* ── Stats grid ── */
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
            transition: box-shadow .2s, transform .2s;
        }

        .stat-card:hover {
            box-shadow: 0 8px 24px rgba(0, 0, 0, .07);
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
            background: rgba(61, 186, 126, .12);
            color: var(--accent);
        }

        .stat-icon.gold {
            background: rgba(232, 201, 126, .15);
            color: var(--gold);
        }

        .stat-icon.red {
            background: rgba(224, 92, 92, .12);
            color: var(--danger);
        }

        .stat-icon.white {
            background: rgba(255, 255, 255, .10);
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
            color: rgba(255, 255, 255, .4);
        }

        .stat-pill {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: rgba(61, 186, 126, .1);
            color: var(--accent);
            font-size: 11px;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 20px;
            width: fit-content;
        }

        .stat-card.dark .stat-pill {
            background: rgba(255, 255, 255, .08);
            color: var(--accent2);
        }

        /* ── Sections ── */
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
            background: rgba(224, 92, 92, .1);
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

        /* ── Laporan cards ── */
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
            color: rgba(255, 255, 255, .4);
            max-width: 400px;
        }

        .btn-tindak {
            background: rgba(255, 255, 255, .08);
            border: 1px solid rgba(255, 255, 255, .12);
            color: rgba(255, 255, 255, .8);
            padding: 9px 20px;
            border-radius: 10px;
            font-family: inherit;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            white-space: nowrap;
            transition: background .2s, border-color .2s;
        }

        .btn-tindak:hover {
            background: rgba(61, 186, 126, .2);
            border-color: var(--accent);
            color: var(--accent2);
        }

        /* ── Table ── */
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
            padding: 13px 14px;
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

        /* Page header */
        .page-header {
            margin-bottom: 28px;
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

        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: 1fr 1fr;
            }
        }
    </style>
@endpush

@section('content')

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
            <div class="stat-pill" style="background:rgba(224,92,92,.1);color:var(--danger)">Perlu ditinjau</div>
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
                <div class="section-icon" style="background:rgba(61,186,126,.1);color:var(--accent)">
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
                            @if($verif['status_dokumen'] === 'Lengkap')
                                <span class="badge badge-green">✓ Lengkap</span>
                            @else
                                <span class="badge badge-red">✗ Kurang</span>
                            @endif
                        </td>
                        <td><span class="badge badge-yellow">{{ $verif['status_akun'] }}</span></td>
                        <td>
                            <div style="display:flex;gap:6px">
                                <button
                                    style="background:#dcfce7;color:#166534;border:none;padding:5px 12px;border-radius:8px;font-size:11px;font-weight:700;cursor:pointer;font-family:inherit">ACC</button>
                                <button
                                    style="background:#fee2e2;color:#991b1b;border:none;padding:5px 12px;border-radius:8px;font-size:11px;font-weight:700;cursor:pointer;font-family:inherit">Tolak</button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection