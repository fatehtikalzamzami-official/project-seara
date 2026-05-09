<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk Saya – SEARA</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('assets/LOGO_FIKS_LIGHT.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        :root {
            --green-dark: #1a4731;
            --green-main: #2d8653;
            --green-mid:  #3dba7e;
            --green-light:#52dda0;
            --green-pale: #f0fdf6;
            --accent:     #e05c2e;
            --accent-soft:#fff0eb;
            --yellow:     #f5a623;
            --yellow-soft:#fffbeb;
            --blue:       #2563eb;
            --blue-soft:  #eff6ff;
            --text-dark:  #0f2419;
            --text-mid:   #3d5c49;
            --text-muted: #7a9585;
            --border:     #e2ece7;
            --white:      #ffffff;
            --bg:         #f5f9f6;
            --r: 14px;
            --shadow-sm: 0 1px 4px rgba(0,0,0,.06);
            --shadow-md: 0 4px 18px rgba(0,0,0,.09);
        }
        *{box-sizing:border-box;margin:0;padding:0}
        body{background:var(--bg);font-family:'Nunito',sans-serif;color:var(--text-dark)}

        /* Layout */
        .seller-wrap{display:flex;min-height:100vh}

        /* Sidebar — styles dipindah ke partials/seller_sidebar.blade.php */

        /* Main */
        .seller-main{flex:1;padding:24px;overflow-x:hidden}
        .page-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:22px}
        .page-header-left h1{font-family:'Playfair Display',serif;font-size:26px;font-weight:700;color:var(--text-dark)}
        .page-header-left p{font-size:13px;color:var(--text-muted);margin-top:3px;font-weight:600}
        .page-header-right{display:flex;gap:10px;align-items:center}
        .btn-green{padding:9px 18px;background:linear-gradient(135deg,var(--green-mid),var(--green-main));border:none;border-radius:10px;font-family:'Nunito',sans-serif;font-weight:800;font-size:13px;color:white;cursor:pointer;transition:all .2s;display:flex;align-items:center;gap:6px;box-shadow:0 4px 12px rgba(61,186,126,.25);text-decoration:none}
        .btn-green:hover{transform:translateY(-1px);box-shadow:0 8px 20px rgba(61,186,126,.3)}
        .btn-outline{padding:9px 18px;border:1.5px solid var(--border);border-radius:10px;background:white;font-family:'Nunito',sans-serif;font-weight:700;font-size:13px;color:var(--text-mid);cursor:pointer;transition:all .2s;display:flex;align-items:center;gap:6px;text-decoration:none}
        .btn-outline:hover{border-color:var(--green-main);color:var(--green-dark)}

        /* Alert */
        .alert{padding:12px 18px;border-radius:10px;font-size:13px;font-weight:700;margin-bottom:18px;display:flex;align-items:center;gap:10px}
        .alert-success{background:#f0fdf4;border:1px solid #bbf7d0;color:var(--green-dark)}
        .alert-error{background:#fef2f2;border:1px solid #fecaca;color:#991b1b}

        /* Stats bar */
        .stats-bar{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:22px}
        .stat-card{background:white;border:1px solid var(--border);border-radius:var(--r);padding:16px 18px}
        .stat-icon{width:38px;height:38px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:16px;margin-bottom:10px}
        .stat-icon.green{background:var(--green-pale);color:var(--green-dark)}
        .stat-icon.orange{background:var(--accent-soft);color:var(--accent)}
        .stat-icon.blue{background:var(--blue-soft);color:var(--blue)}
        .stat-icon.yellow{background:var(--yellow-soft);color:#b45309}
        .stat-label{font-size:10px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:.8px;margin-bottom:3px}
        .stat-value{font-size:20px;font-weight:900;color:var(--text-dark)}

        /* Filter bar */
        .filter-bar{display:flex;align-items:center;gap:10px;margin-bottom:18px;flex-wrap:wrap}
        .search-box{display:flex;align-items:center;gap:8px;background:white;border:1.5px solid var(--border);border-radius:10px;padding:8px 14px;flex:1;min-width:200px;max-width:320px}
        .search-box input{border:none;outline:none;font-family:'Nunito',sans-serif;font-size:13px;color:var(--text-dark);background:transparent;width:100%}
        .search-box i{color:var(--text-muted);font-size:13px}
        .filter-select{padding:8px 12px;border:1.5px solid var(--border);border-radius:10px;font-family:'Nunito',sans-serif;font-size:13px;color:var(--text-mid);background:white;outline:none;cursor:pointer}
        .filter-select:focus{border-color:var(--green-main)}

        /* Product grid */
        .product-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:16px}
        .product-card{background:white;border:1px solid var(--border);border-radius:var(--r);overflow:hidden;transition:all .2s;position:relative}
        .product-card:hover{transform:translateY(-2px);box-shadow:var(--shadow-md);border-color:var(--green-main)}
        .pc-badge{position:absolute;top:12px;left:12px;z-index:1;display:flex;gap:6px;flex-wrap:wrap}
        .badge-organic{background:var(--green-dark);color:white;font-size:10px;font-weight:800;padding:3px 8px;border-radius:20px;display:flex;align-items:center;gap:4px}
        .badge-low{background:#fef3c7;color:#92400e;font-size:10px;font-weight:800;padding:3px 8px;border-radius:20px}
        .badge-out{background:#fee2e2;color:#b91c1c;font-size:10px;font-weight:800;padding:3px 8px;border-radius:20px}
        .badge-preorder{background:#ede9fe;color:#5b21b6;font-size:10px;font-weight:800;padding:3px 8px;border-radius:20px}
        .pc-thumb{height:140px;background:linear-gradient(135deg,var(--green-pale),#d1fae5);display:flex;align-items:center;justify-content:center;font-size:56px;overflow:hidden;position:relative;cursor:pointer;text-decoration:none}
        .pc-thumb:hover{opacity:.9}
        .pc-thumb img{width:100%;height:100%;object-fit:cover;position:absolute;inset:0}
        .pc-body{padding:14px}
        .pc-category{font-size:10px;font-weight:800;color:var(--green-main);text-transform:uppercase;letter-spacing:.8px;margin-bottom:4px}
        .pc-name{font-size:15px;font-weight:900;color:var(--text-dark);margin-bottom:2px;line-height:1.3}
        .pc-harvest{font-size:11px;color:var(--text-muted);font-weight:600;margin-bottom:6px;display:flex;align-items:center;gap:4px}
        .pc-agri-tags{display:flex;gap:5px;flex-wrap:wrap;margin-bottom:10px}
        .pc-tag{font-size:10px;font-weight:700;padding:2px 8px;border-radius:20px;background:var(--green-pale);color:var(--green-dark)}
        .pc-tag.metode{background:#eff6ff;color:#1d4ed8}
        .pc-tag.kondisi{background:#fef9c3;color:#92400e}
        .pc-meta{display:flex;align-items:center;justify-content:space-between;margin-bottom:12px}
        .pc-price{font-size:17px;font-weight:900;color:var(--green-dark)}
        .pc-price span{font-size:11px;font-weight:700;color:var(--text-muted)}
        .pc-stock{font-size:12px;font-weight:700;color:var(--text-mid);background:var(--green-pale);padding:3px 10px;border-radius:20px}
        .pc-stock.low{background:#fef3c7;color:#92400e}
        .pc-stock.out{background:#fee2e2;color:#b91c1c}
        .pc-actions{display:flex;gap:8px}
        .pc-btn{flex:1;padding:8px;border-radius:8px;font-family:'Nunito',sans-serif;font-size:12px;font-weight:800;cursor:pointer;transition:all .2s;border:none;display:flex;align-items:center;justify-content:center;gap:5px}
        .pc-btn.edit{background:var(--green-pale);color:var(--green-dark)}
        .pc-btn.edit:hover{background:#bbf7d0}
        .pc-btn.delete{background:#fef2f2;color:#b91c1c}
        .pc-btn.delete:hover{background:#fecaca}

        /* Empty state */
        .empty-state{text-align:center;padding:60px 20px;background:white;border-radius:var(--r);border:1px solid var(--border)}
        .empty-state i{font-size:52px;color:var(--border);margin-bottom:14px;display:block}
        .empty-state h3{font-size:17px;font-weight:800;color:var(--text-mid);margin-bottom:6px}
        .empty-state p{font-size:13px;color:var(--text-muted);font-weight:600;margin-bottom:18px}

        /* Pagination */
        .pagination-wrap{display:flex;justify-content:center;gap:6px;margin-top:22px}
        .pagination-wrap a,.pagination-wrap span{padding:7px 13px;border-radius:8px;font-size:13px;font-weight:700;border:1.5px solid var(--border);text-decoration:none;color:var(--text-mid);background:white;transition:all .18s}
        .pagination-wrap a:hover{border-color:var(--green-main);color:var(--green-dark)}
        .pagination-wrap span.active-page{background:var(--green-main);color:white;border-color:var(--green-main)}

        /* Modal */
        .modal-overlay{position:fixed;inset:0;background:rgba(0,0,0,.45);z-index:1000;display:flex;align-items:center;justify-content:center;padding:20px;opacity:0;pointer-events:none;transition:opacity .25s}
        .modal-overlay.open{opacity:1;pointer-events:auto}
        .modal{background:white;border-radius:16px;width:100%;max-width:580px;overflow:hidden;transform:translateY(20px);transition:transform .25s;box-shadow:0 20px 60px rgba(0,0,0,.18)}
        .modal-overlay.open .modal{transform:translateY(0)}
        .modal-head{display:flex;align-items:center;justify-content:space-between;padding:18px 22px;border-bottom:1px solid var(--border)}
        .modal-head h2{font-size:16px;font-weight:900;color:var(--text-dark);display:flex;align-items:center;gap:8px}
        .modal-close{background:none;border:none;cursor:pointer;font-size:16px;color:var(--text-muted);padding:4px;border-radius:6px;transition:color .18s}
        .modal-close:hover{color:var(--text-dark)}
        .modal-body{padding:22px;max-height:75vh;overflow-y:auto}

        /* Section divider inside modal */
        .form-section{margin-bottom:18px}
        .form-section-title{font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:1.2px;color:var(--green-dark);background:var(--green-pale);border-radius:8px;padding:7px 12px;margin-bottom:12px;display:flex;align-items:center;gap:7px}

        .form-group{margin-bottom:14px}
        .form-label{display:block;font-size:12px;font-weight:800;color:var(--text-mid);margin-bottom:5px}
        .form-label .req{color:var(--accent)}
        .form-input,.form-select,.form-textarea{width:100%;padding:10px 13px;border:1.5px solid var(--border);border-radius:9px;font-family:'Nunito',sans-serif;font-size:13px;color:var(--text-dark);background:white;outline:none;transition:border-color .2s}
        .form-input:focus,.form-select:focus,.form-textarea:focus{border-color:var(--green-main);box-shadow:0 0 0 3px rgba(45,134,83,.1)}
        .form-textarea{resize:vertical;min-height:72px}
        .form-row{display:grid;grid-template-columns:1fr 1fr;gap:12px}
        .form-row-3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px}
        .form-hint{font-size:11px;color:var(--text-muted);font-weight:600;margin-top:3px}
        .toggle-wrap{display:flex;align-items:center;gap:10px;padding:12px;background:var(--green-pale);border-radius:9px;cursor:pointer}
        .toggle-wrap label{font-size:13px;font-weight:700;color:var(--green-dark);cursor:pointer;display:flex;align-items:center;gap:6px}

        /* Photo preview */
        .photo-upload-area{border:2px dashed var(--border);border-radius:10px;padding:16px;text-align:center;cursor:pointer;transition:all .2s;position:relative}
        .photo-upload-area:hover{border-color:var(--green-main);background:var(--green-pale)}
        .photo-upload-area input[type=file]{position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%}
        .photo-upload-area i{font-size:22px;color:var(--text-muted);margin-bottom:6px;display:block}
        .photo-upload-area p{font-size:12px;font-weight:700;color:var(--text-muted)}
        .photo-preview{width:100%;max-height:120px;object-fit:cover;border-radius:8px;margin-top:8px;display:none}

        .modal-foot{display:flex;gap:10px;justify-content:flex-end;padding:16px 22px;border-top:1px solid var(--border);background:#fafcfa}

        /* Toast */
        .toast{position:fixed;bottom:24px;right:24px;background:var(--green-dark);color:white;padding:12px 20px;border-radius:10px;font-size:13px;font-weight:700;display:flex;align-items:center;gap:8px;box-shadow:0 8px 24px rgba(0,0,0,.18);transform:translateY(80px);opacity:0;transition:all .3s ease;z-index:9999}
        .toast.show{transform:translateY(0);opacity:1}
        .toast.error{background:#b91c1c}

        /* Animations */
        @keyframes fadeUp{from{opacity:0;transform:translateY(14px)}to{opacity:1;transform:translateY(0)}}
        .anim-1{animation:fadeUp .45s ease both}
        .anim-2{animation:fadeUp .45s .07s ease both}
        .anim-3{animation:fadeUp .45s .14s ease both}

        @media(max-width:768px){
            .seller-sidebar{display:none}
            .seller-main{padding:16px}
            .stats-bar{grid-template-columns:1fr 1fr}
            .form-row,.form-row-3{grid-template-columns:1fr}
        }
    </style>
</head>
<body>

<div class="seller-wrap">

    <!-- ══ SIDEBAR ══ -->
    @include('partials.seller_sidebar')

    <!-- ══ MAIN ══ -->
    <main class="seller-main">

        @if(session('success'))
        <div class="alert alert-success anim-1">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="alert alert-error anim-1">
            <i class="fa-solid fa-circle-xmark"></i> {{ session('error') }}
        </div>
        @endif

        <!-- Page Header -->
        <div class="page-header anim-1">
            <div class="page-header-left">
                <h1>Produk Saya <i class="fa-solid fa-wheat-awn" style="font-size:22px;color:var(--green-main)"></i></h1>
                <p>Kelola semua produk panen yang Anda jual di marketplace.</p>
            </div>
            <div class="page-header-right">
                <button class="btn-green" onclick="openModal()">
                    <i class="fa-solid fa-plus"></i> Tambah Produk
                </button>
            </div>
        </div>

        <!-- Stats Bar -->
        <div class="stats-bar anim-2">
            <div class="stat-card">
                <div class="stat-icon green"><i class="fa-solid fa-boxes-stacked"></i></div>
                <div class="stat-label">Total Produk</div>
                <div class="stat-value">{{ $harvests->total() }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon blue"><i class="fa-solid fa-check-circle"></i></div>
                <div class="stat-label">Stok Tersedia</div>
                <div class="stat-value">{{ $harvests->getCollection()->where('remaining_stock', '>', 0)->count() }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon yellow"><i class="fa-solid fa-triangle-exclamation"></i></div>
                <div class="stat-label">Stok Menipis</div>
                <div class="stat-value">{{ $harvests->getCollection()->where('remaining_stock', '>', 0)->where('remaining_stock', '<=', 10)->count() }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon orange"><i class="fa-solid fa-ban"></i></div>
                <div class="stat-label">Stok Habis</div>
                <div class="stat-value">{{ $harvests->getCollection()->where('remaining_stock', 0)->count() }}</div>
            </div>
        </div>

        <!-- Filter Bar -->
        <div class="filter-bar anim-2">
            <div class="search-box">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" id="searchInput" placeholder="Cari produk..." oninput="filterProducts()">
            </div>
            <select class="filter-select" id="filterCategory" onchange="filterProducts()">
                <option value="">Semua Kategori</option>
                @foreach($categories as $cat)
                <option value="{{ $cat->name }}">{{ $cat->name }}</option>
                @endforeach
            </select>
            <select class="filter-select" id="filterStock" onchange="filterProducts()">
                <option value="">Semua Stok</option>
                <option value="available">Tersedia</option>
                <option value="low">Menipis (≤10)</option>
                <option value="out">Habis</option>
            </select>
        </div>

        <!-- Product Grid -->
        @if($harvests->isEmpty())
        <div class="empty-state anim-3">
            <i class="fa-solid fa-seedling"></i>
            <h3>Belum ada produk</h3>
            <p>Mulai tambahkan produk panen Anda untuk berjualan di marketplace SEARA.</p>
            <button class="btn-green" onclick="openModal()" style="margin:0 auto">
                <i class="fa-solid fa-plus"></i> Tambah Produk Pertama
            </button>
        </div>
        @else
        <div class="product-grid anim-3" id="productGrid">
            @foreach($harvests as $harvest)
            @php
                $emoji = match(strtolower($harvest->product->category->name ?? '')) {
                    'sayuran' => '🥬', 'buah' => '🍎', 'beras', 'palawija' => '🌾',
                    'rempah', 'bumbu' => '🌶️', default => '🌱'
                };
                $stockClass = $harvest->remaining_stock == 0 ? 'out' : ($harvest->remaining_stock <= 10 ? 'low' : '');
                $statusProduct = $harvest->product->status ?? 'tersedia';
            @endphp
            <div class="product-card"
                data-name="{{ strtolower($harvest->product->name) }}"
                data-category="{{ $harvest->product->category->name ?? '' }}"
                data-stock="{{ $harvest->remaining_stock == 0 ? 'out' : ($harvest->remaining_stock <= 10 ? 'low' : 'available') }}">

                <div class="pc-badge">
                    @if($harvest->is_organic)
                    <span class="badge-organic"><i class="fa-solid fa-leaf"></i> Organik</span>
                    @endif
                    @if($statusProduct === 'pre-order')
                    <span class="badge-preorder">Pre-Order</span>
                    @elseif($harvest->remaining_stock == 0 || $statusProduct === 'habis')
                    <span class="badge-out">Habis</span>
                    @elseif($harvest->remaining_stock <= 10)
                    <span class="badge-low">Menipis</span>
                    @endif
                </div>

                <a href="{{ route('buyer.product.show', $harvest->product->id) }}" class="pc-thumb" title="Lihat detail produk">
                    @if($harvest->product->photo)
                        <img src="{{ asset('storage/' . $harvest->product->photo) }}" alt="{{ $harvest->product->name }}">
                    @else
                        {{ $emoji }}
                    @endif
                </a>

                <div class="pc-body">
                    <div class="pc-category">{{ $harvest->product->category->name ?? 'Umum' }}</div>
                    <a href="{{ route('buyer.product.show', $harvest->product->id) }}" class="pc-name" style="text-decoration:none;color:inherit;display:block;">{{ $harvest->product->name }}</a>
                    <div class="pc-harvest">
                        <i class="fa-regular fa-calendar"></i>
                        Panen: {{ \Carbon\Carbon::parse($harvest->harvest_date)->isoFormat('D MMM YYYY') }}
                    </div>

                    {{-- Tags pertanian --}}
                    @if($harvest->metode_tanam || $harvest->kondisi_produk || $harvest->kebun_lokasi)
                    <div class="pc-agri-tags">
                        @if($harvest->metode_tanam)
                        <span class="pc-tag metode"><i class="fa-solid fa-seedling"></i> {{ ucfirst($harvest->metode_tanam) }}</span>
                        @endif
                        @if($harvest->kondisi_produk)
                        <span class="pc-tag kondisi">{{ strtoupper(str_replace('_', ' ', $harvest->kondisi_produk)) }}</span>
                        @endif
                        @if($harvest->kebun_lokasi)
                        <span class="pc-tag"><i class="fa-solid fa-location-dot"></i> {{ Str::limit($harvest->kebun_lokasi, 18) }}</span>
                        @endif
                    </div>
                    @endif

                    <div class="pc-meta">
                        <div class="pc-price">
                            Rp {{ number_format($harvest->price_per_unit, 0, ',', '.') }}
                            <span>/ {{ $harvest->product->unit ?? 'unit' }}</span>
                        </div>
                        <div class="pc-stock {{ $stockClass }}">
                            {{ number_format($harvest->remaining_stock) }} {{ $harvest->product->unit ?? 'unit' }}
                        </div>
                    </div>
                    <div class="pc-actions">
                        <button class="pc-btn edit" onclick="openEditModal({{ $harvest->id }},
                            '{{ addslashes($harvest->product->name) }}',
                            {{ $harvest->product->category_id ?? 'null' }},
                            '{{ $harvest->product->unit ?? '' }}',
                            '{{ addslashes($harvest->product->description ?? '') }}',
                            '{{ $harvest->product->status ?? 'tersedia' }}',
                            '{{ $harvest->harvest_date }}',
                            {{ $harvest->remaining_stock }},
                            {{ $harvest->price_per_unit }},
                            {{ $harvest->is_organic ? 'true' : 'false' }},
                            '{{ addslashes($harvest->kebun_lokasi ?? '') }}',
                            '{{ $harvest->metode_tanam ?? '' }}',
                            {{ $harvest->masa_simpan_hari ?? 'null' }},
                            '{{ $harvest->kondisi_produk ?? '' }}',
                            {{ $harvest->berat_bersih ?? 'null' }},
                            {{ $harvest->minimal_pembelian ?? 1 }},
                            '{{ $harvest->product->photo ? asset('storage/' . $harvest->product->photo) : '' }}'
                        )">
                            <i class="fa-solid fa-pen"></i> Edit
                        </button>
                        <button class="pc-btn delete" onclick="confirmDelete({{ $harvest->id }}, '{{ $harvest->product->name }}')">
                            <i class="fa-solid fa-trash"></i> Hapus
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($harvests->hasPages())
        <div class="pagination-wrap">
            {{ $harvests->links() }}
        </div>
        @endif
        @endif

    </main>
</div>

<!-- ══ MODAL TAMBAH/EDIT ══ -->
<div class="modal-overlay" id="modalOverlay" onclick="closeModalOnBg(event)">
    <div class="modal">
        <div class="modal-head">
            <h2 id="modalTitle"><i class="fa-solid fa-plus" style="color:var(--green-main)"></i> Tambah Produk</h2>
            <button class="modal-close" onclick="closeModal()"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form id="productForm" method="POST" action="{{ route('seller.products.store') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            <input type="hidden" name="harvest_id" id="harvestId">
            <div class="modal-body">

                {{-- ══ SECTION 1: DATA UTAMA PRODUK ══ --}}
                <div class="form-section">
                    <div class="form-section-title">
                        <i class="fa-solid fa-box"></i> Data Utama Produk
                    </div>

                    <div class="form-group">
                        <label class="form-label">Nama Produk <span class="req">*</span></label>
                        <input type="text" name="product_name" id="productName" class="form-input"
                            placeholder="cth: Tomat Merah, Cabai Hijau, Bayam..." required>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Kategori <span class="req">*</span></label>
                            <select name="category_id" id="categorySelect" class="form-select" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Satuan <span class="req">*</span></label>
                            <select name="unit" id="unitInput" class="form-select" required>
                                <option value="">-- Pilih Satuan --</option>
                                <option value="kg">kg</option>
                                <option value="gram">gram</option>
                                <option value="ikat">ikat</option>
                                <option value="karung">karung</option>
                                <option value="liter">liter</option>
                                <option value="buah">buah</option>
                                <option value="lusin">lusin</option>
                                <option value="pak">pak</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Deskripsi Produk</label>
                        <textarea name="description" id="productDescription" class="form-textarea"
                            placeholder="Ceritakan keunggulan produk Anda, cara tanam, dsb..."></textarea>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Harga per Satuan (Rp) <span class="req">*</span></label>
                            <input type="number" name="price_per_unit" id="pricePerUnit" class="form-input"
                                placeholder="cth: 8000" min="0" step="100" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Stok <span class="req">*</span></label>
                            <input type="number" name="remaining_stock" id="remainingStock" class="form-input"
                                placeholder="cth: 50" min="0" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Status Produk <span class="req">*</span></label>
                            <select name="status" id="productStatus" class="form-select" required>
                                <option value="tersedia">✅ Tersedia</option>
                                <option value="habis">❌ Habis</option>
                                <option value="pre-order">🕐 Pre-Order</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Foto Produk</label>
                            <div class="photo-upload-area" onclick="document.getElementById('photoInput').click()">
                                <input type="file" name="photo" id="photoInput" accept="image/*"
                                    onchange="previewPhoto(this)" style="display:none">
                                <i class="fa-solid fa-camera"></i>
                                <p>Klik untuk upload foto</p>
                                <img id="photoPreview" class="photo-preview" alt="Preview">
                            </div>
                            <span class="form-hint">JPG/PNG/WEBP, maks. 2MB</span>
                        </div>
                    </div>
                </div>

                {{-- ══ SECTION 2: DATA KHUSUS PERTANIAN ══ --}}
                <div class="form-section">
                    <div class="form-section-title">
                        <i class="fa-solid fa-tractor"></i> Data Khusus Pertanian
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Tanggal Panen <span class="req">*</span></label>
                            <input type="date" name="harvest_date" id="harvestDate" class="form-input" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Lokasi Kebun</label>
                            <input type="text" name="kebun_lokasi" id="kebunLokasi" class="form-input"
                                placeholder="cth: Lembang, Bandung Barat">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Metode Tanam</label>
                            <select name="metode_tanam" id="metodeTanam" class="form-select">
                                <option value="">-- Pilih Metode --</option>
                                <option value="organik">🌿 Organik</option>
                                <option value="hidroponik">💧 Hidroponik</option>
                                <option value="konvensional">🌾 Konvensional</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Kondisi Produk</label>
                            <select name="kondisi_produk" id="kondisiProduk" class="form-select">
                                <option value="">-- Pilih Kondisi --</option>
                                <option value="fresh">🟢 Fresh</option>
                                <option value="grade_a">🅰️ Grade A</option>
                                <option value="grade_b">🅱️ Grade B</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row-3">
                        <div class="form-group">
                            <label class="form-label">Masa Simpan (hari)</label>
                            <input type="number" name="masa_simpan_hari" id="masaSimpan" class="form-input"
                                placeholder="cth: 7" min="1">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Berat Bersih (kg)</label>
                            <input type="number" name="berat_bersih" id="beratBersih" class="form-input"
                                placeholder="cth: 0.5" min="0" step="0.01">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Min. Pembelian</label>
                            <input type="number" name="minimal_pembelian" id="minimalPembelian" class="form-input"
                                placeholder="cth: 1" min="1" value="1">
                        </div>
                    </div>

                    <div class="toggle-wrap" onclick="document.getElementById('isOrganic').click()">
                        <input type="checkbox" name="is_organic" id="isOrganic" value="1"
                            style="width:18px;height:18px;accent-color:var(--green-main)">
                        <label for="isOrganic">
                            <i class="fa-solid fa-leaf" style="color:var(--green-main)"></i>
                            Tandai sebagai Produk Organik (tanpa pestisida/kimia)
                        </label>
                    </div>
                </div>

            </div>
            <div class="modal-foot">
                <button type="button" class="btn-outline" onclick="closeModal()">Batal</button>
                <button type="submit" class="btn-green"><i class="fa-solid fa-floppy-disk"></i> Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- ══ MODAL KONFIRMASI HAPUS ══ -->
<div class="modal-overlay" id="deleteOverlay" onclick="closeDeleteOnBg(event)">
    <div class="modal" style="max-width:400px">
        <div class="modal-head">
            <h2><i class="fa-solid fa-trash" style="color:#b91c1c"></i> Hapus Produk</h2>
            <button class="modal-close" onclick="closeDelete()"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="modal-body">
            <p style="font-size:14px;font-weight:600;color:var(--text-mid)">Apakah Anda yakin ingin menghapus produk <strong id="deleteProductName"></strong>? Tindakan ini tidak dapat dibatalkan.</p>
        </div>
        <div class="modal-foot">
            <button class="btn-outline" onclick="closeDelete()">Batal</button>
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" style="padding:9px 18px;background:#b91c1c;border:none;border-radius:10px;font-family:'Nunito',sans-serif;font-weight:800;font-size:13px;color:white;cursor:pointer">
                    <i class="fa-solid fa-trash"></i> Hapus
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Toast -->
<div class="toast" id="toast"><i class="fa-solid fa-circle-check"></i> <span id="toastMsg">Berhasil!</span></div>

<script>
// ── Photo preview ──
function previewPhoto(input) {
    const preview = document.getElementById('photoPreview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// ── Reset form ──
function resetForm() {
    document.getElementById('productName').value = '';
    document.getElementById('categorySelect').value = '';
    document.getElementById('unitInput').value = '';
    document.getElementById('productDescription').value = '';
    document.getElementById('pricePerUnit').value = '';
    document.getElementById('remainingStock').value = '';
    document.getElementById('productStatus').value = 'tersedia';
    document.getElementById('photoInput').value = '';
    document.getElementById('photoPreview').style.display = 'none';
    document.getElementById('harvestDate').value = '';
    document.getElementById('kebunLokasi').value = '';
    document.getElementById('metodeTanam').value = '';
    document.getElementById('kondisiProduk').value = '';
    document.getElementById('masaSimpan').value = '';
    document.getElementById('beratBersih').value = '';
    document.getElementById('minimalPembelian').value = '1';
    document.getElementById('isOrganic').checked = false;
}

// ── Modal Tambah ──
function openModal() {
    document.getElementById('modalTitle').innerHTML = '<i class="fa-solid fa-plus" style="color:var(--green-main)"></i> Tambah Produk';
    document.getElementById('productForm').action = '{{ route("seller.products.store") }}';
    document.getElementById('formMethod').value = 'POST';
    resetForm();
    document.getElementById('modalOverlay').classList.add('open');
}

// ── Modal Edit ──
function openEditModal(id, productName, categoryId, unit, description, status,
                       harvestDate, stock, price, isOrganic,
                       kebunLokasi, metodeTanam, masaSimpan, kondisiProduk,
                       beratBersih, minimalPembelian, photoUrl) {
    document.getElementById('modalTitle').innerHTML = '<i class="fa-solid fa-pen" style="color:var(--green-main)"></i> Edit Produk';
    document.getElementById('productForm').action = `/seller/produk/${id}`;
    document.getElementById('formMethod').value = 'PUT';

    document.getElementById('productName').value       = productName;
    document.getElementById('categorySelect').value    = categoryId;
    document.getElementById('unitInput').value         = unit;
    document.getElementById('productDescription').value= description;
    document.getElementById('productStatus').value     = status;
    document.getElementById('harvestDate').value       = harvestDate.substring(0, 10);
    document.getElementById('remainingStock').value    = stock;
    document.getElementById('pricePerUnit').value      = price;
    document.getElementById('isOrganic').checked       = isOrganic;
    document.getElementById('kebunLokasi').value       = kebunLokasi;
    document.getElementById('metodeTanam').value       = metodeTanam;
    document.getElementById('masaSimpan').value        = masaSimpan || '';
    document.getElementById('kondisiProduk').value     = kondisiProduk;
    document.getElementById('beratBersih').value       = beratBersih || '';
    document.getElementById('minimalPembelian').value  = minimalPembelian;

    // Tampilkan foto existing jika ada
    const preview = document.getElementById('photoPreview');
    if (photoUrl) {
        preview.src = photoUrl;
        preview.style.display = 'block';
    } else {
        preview.style.display = 'none';
    }

    document.getElementById('modalOverlay').classList.add('open');
}

function closeModal() { document.getElementById('modalOverlay').classList.remove('open'); }
function closeModalOnBg(e) { if (e.target.id === 'modalOverlay') closeModal(); }

// ── Modal Hapus ──
function confirmDelete(id, name) {
    document.getElementById('deleteProductName').textContent = name;
    document.getElementById('deleteForm').action = `/seller/produk/${id}`;
    document.getElementById('deleteOverlay').classList.add('open');
}
function closeDelete() { document.getElementById('deleteOverlay').classList.remove('open'); }
function closeDeleteOnBg(e) { if (e.target.id === 'deleteOverlay') closeDelete(); }

// ── Filter produk ──
function filterProducts() {
    const q      = document.getElementById('searchInput').value.toLowerCase();
    const cat    = document.getElementById('filterCategory').value;
    const stockF = document.getElementById('filterStock').value;
    document.querySelectorAll('#productGrid .product-card').forEach(card => {
        const name    = card.dataset.name;
        const cardCat = card.dataset.category;
        const stock   = card.dataset.stock;
        const show = (!q || name.includes(q))
                  && (!cat || cardCat === cat)
                  && (!stockF || stock === stockF);
        card.style.display = show ? '' : 'none';
    });
}

// ── Auto dismiss alert ──
@if(session('success') || session('error'))
setTimeout(() => {
    document.querySelectorAll('.alert').forEach(el => {
        el.style.transition = 'opacity .5s';
        el.style.opacity = '0';
    });
}, 4000);
@endif
</script>

</body>
</html>