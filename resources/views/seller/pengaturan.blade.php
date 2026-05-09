<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan – SEARA</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('assets/LOGO_FIKS_LIGHT.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        :root {
            --green-dark:  #1a4731;
            --green-main:  #2d8653;
            --green-mid:   #3dba7e;
            --green-light: #52dda0;
            --green-pale:  #f0fdf6;
            --accent:      #e05c2e;
            --accent-soft: #fff0eb;
            --yellow:      #f5a623;
            --yellow-soft: #fffbeb;
            --blue:        #2563eb;
            --blue-soft:   #eff6ff;
            --red:         #dc2626;
            --red-soft:    #fef2f2;
            --text-dark:   #0f2419;
            --text-mid:    #3d5c49;
            --text-muted:  #7a9585;
            --border:      #e2ece7;
            --white:       #ffffff;
            --bg:          #f5f9f6;
            --r:           14px;
            --shadow-sm:   0 1px 4px rgba(0,0,0,.06);
            --shadow-md:   0 4px 18px rgba(0,0,0,.09);
        }
        *{box-sizing:border-box;margin:0;padding:0}
        body{background:var(--bg);font-family:'Nunito',sans-serif;color:var(--text-dark)}

        /* ── Layout ──────────────────────────────────────────────────── */
        .seller-wrap{display:flex;min-height:100vh}
        .seller-main{flex:1;padding:24px;overflow-x:hidden}

        /* ── Page Header ─────────────────────────────────────────────── */
        .page-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px}
        .page-header-left h1{font-family:'Playfair Display',serif;font-size:26px;font-weight:700;color:var(--text-dark)}
        .page-header-left p{font-size:13px;color:var(--text-muted);margin-top:3px;font-weight:600}

        /* ── Alert ───────────────────────────────────────────────────── */
        .alert{padding:12px 18px;border-radius:10px;font-size:13px;font-weight:700;margin-bottom:18px;display:flex;align-items:center;gap:10px}
        .alert-success{background:#f0fdf4;border:1px solid #bbf7d0;color:var(--green-dark)}
        .alert-error{background:var(--red-soft);border:1px solid #fecaca;color:#991b1b}

        /* ── Buttons ─────────────────────────────────────────────────── */
        .btn-green{padding:9px 18px;background:linear-gradient(135deg,var(--green-mid),var(--green-main));border:none;border-radius:10px;font-family:'Nunito',sans-serif;font-weight:800;font-size:13px;color:white;cursor:pointer;transition:all .2s;display:inline-flex;align-items:center;gap:6px;box-shadow:0 4px 12px rgba(61,186,126,.25)}
        .btn-green:hover{transform:translateY(-1px);box-shadow:0 8px 20px rgba(61,186,126,.3)}
        .btn-outline{padding:9px 18px;border:1.5px solid var(--border);border-radius:10px;background:white;font-family:'Nunito',sans-serif;font-weight:700;font-size:13px;color:var(--text-mid);cursor:pointer;transition:all .2s;display:inline-flex;align-items:center;gap:6px}
        .btn-outline:hover{border-color:var(--green-main);color:var(--green-dark)}
        .btn-danger{padding:9px 18px;background:var(--red-soft);border:1.5px solid #fecaca;border-radius:10px;font-family:'Nunito',sans-serif;font-weight:800;font-size:13px;color:var(--red);cursor:pointer;transition:all .2s;display:inline-flex;align-items:center;gap:6px}
        .btn-danger:hover{background:#fee2e2;border-color:var(--red)}

        /* ── Two-col layout ──────────────────────────────────────────── */
        .settings-layout{display:grid;grid-template-columns:220px 1fr;gap:20px;align-items:start}

        /* ── Nav tabs (kiri) ─────────────────────────────────────────── */
        .settings-nav{background:white;border:1px solid var(--border);border-radius:var(--r);padding:8px;position:sticky;top:20px}
        .nav-item{display:flex;align-items:center;gap:10px;padding:10px 12px;border-radius:10px;font-size:13px;font-weight:700;color:var(--text-mid);cursor:pointer;border:none;background:none;width:100%;text-align:left;font-family:'Nunito',sans-serif;transition:all .18s}
        .nav-item:hover{background:var(--green-pale);color:var(--green-dark)}
        .nav-item.active{background:linear-gradient(135deg,var(--green-pale),#d1fae5);color:var(--green-dark)}
        .nav-item .ni-icon{width:30px;height:30px;border-radius:8px;background:var(--green-pale);display:flex;align-items:center;justify-content:center;font-size:13px;color:var(--green-dark);flex-shrink:0;transition:background .18s}
        .nav-item:hover .ni-icon,.nav-item.active .ni-icon{background:#c6f6d5}
        .nav-item.danger{color:var(--red)}
        .nav-item.danger .ni-icon{background:var(--red-soft);color:var(--red)}
        .nav-item.danger:hover{background:var(--red-soft)}
        .nav-divider{height:1px;background:var(--border);margin:6px 0}

        /* ── Panels (kanan) ──────────────────────────────────────────── */
        .settings-panel{display:none}
        .settings-panel.active{display:block}

        /* ── Section card ────────────────────────────────────────────── */
        .section-card{background:white;border:1px solid var(--border);border-radius:var(--r);margin-bottom:16px;overflow:hidden}
        .section-head{display:flex;align-items:center;gap:10px;padding:16px 20px;border-bottom:1px solid var(--border);background:var(--green-pale)}
        .section-head-icon{width:34px;height:34px;border-radius:9px;background:white;display:flex;align-items:center;justify-content:center;font-size:14px;color:var(--green-dark);box-shadow:var(--shadow-sm)}
        .section-head h2{font-size:14px;font-weight:900;color:var(--green-dark)}
        .section-head p{font-size:11px;color:var(--text-muted);font-weight:600;margin-top:1px}
        .section-body{padding:20px}

        /* ── Form elements ───────────────────────────────────────────── */
        .form-group{margin-bottom:16px}
        .form-group:last-child{margin-bottom:0}
        .form-label{display:block;font-size:12px;font-weight:800;color:var(--text-mid);margin-bottom:6px}
        .form-label .req{color:var(--accent)}
        .form-label .badge-info{font-size:10px;font-weight:700;background:var(--blue-soft);color:var(--blue);padding:1px 6px;border-radius:8px;margin-left:4px}
        .form-input,.form-select,.form-textarea{width:100%;padding:10px 13px;border:1.5px solid var(--border);border-radius:9px;font-family:'Nunito',sans-serif;font-size:13px;color:var(--text-dark);background:white;outline:none;transition:border-color .2s}
        .form-input:focus,.form-select:focus,.form-textarea:focus{border-color:var(--green-main);box-shadow:0 0 0 3px rgba(45,134,83,.08)}
        .form-input:disabled{background:var(--bg);color:var(--text-muted);cursor:not-allowed}
        .form-hint{font-size:11px;color:var(--text-muted);font-weight:600;margin-top:4px;display:flex;align-items:center;gap:4px}
        .form-row{display:grid;grid-template-columns:1fr 1fr;gap:14px}
        .form-footer{display:flex;justify-content:flex-end;gap:10px;padding-top:16px;border-top:1px solid var(--border);margin-top:4px}

        /* ── Password strength ───────────────────────────────────────── */
        .pw-wrap{position:relative}
        .pw-toggle{position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--text-muted);font-size:13px;padding:4px}
        .pw-strength{margin-top:6px;height:4px;border-radius:3px;background:var(--border);overflow:hidden}
        .pw-strength-fill{height:100%;border-radius:3px;transition:all .3s;width:0}
        .pw-strength-fill.weak{width:33%;background:#ef4444}
        .pw-strength-fill.medium{width:66%;background:var(--yellow)}
        .pw-strength-fill.strong{width:100%;background:var(--green-mid)}
        .pw-strength-label{font-size:10px;font-weight:700;margin-top:3px}

        /* ── Toggle switch ───────────────────────────────────────────── */
        .toggle-row{display:flex;align-items:center;justify-content:space-between;padding:14px 0;border-bottom:1px solid var(--border)}
        .toggle-row:last-child{border-bottom:none;padding-bottom:0}
        .toggle-row:first-child{padding-top:0}
        .toggle-info{flex:1;padding-right:16px}
        .toggle-info strong{display:block;font-size:13px;font-weight:800;color:var(--text-dark);margin-bottom:2px}
        .toggle-info span{font-size:11px;font-weight:600;color:var(--text-muted)}
        .switch{position:relative;width:42px;height:24px;flex-shrink:0}
        .switch input{opacity:0;width:0;height:0}
        .switch-slider{position:absolute;inset:0;background:var(--border);border-radius:24px;cursor:pointer;transition:background .25s}
        .switch-slider::before{content:'';position:absolute;width:18px;height:18px;left:3px;top:3px;background:white;border-radius:50%;transition:transform .25s;box-shadow:0 1px 3px rgba(0,0,0,.2)}
        .switch input:checked+.switch-slider{background:var(--green-main)}
        .switch input:checked+.switch-slider::before{transform:translateX(18px)}

        /* ── Danger zone ─────────────────────────────────────────────── */
        .danger-section{background:var(--red-soft);border:1px solid #fecaca;border-radius:var(--r);padding:20px;margin-bottom:16px}
        .danger-section h3{font-size:14px;font-weight:900;color:var(--red);margin-bottom:4px;display:flex;align-items:center;gap:7px}
        .danger-section p{font-size:13px;font-weight:600;color:#7f1d1d;margin-bottom:14px}

        /* ── Avatar upload ───────────────────────────────────────────── */
        .avatar-row{display:flex;align-items:center;gap:16px;padding:4px 0 16px}
        .avatar-circle{width:72px;height:72px;border-radius:50%;background:linear-gradient(135deg,var(--green-dark),#1e5c38);display:flex;align-items:center;justify-content:center;font-size:26px;font-weight:900;color:white;flex-shrink:0;border:3px solid white;box-shadow:var(--shadow-sm)}
        .avatar-actions{display:flex;flex-direction:column;gap:7px}
        .avatar-actions .btn-outline{font-size:12px;padding:7px 14px}

        /* ── Session list ────────────────────────────────────────────── */
        .session-item{display:flex;align-items:center;gap:12px;padding:12px 0;border-bottom:1px solid var(--border)}
        .session-item:last-child{border-bottom:none;padding-bottom:0}
        .session-item:first-child{padding-top:0}
        .session-icon{width:36px;height:36px;border-radius:9px;background:var(--green-pale);display:flex;align-items:center;justify-content:center;font-size:15px;color:var(--green-dark);flex-shrink:0}
        .session-info{flex:1}
        .session-info strong{display:block;font-size:13px;font-weight:800;color:var(--text-dark)}
        .session-info span{font-size:11px;font-weight:600;color:var(--text-muted)}
        .session-current{font-size:10px;font-weight:800;background:#dcfce7;color:#166534;padding:2px 8px;border-radius:10px}

        /* ── Animations ──────────────────────────────────────────────── */
        @keyframes fadeUp{from{opacity:0;transform:translateY(14px)}to{opacity:1;transform:translateY(0)}}
        .anim-1{animation:fadeUp .45s ease both}
        .anim-2{animation:fadeUp .45s .07s ease both}

        /* ── Modal ───────────────────────────────────────────────────── */
        .modal-overlay{position:fixed;inset:0;background:rgba(0,0,0,.45);z-index:1000;display:flex;align-items:center;justify-content:center;padding:20px;opacity:0;pointer-events:none;transition:opacity .25s}
        .modal-overlay.open{opacity:1;pointer-events:auto}
        .modal{background:white;border-radius:16px;width:100%;max-width:400px;overflow:hidden;transform:translateY(20px);transition:transform .25s;box-shadow:0 20px 60px rgba(0,0,0,.18)}
        .modal-overlay.open .modal{transform:translateY(0)}
        .modal-head{display:flex;align-items:center;justify-content:space-between;padding:18px 22px;border-bottom:1px solid var(--border)}
        .modal-head h2{font-size:16px;font-weight:900;color:var(--text-dark);display:flex;align-items:center;gap:8px}
        .modal-close{background:none;border:none;cursor:pointer;font-size:16px;color:var(--text-muted);padding:4px;border-radius:6px;transition:color .18s}
        .modal-close:hover{color:var(--text-dark)}
        .modal-body{padding:22px}
        .modal-foot{display:flex;gap:10px;justify-content:flex-end;padding:16px 22px;border-top:1px solid var(--border);background:#fafcfa}

        @media(max-width:900px){.settings-layout{grid-template-columns:1fr}.settings-nav{position:static;display:flex;flex-wrap:wrap;gap:4px;padding:10px}}
        @media(max-width:768px){.seller-sidebar{display:none}.seller-main{padding:16px}.form-row{grid-template-columns:1fr}}
    </style>
</head>
<body>

<div class="seller-wrap">

    {{-- ══ SIDEBAR ══ --}}
    @include('partials.seller_sidebar')

    {{-- ══ MAIN ══ --}}
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
        @if($errors->any())
        <div class="alert alert-error anim-1">
            <i class="fa-solid fa-circle-xmark"></i> {{ $errors->first() }}
        </div>
        @endif

        {{-- ── Page Header ─────────────────────────────────────────── --}}
        <div class="page-header anim-1">
            <div class="page-header-left">
                <h1>Pengaturan <i class="fa-solid fa-gear" style="font-size:22px;color:var(--green-main)"></i></h1>
                <p>Kelola akun, keamanan, dan preferensi toko Anda.</p>
            </div>
        </div>

        {{-- ── Layout ──────────────────────────────────────────────── --}}
        <div class="settings-layout anim-2">

            {{-- ── Nav (kiri) ──────────────────────────────────────── --}}
            <nav class="settings-nav">
                <button class="nav-item active" onclick="switchPanel('akun', this)">
                    <span class="ni-icon"><i class="fa-solid fa-user"></i></span> Akun
                </button>
                <button class="nav-item" onclick="switchPanel('keamanan', this)">
                    <span class="ni-icon"><i class="fa-solid fa-shield-halved"></i></span> Keamanan
                </button>
                <button class="nav-item" onclick="switchPanel('notifikasi', this)">
                    <span class="ni-icon"><i class="fa-solid fa-bell"></i></span> Notifikasi
                </button>
                <button class="nav-item" onclick="switchPanel('toko', this)">
                    <span class="ni-icon"><i class="fa-solid fa-store"></i></span> Toko
                </button>
                <div class="nav-divider"></div>
                <button class="nav-item danger" onclick="openLogoutModal()">
                    <span class="ni-icon"><i class="fa-solid fa-right-from-bracket"></i></span> Keluar
                </button>
            </nav>

            {{-- ── Panels (kanan) ──────────────────────────────────── --}}
            <div>

                {{-- ═══ PANEL: AKUN ═══ --}}
                <div class="settings-panel active" id="panel-akun">

                    {{-- Avatar --}}
                    <div class="section-card">
                        <div class="section-head">
                            <div class="section-head-icon"><i class="fa-solid fa-image-portrait"></i></div>
                            <div>
                                <h2>Foto Profil</h2>
                                <p>Foto ditampilkan di profil toko Anda</p>
                            </div>
                        </div>
                        <div class="section-body">
                            <div class="avatar-row">
                                <div class="avatar-circle">{{ strtoupper(substr(auth()->user()->nama_lengkap ?? 'U', 0, 2)) }}</div>
                                <div class="avatar-actions">
                                    <button class="btn-outline" onclick="document.getElementById('avatarInput').click()">
                                        <i class="fa-solid fa-upload"></i> Upload Foto
                                    </button>
                                    <input type="file" id="avatarInput" accept="image/*" style="display:none">
                                    <span style="font-size:11px;font-weight:600;color:var(--text-muted)">JPG/PNG/WEBP · Maks. 2MB</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Info Pribadi --}}
                    <div class="section-card">
                        <div class="section-head">
                            <div class="section-head-icon"><i class="fa-solid fa-id-card"></i></div>
                            <div>
                                <h2>Informasi Pribadi</h2>
                                <p>Data dasar akun Anda</p>
                            </div>
                        </div>
                        <div class="section-body">
                            <form method="POST" action="{{ route('seller.settings.update.profile') }}">
                                @csrf @method('PUT')

                                <div class="form-row">
                                    <div class="form-group">
                                        <label class="form-label">Nama Lengkap <span class="req">*</span></label>
                                        <input type="text" name="nama_lengkap" class="form-input"
                                            value="{{ old('nama_lengkap', auth()->user()->nama_lengkap) }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Nomor Telepon</label>
                                        <input type="tel" name="no_telepon" class="form-input"
                                            value="{{ old('no_telepon', auth()->user()->no_telepon ?? '') }}"
                                            placeholder="cth: 08123456789">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Email <span class="badge-info">Tidak bisa diubah</span></label>
                                    <input type="email" class="form-input" value="{{ auth()->user()->email }}" disabled>
                                    <div class="form-hint"><i class="fa-solid fa-circle-info"></i> Hubungi admin untuk mengubah email</div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Alamat</label>
                                    <textarea name="alamat" class="form-textarea" rows="2"
                                        placeholder="Masukkan alamat lengkap Anda...">{{ old('alamat', auth()->user()->alamat ?? '') }}</textarea>
                                </div>

                                <div class="form-footer">
                                    <button type="submit" class="btn-green">
                                        <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- ═══ PANEL: KEAMANAN ═══ --}}
                <div class="settings-panel" id="panel-keamanan">

                    {{-- Ganti Password --}}
                    <div class="section-card">
                        <div class="section-head">
                            <div class="section-head-icon"><i class="fa-solid fa-lock"></i></div>
                            <div>
                                <h2>Ganti Password</h2>
                                <p>Gunakan password yang kuat dan unik</p>
                            </div>
                        </div>
                        <div class="section-body">
                            <form method="POST" action="{{ route('seller.settings.update.password') }}">
                                @csrf @method('PUT')

                                <div class="form-group">
                                    <label class="form-label">Password Saat Ini <span class="req">*</span></label>
                                    <div class="pw-wrap">
                                        <input type="password" name="current_password" id="pwCurrent" class="form-input"
                                            placeholder="Masukkan password lama" required style="padding-right:40px">
                                        <button type="button" class="pw-toggle" onclick="togglePw('pwCurrent', this)">
                                            <i class="fa-regular fa-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Password Baru <span class="req">*</span></label>
                                    <div class="pw-wrap">
                                        <input type="password" name="password" id="pwNew" class="form-input"
                                            placeholder="Min. 8 karakter" required style="padding-right:40px"
                                            oninput="checkStrength(this.value)">
                                        <button type="button" class="pw-toggle" onclick="togglePw('pwNew', this)">
                                            <i class="fa-regular fa-eye"></i>
                                        </button>
                                    </div>
                                    <div class="pw-strength"><div class="pw-strength-fill" id="pwFill"></div></div>
                                    <div class="pw-strength-label" id="pwLabel" style="color:var(--text-muted)"></div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Konfirmasi Password Baru <span class="req">*</span></label>
                                    <div class="pw-wrap">
                                        <input type="password" name="password_confirmation" id="pwConfirm" class="form-input"
                                            placeholder="Ulangi password baru" required style="padding-right:40px">
                                        <button type="button" class="pw-toggle" onclick="togglePw('pwConfirm', this)">
                                            <i class="fa-regular fa-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="form-footer">
                                    <button type="submit" class="btn-green">
                                        <i class="fa-solid fa-key"></i> Perbarui Password
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- Sesi Aktif --}}
                    <div class="section-card">
                        <div class="section-head">
                            <div class="section-head-icon"><i class="fa-solid fa-desktop"></i></div>
                            <div>
                                <h2>Sesi Aktif</h2>
                                <p>Perangkat yang sedang login ke akun Anda</p>
                            </div>
                        </div>
                        <div class="section-body">
                            <div class="session-item">
                                <div class="session-icon"><i class="fa-solid fa-desktop"></i></div>
                                <div class="session-info">
                                    <strong>Browser Saat Ini</strong>
                                    <span>{{ request()->userAgent() ? Str::limit(request()->userAgent(), 55) : 'Tidak diketahui' }}</span>
                                </div>
                                <span class="session-current">Aktif</span>
                            </div>
                            <div style="margin-top:14px">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="btn-danger" style="font-size:12px;padding:8px 14px">
                                        <i class="fa-solid fa-right-from-bracket"></i> Logout dari Semua Perangkat
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- Hapus Akun --}}
                    <div class="danger-section">
                        <h3><i class="fa-solid fa-triangle-exclamation"></i> Zona Berbahaya</h3>
                        <p>Hapus akun akan menghapus semua data toko, produk, dan riwayat transaksi Anda secara permanen. Tindakan ini tidak dapat dibatalkan.</p>
                        <button class="btn-danger" onclick="openDeleteModal()">
                            <i class="fa-solid fa-trash-can"></i> Hapus Akun Saya
                        </button>
                    </div>
                </div>

                {{-- ═══ PANEL: NOTIFIKASI ═══ --}}
                <div class="settings-panel" id="panel-notifikasi">
                    <form method="POST" action="{{ route('seller.settings.update.notifikasi') }}">
                        @csrf @method('PUT')

                        <div class="section-card">
                            <div class="section-head">
                                <div class="section-head-icon"><i class="fa-solid fa-envelope"></i></div>
                                <div>
                                    <h2>Notifikasi Email</h2>
                                    <p>Pilih email apa yang ingin Anda terima</p>
                                </div>
                            </div>
                            <div class="section-body">
                                @foreach([
                                    ['notif_order_masuk',    'Pesanan Baru Masuk',       'Email ketika ada pembeli yang melakukan order'],
                                    ['notif_pembayaran',     'Konfirmasi Pembayaran',     'Email ketika pembayaran buyer berhasil dikonfirmasi'],
                                    ['notif_pesan_chat',     'Pesan Chat Baru',           'Email ketika ada pesan masuk di chat'],
                                    ['notif_tawaran_harga',  'Penawaran Harga',           'Email ketika ada pembeli yang mengajukan negosiasi harga'],
                                    ['notif_laporan_mingguan','Laporan Mingguan',         'Ringkasan penjualan dikirim setiap Senin pagi'],
                                ] as [$key, $title, $desc])
                                <div class="toggle-row">
                                    <div class="toggle-info">
                                        <strong>{{ $title }}</strong>
                                        <span>{{ $desc }}</span>
                                    </div>
                                    <label class="switch">
                                        <input type="checkbox" name="{{ $key }}" value="1"
                                            {{ (auth()->user()->notifikasi[$key] ?? true) ? 'checked' : '' }}>
                                        <span class="switch-slider"></span>
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="section-card">
                            <div class="section-head">
                                <div class="section-head-icon"><i class="fa-solid fa-mobile-screen"></i></div>
                                <div>
                                    <h2>Notifikasi Push</h2>
                                    <p>Notifikasi langsung di browser Anda</p>
                                </div>
                            </div>
                            <div class="section-body">
                                @foreach([
                                    ['push_order',    'Order Baru',      'Notifikasi real-time setiap ada pesanan masuk'],
                                    ['push_chat',     'Pesan Chat',      'Notifikasi pop-up saat ada pesan baru'],
                                    ['push_promo',    'Promo & Update',  'Info promo dan pembaruan fitur SEARA'],
                                ] as [$key, $title, $desc])
                                <div class="toggle-row">
                                    <div class="toggle-info">
                                        <strong>{{ $title }}</strong>
                                        <span>{{ $desc }}</span>
                                    </div>
                                    <label class="switch">
                                        <input type="checkbox" name="{{ $key }}" value="1"
                                            {{ (auth()->user()->notifikasi[$key] ?? true) ? 'checked' : '' }}>
                                        <span class="switch-slider"></span>
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <div style="display:flex;justify-content:flex-end">
                            <button type="submit" class="btn-green">
                                <i class="fa-solid fa-floppy-disk"></i> Simpan Preferensi
                            </button>
                        </div>
                    </form>
                </div>

                {{-- ═══ PANEL: TOKO ═══ --}}
                <div class="settings-panel" id="panel-toko">
                    <div class="section-card">
                        <div class="section-head">
                            <div class="section-head-icon"><i class="fa-solid fa-store"></i></div>
                            <div>
                                <h2>Informasi Toko</h2>
                                <p>Detail toko yang tampil di marketplace</p>
                            </div>
                        </div>
                        <div class="section-body">
                            <form method="POST" action="{{ route('seller.settings.update.toko') }}">
                                @csrf @method('PUT')
                                @php $seller = auth()->user()->sellerProfile ?? null; @endphp

                                <div class="form-group">
                                    <label class="form-label">Nama Toko <span class="req">*</span></label>
                                    <input type="text" name="nama_toko" class="form-input"
                                        value="{{ old('nama_toko', $seller->nama_toko ?? '') }}"
                                        placeholder="cth: Surya Farm" required>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Deskripsi Toko</label>
                                    <textarea name="deskripsi_toko" class="form-textarea" rows="3"
                                        placeholder="Ceritakan tentang toko dan produk unggulan Anda...">{{ old('deskripsi_toko', $seller->deskripsi_toko ?? '') }}</textarea>
                                </div>

                                <div class="form-row">
                                    <div class="form-group">
                                        <label class="form-label">Provinsi</label>
                                        <input type="text" name="provinsi" class="form-input"
                                            value="{{ old('provinsi', $seller->provinsi ?? '') }}"
                                            placeholder="cth: Jawa Barat">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Kota / Kabupaten</label>
                                        <input type="text" name="kota_kabupaten" class="form-input"
                                            value="{{ old('kota_kabupaten', $seller->kota_kabupaten ?? '') }}"
                                            placeholder="cth: Bandung Barat">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Kategori Utama Produk</label>
                                    <select name="kategori_utama" class="form-select">
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach(['Sayuran','Buah','Rempah','Perkebunan','Umbi-umbian','Biji-bijian'] as $kat)
                                        <option value="{{ $kat }}"
                                            {{ old('kategori_utama', $seller->kategori_utama ?? '') === $kat ? 'selected' : '' }}>
                                            {{ $kat }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-footer">
                                    <button type="submit" class="btn-green">
                                        <i class="fa-solid fa-floppy-disk"></i> Simpan Info Toko
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="section-card">
                        <div class="section-head">
                            <div class="section-head-icon"><i class="fa-solid fa-building-columns"></i></div>
                            <div>
                                <h2>Informasi Rekening</h2>
                                <p>Rekening untuk pencairan dana penjualan</p>
                            </div>
                        </div>
                        <div class="section-body">
                            <form method="POST" action="{{ route('seller.settings.update.rekening') }}">
                                @csrf @method('PUT')

                                <div class="form-row">
                                    <div class="form-group">
                                        <label class="form-label">Nama Bank</label>
                                        <select name="nama_bank" class="form-select">
                                            <option value="">-- Pilih Bank --</option>
                                            @foreach(['BRI','BCA','BNI','Mandiri','BSI','CIMB Niaga','Danamon','Permata'] as $bank)
                                            <option value="{{ $bank }}"
                                                {{ old('nama_bank', $seller->nama_bank ?? '') === $bank ? 'selected' : '' }}>
                                                {{ $bank }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Nomor Rekening</label>
                                        <input type="text" name="no_rekening" class="form-input"
                                            value="{{ old('no_rekening', $seller->no_rekening ?? '') }}"
                                            placeholder="cth: 1234567890">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Atas Nama Rekening</label>
                                    <input type="text" name="atas_nama_rekening" class="form-input"
                                        value="{{ old('atas_nama_rekening', $seller->atas_nama_rekening ?? '') }}"
                                        placeholder="Harus sesuai KTP">
                                    <div class="form-hint"><i class="fa-solid fa-circle-info"></i> Nama harus sama persis dengan yang tertera di buku tabungan</div>
                                </div>

                                <div class="form-footer">
                                    <button type="submit" class="btn-green">
                                        <i class="fa-solid fa-floppy-disk"></i> Simpan Rekening
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>{{-- end panels --}}
        </div>{{-- end settings-layout --}}
    </main>
</div>

{{-- ══ MODAL KONFIRMASI LOGOUT ══ --}}
<div class="modal-overlay" id="logoutModal" onclick="if(event.target.id==='logoutModal') closeLogoutModal()">
    <div class="modal">
        <div class="modal-head">
            <h2><i class="fa-solid fa-right-from-bracket" style="color:var(--accent)"></i> Konfirmasi Keluar</h2>
            <button class="modal-close" onclick="closeLogoutModal()"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="modal-body">
            <div style="text-align:center;padding:8px 0 16px">
                <div style="width:64px;height:64px;border-radius:50%;background:var(--accent-soft);display:flex;align-items:center;justify-content:center;font-size:26px;margin:0 auto 14px">
                    🚪
                </div>
                <p style="font-size:15px;font-weight:800;color:var(--text-dark);margin-bottom:6px">Yakin ingin keluar?</p>
                <p style="font-size:13px;font-weight:600;color:var(--text-muted)">Anda akan keluar dari sesi ini dan harus login kembali untuk mengakses dashboard penjual.</p>
            </div>
        </div>
        <div class="modal-foot">
            <button class="btn-outline" onclick="closeLogoutModal()">Batal</button>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-danger" style="border-radius:10px;padding:9px 18px">
                    <i class="fa-solid fa-right-from-bracket"></i> Ya, Keluar
                </button>
            </form>
        </div>
    </div>
</div>

{{-- ══ MODAL HAPUS AKUN ══ --}}
<div class="modal-overlay" id="deleteModal" onclick="if(event.target.id==='deleteModal') closeDeleteModal()">
    <div class="modal">
        <div class="modal-head">
            <h2><i class="fa-solid fa-trash-can" style="color:var(--red)"></i> Hapus Akun</h2>
            <button class="modal-close" onclick="closeDeleteModal()"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="modal-body">
            <div style="text-align:center;padding:8px 0 14px">
                <div style="width:64px;height:64px;border-radius:50%;background:var(--red-soft);display:flex;align-items:center;justify-content:center;font-size:26px;margin:0 auto 14px">
                    ⚠️
                </div>
                <p style="font-size:15px;font-weight:800;color:var(--red);margin-bottom:6px">Tindakan Tidak Dapat Dibatalkan!</p>
                <p style="font-size:13px;font-weight:600;color:var(--text-muted);margin-bottom:16px">Semua data toko, produk, dan riwayat transaksi Anda akan dihapus permanen.</p>
            </div>
            <div class="form-group">
                <label class="form-label">Ketik <strong style="color:var(--red)">HAPUS AKUN</strong> untuk konfirmasi</label>
                <input type="text" id="deleteConfirmInput" class="form-input" placeholder="HAPUS AKUN"
                    oninput="checkDeleteConfirm(this.value)">
            </div>
        </div>
        <div class="modal-foot">
            <button class="btn-outline" onclick="closeDeleteModal()">Batal</button>
            <form method="POST" action="{{ route('seller.settings.delete.account') }}">
                @csrf @method('DELETE')
                <button type="submit" id="deleteConfirmBtn" disabled
                    style="padding:9px 18px;background:#7f1d1d;border:none;border-radius:10px;font-family:'Nunito',sans-serif;font-weight:800;font-size:13px;color:white;cursor:not-allowed;opacity:.5;transition:all .2s;display:inline-flex;align-items:center;gap:6px">
                    <i class="fa-solid fa-trash-can"></i> Hapus Permanen
                </button>
            </form>
        </div>
    </div>
</div>

<script>
// ── Panel switcher ──
function switchPanel(id, btn) {
    document.querySelectorAll('.settings-panel').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.nav-item').forEach(b => b.classList.remove('active'));
    document.getElementById('panel-' + id).classList.add('active');
    btn.classList.add('active');
}

// ── Password toggle ──
function togglePw(id, btn) {
    const inp = document.getElementById(id);
    const isText = inp.type === 'text';
    inp.type = isText ? 'password' : 'text';
    btn.querySelector('i').className = isText ? 'fa-regular fa-eye' : 'fa-regular fa-eye-slash';
}

// ── Password strength ──
function checkStrength(val) {
    const fill  = document.getElementById('pwFill');
    const label = document.getElementById('pwLabel');
    if (!val) { fill.className = 'pw-strength-fill'; label.textContent = ''; return; }
    const strong = val.length >= 8 && /[A-Z]/.test(val) && /[0-9]/.test(val) && /[^A-Za-z0-9]/.test(val);
    const medium = val.length >= 8 && (/[A-Z]/.test(val) || /[0-9]/.test(val));
    if (strong)       { fill.className = 'pw-strength-fill strong'; label.textContent = '✅ Kuat'; label.style.color = 'var(--green-main)'; }
    else if (medium)  { fill.className = 'pw-strength-fill medium'; label.textContent = '⚠️ Sedang'; label.style.color = 'var(--yellow)'; }
    else              { fill.className = 'pw-strength-fill weak';   label.textContent = '❌ Lemah'; label.style.color = '#ef4444'; }
}

// ── Logout modal ──
function openLogoutModal()  { document.getElementById('logoutModal').classList.add('open'); }
function closeLogoutModal() { document.getElementById('logoutModal').classList.remove('open'); }

// ── Delete account modal ──
function openDeleteModal()  { document.getElementById('deleteModal').classList.add('open'); }
function closeDeleteModal() { document.getElementById('deleteModal').classList.remove('open'); document.getElementById('deleteConfirmInput').value = ''; checkDeleteConfirm(''); }
function checkDeleteConfirm(val) {
    const btn = document.getElementById('deleteConfirmBtn');
    const ok  = val === 'HAPUS AKUN';
    btn.disabled       = !ok;
    btn.style.opacity  = ok ? '1' : '.5';
    btn.style.cursor   = ok ? 'pointer' : 'not-allowed';
}

// ── Auto-dismiss alert ──
@if(session('success') || session('error') || $errors->any())
setTimeout(() => {
    document.querySelectorAll('.alert').forEach(el => {
        el.style.transition = 'opacity .5s';
        el.style.opacity    = '0';
    });
}, 4000);
@endif

// ── Buka panel sesuai hash URL ──
const hash = location.hash.replace('#', '');
if (['akun','keamanan','notifikasi','toko'].includes(hash)) {
    const btn = document.querySelector(`.nav-item[onclick*="'${hash}'"]`);
    if (btn) switchPanel(hash, btn);
}
</script>

</body>
</html>