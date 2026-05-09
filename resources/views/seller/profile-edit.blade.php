<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Toko – SEARA</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('assets/LOGO_FIKS_LIGHT.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        :root {
            --green-dark: #1a4731; --green-main: #2d8653; --green-mid: #3dba7e;
            --green-light: #52dda0; --green-pale: #f0fdf6; --accent: #e05c2e;
            --accent-soft: #fff0eb; --yellow: #f5a623; --yellow-soft: #fffbeb;
            --blue: #2563eb; --blue-soft: #eff6ff; --text-dark: #0f2419;
            --text-mid: #3d5c49; --text-muted: #7a9585; --border: #e2ece7;
            --white: #ffffff; --bg: #f5f9f6; --r: 14px;
            --shadow-sm: 0 1px 4px rgba(0,0,0,.06);
            --shadow-md: 0 4px 18px rgba(0,0,0,.09);
        }
        *{box-sizing:border-box;margin:0;padding:0}
        body{background:var(--bg);font-family:'Nunito',sans-serif;color:var(--text-dark)}
        .seller-wrap{display:flex;min-height:100vh}
        .seller-main{flex:1;padding:24px;overflow-x:hidden}
        .page-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:22px}
        .page-header-left h1{font-family:'Playfair Display',serif;font-size:26px;font-weight:700;color:var(--text-dark)}
        .page-header-left p{font-size:13px;color:var(--text-muted);margin-top:3px;font-weight:600}

        .alert{padding:12px 18px;border-radius:10px;font-size:13px;font-weight:700;margin-bottom:18px;display:flex;align-items:center;gap:10px}
        .alert-success{background:#f0fdf4;border:1px solid #bbf7d0;color:var(--green-dark)}
        .alert-error{background:#fef2f2;border:1px solid #fecaca;color:#991b1b}

        .card{background:white;border:1px solid var(--border);border-radius:var(--r);overflow:hidden;margin-bottom:20px}
        .card-head{padding:18px 22px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:10px}
        .card-head h2{font-size:15px;font-weight:900;color:var(--text-dark)}
        .card-head i{color:var(--green-main)}
        .card-body{padding:22px}

        .form-group{margin-bottom:16px}
        .form-label{display:block;font-size:12px;font-weight:800;color:var(--text-mid);margin-bottom:5px}
        .form-label .req{color:var(--accent)}
        .form-input,.form-select,.form-textarea{width:100%;padding:10px 13px;border:1.5px solid var(--border);border-radius:9px;font-family:'Nunito',sans-serif;font-size:13px;color:var(--text-dark);background:white;outline:none;transition:border-color .2s}
        .form-input:focus,.form-select:focus,.form-textarea:focus{border-color:var(--green-main);box-shadow:0 0 0 3px rgba(45,134,83,.1)}
        .form-textarea{resize:vertical;min-height:90px}
        .form-row{display:grid;grid-template-columns:1fr 1fr;gap:14px}
        .form-hint{font-size:11px;color:var(--text-muted);font-weight:600;margin-top:3px}

        .photo-upload-area{border:2px dashed var(--border);border-radius:10px;padding:20px;text-align:center;cursor:pointer;transition:all .2s;position:relative}
        .photo-upload-area:hover{border-color:var(--green-main);background:var(--green-pale)}
        .photo-upload-area input[type=file]{position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%}
        .photo-upload-area i{font-size:24px;color:var(--text-muted);margin-bottom:6px;display:block}
        .photo-upload-area p{font-size:12px;font-weight:700;color:var(--text-muted)}
        .photo-preview-img{width:100%;max-height:150px;object-fit:cover;border-radius:8px;margin-top:10px}

        .toggle-wrap{display:flex;align-items:center;gap:12px;padding:14px;background:var(--green-pale);border-radius:9px;cursor:pointer}
        .toggle-wrap label{font-size:13px;font-weight:700;color:var(--green-dark);cursor:pointer;display:flex;align-items:center;gap:6px}

        .btn-green{padding:10px 22px;background:linear-gradient(135deg,var(--green-mid),var(--green-main));border:none;border-radius:10px;font-family:'Nunito',sans-serif;font-weight:800;font-size:14px;color:white;cursor:pointer;transition:all .2s;display:inline-flex;align-items:center;gap:7px;box-shadow:0 4px 12px rgba(61,186,126,.25)}
        .btn-green:hover{transform:translateY(-1px);box-shadow:0 8px 20px rgba(61,186,126,.3)}
        .btn-outline-sm{padding:10px 18px;border:1.5px solid var(--border);border-radius:10px;background:white;font-family:'Nunito',sans-serif;font-weight:700;font-size:13px;color:var(--text-mid);cursor:pointer;transition:all .2s;display:inline-flex;align-items:center;gap:7px;text-decoration:none}
        .btn-outline-sm:hover{border-color:var(--green-main);color:var(--green-dark)}

        .status-badge{display:inline-flex;align-items:center;gap:6px;padding:6px 14px;border-radius:20px;font-size:12px;font-weight:800}
        .status-open{background:#f0fdf4;color:var(--green-dark);border:1px solid #bbf7d0}
        .status-closed{background:#fef2f2;color:#991b1b;border:1px solid #fecaca}

        .toko-banner{width:100%;height:140px;object-fit:cover;border-radius:10px;background:linear-gradient(135deg,var(--green-pale),#d1fae5);display:flex;align-items:center;justify-content:center;font-size:40px;margin-bottom:16px;overflow:hidden}

        @media(max-width:768px){
            .seller-sidebar{display:none}
            .seller-main{padding:16px}
            .form-row{grid-template-columns:1fr}
        }
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
        @if($errors->any())
        <div class="alert alert-error">
            <i class="fa-solid fa-circle-xmark"></i>
            <div>@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
        </div>
        @endif

        <div class="page-header">
            <div class="page-header-left">
                <h1>Profil Toko <i class="fa-solid fa-store" style="font-size:22px;color:var(--green-main)"></i></h1>
                <p>Kelola informasi toko dan identitas petani Anda.</p>
            </div>
            <div style="display:flex;gap:10px;align-items:center">
                <span class="status-badge {{ $sellerProfile->is_open ? 'status-open' : 'status-closed' }}">
                    <i class="fa-solid fa-circle" style="font-size:8px"></i>
                    {{ $sellerProfile->is_open ? 'Toko Buka' : 'Toko Tutup' }}
                </span>
                <form method="POST" action="{{ route('seller.profile.toggle') }}">
                    @csrf
                    <button type="submit" class="btn-outline-sm">
                        <i class="fa-solid fa-power-off"></i>
                        {{ $sellerProfile->is_open ? 'Tutup Toko' : 'Buka Toko' }}
                    </button>
                </form>
            </div>
        </div>

        <form method="POST" action="{{ route('seller.profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- ══ INFO TOKO ══ --}}
            <div class="card">
                <div class="card-head">
                    <i class="fa-solid fa-store"></i>
                    <h2>Informasi Toko</h2>
                </div>
                <div class="card-body">

                    {{-- Banner --}}
                    <div class="form-group">
                        <label class="form-label">Banner Toko</label>
                        @if($sellerProfile->banner_toko ?? null)
                            <img src="{{ asset('storage/' . $sellerProfile->banner_toko) }}" class="photo-preview-img" style="max-height:140px;width:100%;object-fit:cover;border-radius:10px;margin-bottom:10px" alt="Banner">
                        @else
                            <div style="width:100%;height:100px;background:linear-gradient(135deg,var(--green-pale),#d1fae5);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:32px;margin-bottom:10px">🌿</div>
                        @endif
                        <div class="photo-upload-area" onclick="document.getElementById('bannerInput').click()">
                            <input type="file" name="banner_toko" id="bannerInput" accept="image/*" onchange="previewImg(this,'bannerPreview')" style="display:none">
                            <i class="fa-solid fa-image"></i>
                            <p>Klik untuk ganti banner (maks. 8MB)</p>
                            <img id="bannerPreview" class="photo-preview-img" style="display:none" alt="Preview">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Nama Toko <span class="req">*</span></label>
                        <input type="text" name="nama_toko" class="form-input" value="{{ old('nama_toko', $sellerProfile->nama_toko) }}" required placeholder="cth: Tani Segar Pak Budi">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Deskripsi Toko</label>
                        <textarea name="deskripsi_toko" class="form-textarea" placeholder="Ceritakan tentang toko dan produk unggulan Anda...">{{ old('deskripsi_toko', $sellerProfile->deskripsi_toko) }}</textarea>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Kategori Utama</label>
                            <select name="kategori_utama" class="form-select">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach(['Sayuran','Buah','Beras & Palawija','Rempah & Bumbu','Tanaman Hias','Lainnya'] as $kat)
                                <option value="{{ $kat }}" {{ old('kategori_utama', $sellerProfile->kategori_utama) === $kat ? 'selected' : '' }}>{{ $kat }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Foto Profil Toko</label>
                            <div class="photo-upload-area" onclick="document.getElementById('fotoInput').click()">
                                <input type="file" name="foto_toko" id="fotoInput" accept="image/*" onchange="previewImg(this,'fotoPreview')" style="display:none">
                                @if($sellerProfile->foto_toko)
                                    <img src="{{ asset('storage/' . $sellerProfile->foto_toko) }}" class="photo-preview-img" alt="Foto Toko">
                                @else
                                    <i class="fa-solid fa-camera"></i>
                                    <p>Upload foto toko</p>
                                @endif
                                <img id="fotoPreview" class="photo-preview-img" style="display:none" alt="Preview">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ══ LOKASI ══ --}}
            <div class="card">
                <div class="card-head">
                    <i class="fa-solid fa-location-dot"></i>
                    <h2>Lokasi Toko</h2>
                </div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Provinsi</label>
                            <input type="text" name="provinsi" class="form-input" value="{{ old('provinsi', $sellerProfile->provinsi) }}" placeholder="cth: Jawa Barat">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Kota / Kabupaten</label>
                            <input type="text" name="kota_kabupaten" class="form-input" value="{{ old('kota_kabupaten', $sellerProfile->kota_kabupaten) }}" placeholder="cth: Bandung Barat">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Alamat Lengkap</label>
                        <textarea name="alamat_toko" class="form-textarea" placeholder="Jl. Raya Lembang No. 10...">{{ old('alamat_toko', $sellerProfile->alamat_toko) }}</textarea>
                    </div>
                </div>
            </div>

            {{-- ══ TOMBOL SIMPAN ══ --}}
            <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:4px">
                <a href="{{ route('seller.dashboard') }}" class="btn-outline-sm">
                    <i class="fa-solid fa-arrow-left"></i> Kembali
                </a>
                <button type="submit" class="btn-green">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                </button>
            </div>

        </form>
    </main>
</div>

<script>
function previewImg(input, previewId) {
    const preview = document.getElementById(previewId);
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => { preview.src = e.target.result; preview.style.display = 'block'; };
        reader.readAsDataURL(input.files[0]);
    }
}
@if(session('success') || session('error'))
setTimeout(() => {
    document.querySelectorAll('.alert').forEach(el => { el.style.transition='opacity .5s'; el.style.opacity='0'; });
}, 4000);
@endif
</script>
</body>
</html>
