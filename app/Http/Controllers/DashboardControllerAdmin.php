<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Nama class diubah menjadi DashboardControllerAdmin
class DashboardControllerAdmin extends Controller
{
    public function indexAdmin()
    {
        // 1. Siapkan Data Statistik
        $stats = [
            'petani' => '1.782',
            'transaksi_1' => '12.321',
            'transaksi_2' => '12.321', 
            'transaksi_3' => '12.321',
        ];

        // 2. Siapkan Data Laporan Aktif
        $laporans = [
            [
                'judul' => 'Indikasi Spam',
                'deskripsi' => 'Akun petani melakukan manipulasi ulasan berkali kali'
            ],
            [
                'judul' => 'Pelaporan Barang Rusak',
                'deskripsi' => 'Pembeli (PN2-160804-1) melaporkan barang rusak saat tiba'
            ]
        ];

        // 3. Siapkan Data Verifikasi Akun Petani
        $verifikasis = [
            [
                'nama_toko' => 'Sayur Segar',
                'nama_pemilik' => 'Pak Sutarno',
                'tanggal' => '30 April 2026',
                'status_dokumen' => 'Lengkap',
                'status_akun' => 'Menunggu Persetujuan'
            ],
            [
                'nama_toko' => 'Tomat Pak',
                'nama_pemilik' => 'Somat',
                'tanggal' => '30 April 2026',
                'status_dokumen' => 'Lengkap',
                'status_akun' => 'Menunggu Persetujuan'
            ],
            [
                'nama_toko' => 'Pak Sholeh',
                'nama_pemilik' => 'Beras Pilihan',
                'tanggal' => '29 April 2026',
                'status_dokumen' => 'Kurang',
                'status_akun' => 'Menunggu Persetujuan'
            ]
        ];

        // 4. Lempar data ke view admin/dashboard.blade.php
        return view('admin.dashboard', compact('stats', 'laporans', 'verifikasis'));
    }
}