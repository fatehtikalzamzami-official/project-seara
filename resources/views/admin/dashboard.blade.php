{{-- resources/views/admin/dashboard.blade.php --}}
@php
    // SIMULASI DATA DARI CONTROLLER
    // Nanti data ini dikirim dari DashboardController menggunakan compact('stats', 'laporans', 'verifikasis')

    $stats = [
        'petani' => '1.782',
        'transaksi_1' => '12.321',
        'transaksi_2' => '12.321',
        'transaksi_3' => '12.321',
    ];

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
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Seara</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        seara: {
                            darkest: '#0b1a14',
                            dark: '#2c3c35',
                            gray: '#f4f6f5',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body { background-color: #f4f6f5; }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    </style>
</head>
<body class="text-slate-800 font-sans flex h-screen overflow-hidden">

    <!-- Sidebar -->
    <aside class="w-20 md:w-[90px] bg-seara-darkest flex flex-col items-center py-8 h-screen flex-shrink-0 z-20">
        <div class="mb-10 flex flex-col items-center text-white gap-1 cursor-pointer">
            <i data-lucide="leaf" class="w-7 h-7 fill-white"></i>
            <span class="text-[9px] font-bold tracking-widest uppercase">Seara</span>
        </div>
        
      <nav class="flex-1 flex flex-col gap-6 w-full px-4">
            <!-- 1. Dashboard (Aktif) -->
            <a href="#" title="Dashboard" class="bg-[#f4f6f5] text-seara-darkest rounded-[18px] w-12 h-12 flex items-center justify-center mx-auto shadow-sm transition-transform hover:scale-105">
                <i data-lucide="home" class="w-[22px] h-[22px] fill-seara-darkest"></i>
            </a>
            
            <!-- 2. Data Pengguna (Pembeli) -->
            <a href="#" title="Data Pengguna" class="text-slate-400 hover:text-white w-12 h-12 flex items-center justify-center mx-auto transition-all hover:scale-110">
                <i data-lucide="users" class="w-5 h-5"></i>
            </a>
            
            <!-- 3. Data Petani -->
            <a href="#" title="Data Petani" class="text-slate-400 hover:text-white w-12 h-12 flex items-center justify-center mx-auto transition-all hover:scale-110">
                <i data-lucide="sprout" class="w-5 h-5"></i>
            </a>
            
            <!-- 4. Verifikasi Akun Petani -->
            <a href="#" title="Verifikasi Akun Petani" class="text-slate-400 hover:text-white w-12 h-12 flex items-center justify-center mx-auto transition-all hover:scale-110">
                <i data-lucide="user-check" class="w-5 h-5"></i>
            </a>
            
            <!-- 5. Laporan Aktif -->
            <a href="#" title="Laporan Aktif" class="text-slate-400 hover:text-white w-12 h-12 flex items-center justify-center mx-auto transition-all hover:scale-110 relative">
                <i data-lucide="shield-alert" class="w-5 h-5"></i>
                <!-- Indikator titik merah notifikasi laporan -->
                <span class="absolute top-2 right-2 w-2.5 h-2.5 bg-red-500 rounded-full border-2 border-seara-darkest"></span>
            </a>
        </nav>

        <a href="#" class="text-slate-400 hover:text-white mt-auto mb-2 w-12 h-12 flex items-center justify-center transition-colors">
            <i data-lucide="log-out" class="w-5 h-5"></i>
        </a>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col h-screen overflow-hidden relative">
        <!-- Topbar -->
        <div class="px-8 pt-8 pb-4">
            <header class="flex items-center justify-between gap-6">
                <div class="flex-1 max-w-4xl">
                    <div class="bg-seara-darkest rounded-full flex items-center px-6 py-3.5 text-slate-300">
                        <i data-lucide="search" class="w-5 h-5 mr-3 text-slate-400"></i>
                        <input type="text" placeholder="Cari Sesuatu" class="bg-transparent border-none outline-none w-full text-sm placeholder-slate-400 text-white">
                    </div>
                </div>
                
                <div class="flex items-center gap-4">
                    <button class="w-10 h-10 rounded-full bg-[#404c45] flex items-center justify-center text-white hover:bg-[#525d57] transition-colors">
                        <i data-lucide="settings" class="w-5 h-5 fill-white"></i>
                    </button>
                    <button class="w-10 h-10 rounded-full bg-[#404c45] flex items-center justify-center text-white hover:bg-[#525d57] transition-colors relative">
                        <i data-lucide="bell" class="w-5 h-5 fill-white"></i>
                    </button>
                    
                    <div class="flex items-center gap-3 ml-2 cursor-pointer">
                        <img src="{{ asset('images/avatar.jpg') }}" onerror="this.src='https://images.unsplash.com/photo-1599566150163-29194dcaad36?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80'" alt="Profile" class="w-11 h-11 rounded-full object-cover border-2 border-white shadow-sm">
                        <div class="hidden sm:block">
                            <p class="text-sm font-semibold text-slate-800 leading-tight">Kicau Mania</p>
                            <p class="text-[10px] text-slate-500 mt-0.5">kicaumania@gmail.com</p>
                        </div>
                    </div>
                </div>
            </header>
        </div>

        <!-- Scrollable Dashboard Content -->
        <div class="flex-1 overflow-y-auto px-8 pb-10 scroll-smooth">
            <div class="w-full space-y-8 pt-2">
                
                <div>
                    <h1 class="text-3xl font-bold text-seara-darkest tracking-tight">Dashboard</h1>
                    <p class="text-sm text-slate-600 mt-2 font-medium">Selamat datang kembali, berikut data-data yang perlu anda lihat!</p>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Card 1 -->
                    <div class="bg-seara-darkest rounded-[28px] p-6 flex flex-col justify-between shadow-lg">
                        <div class="flex justify-between items-start">
                            <h3 class="text-base font-bold text-white w-1/2 leading-tight mt-1">Total Petani</h3>
                            <span class="text-3xl font-light text-white">{{ $stats['petani'] }}</span>
                        </div>
                        <div class="mt-8 flex justify-end">
                            <div class="bg-[#243c30] text-emerald-400 px-4 py-1.5 rounded-full text-[10px] font-medium flex flex-col items-center">
                                <span>Naik 8%</span>
                                <span class="text-slate-300 text-[8px]">dari bulan lalu</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Card 2 -->
                    <div class="bg-white rounded-[28px] p-6 flex flex-col justify-between shadow-sm">
                        <div class="flex justify-between items-start">
                            <h3 class="text-base font-bold text-seara-darkest w-1/2 leading-tight mt-1">Total Pembeli</h3>
                            <span class="text-3xl font-light text-seara-darkest">{{ $stats['transaksi_1'] }}</span>
                        </div>
                        <div class="mt-8 flex justify-end">
                            <div class="bg-seara-darkest text-emerald-400 px-4 py-1.5 rounded-full text-[10px] font-medium flex flex-col items-center">
                                <span>Naik 50%</span>
                                <span class="text-slate-300 text-[8px]">dari bulan lalu</span>
                            </div>
                        </div>
                    </div>

                    <!-- Card 3 -->
                    <div class="bg-white rounded-[28px] p-6 flex flex-col justify-between shadow-sm">
                        <div class="flex justify-between items-start">
                            <h3 class="text-base font-bold text-seara-darkest w-1/2 leading-tight mt-1">Total Transaksi</h3>
                            <span class="text-3xl font-light text-seara-darkest">{{ $stats['transaksi_2'] }}</span>
                        </div>
                        <div class="mt-8 flex justify-end">
                            <div class="bg-seara-darkest text-emerald-400 px-4 py-1.5 rounded-full text-[10px] font-medium flex flex-col items-center">
                                <span>Naik 50%</span>
                                <span class="text-slate-300 text-[8px]">dari bulan lalu</span>
                            </div>
                        </div>
                    </div>

                    <!-- Card 4 -->
                    <div class="bg-white rounded-[28px] p-6 flex flex-col justify-between shadow-sm">
                        <div class="flex justify-between items-start">
                            <h3 class="text-base font-bold text-seara-darkest w-1/2 leading-tight mt-1">Total Laporan</h3>
                            <span class="text-3xl font-light text-seara-darkest">{{ $stats['transaksi_3'] }}</span>
                        </div>
                        <div class="mt-8 flex justify-end">
                            <div class="bg-seara-darkest text-emerald-400 px-4 py-1.5 rounded-full text-[10px] font-medium flex flex-col items-center">
                                <span>Naik 50%</span>
                                <span class="text-slate-300 text-[8px]">dari bulan lalu</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Laporan Aktif Section (Dinamis dengan foreach) -->
                <div class="bg-white rounded-[32px] p-8 shadow-sm">
                    <div class="flex justify-between items-center mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full border-2 border-red-500 flex items-center justify-center text-red-500">
                                <i data-lucide="alert-circle" class="w-5 h-5"></i>
                            </div>
                            <h2 class="text-2xl font-bold text-seara-darkest">Laporan Aktif</h2>
                        </div>
                        <a href="{{ route('admin.laporan') }}" class="text-sm font-medium text-slate-800 hover:text-seara-darkest">Lihat Semua</a>
                    </div>

                    <div class="space-y-4">
                        @foreach ($laporans as $laporan)
                            <div class="bg-seara-darkest rounded-[20px] p-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                                <div class="text-white">
                                    <h3 class="text-lg font-bold">{{ $laporan['judul'] }}</h3>
                                    <p class="text-sm text-slate-300 mt-2 max-w-sm">{{ $laporan['deskripsi'] }}</p>
                                </div>
                                <button class="bg-seara-dark hover:bg-[#384c42] text-white font-semibold py-3.5 px-8 rounded-xl transition-colors w-full md:w-auto">
                                    Tindak Lanjuti
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Verifikasi Akun Petani Section (Dinamis dengan foreach) -->
                <div class="bg-white rounded-[32px] p-8 shadow-sm">
                    <div class="flex justify-between items-center mb-8">
                        <h2 class="text-2xl font-bold text-seara-darkest">Verifikasi Akun Petani</h2>
                        <a href="{{ route('admin.verifikasi') }}" class="text-sm font-medium text-slate-800 hover:text-seara-darkest">Lihat Semua</a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr>
                                    <th class="pb-6 font-bold text-seara-darkest text-base">Nama Akun Petani</th>
                                    <th class="pb-6 font-bold text-seara-darkest text-base">Tanggal Daftar</th>
                                    <th class="pb-6 font-bold text-seara-darkest text-base">Kelengkapan</th>
                                    <th class="pb-6 font-bold text-seara-darkest text-base">Status</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm">
                                @foreach ($verifikasis as $verif)
                                    <tr class="border-b border-transparent">
                                        <td class="py-4">
                                            <p class="font-medium text-slate-800 text-base">{{ $verif['nama_toko'] }}</p>
                                            <p class="font-medium text-slate-800 text-base">{{ $verif['nama_pemilik'] }}</p>
                                        </td>
                                        <td class="py-4 font-medium text-slate-800 text-base">{{ $verif['tanggal'] }}</td>
                                        <td class="py-4">
                                            @if ($verif['status_dokumen'] == 'Lengkap')
                                                <span class="inline-block bg-[#c6f6d5] text-[#22543d] px-4 py-1.5 rounded-full font-medium text-sm">Lengkap</span>
                                            @else
                                                <span class="inline-block bg-[#fecdd3] text-[#881337] px-4 py-1.5 rounded-full font-medium text-sm">Kurang</span>
                                            @endif
                                        </td>
                                        <td class="py-4">
                                            <span class="inline-block bg-[#fef08a] text-[#713f12] px-4 py-1.5 rounded-full font-medium text-sm">{{ $verif['status_akun'] }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>