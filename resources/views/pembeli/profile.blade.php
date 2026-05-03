@extends('layouts.app')

@section('title', 'Profil Saya — SEARA')

@push('styles')
<style>
.profile-page { max-width: 900px; margin: 0 auto; padding: 28px 20px 80px; }

/* Header */
.profile-hero {
    background: linear-gradient(135deg, var(--green-dark), var(--green-main));
    border-radius: var(--r); padding: 32px 36px; margin-bottom: 24px;
    display: flex; align-items: center; gap: 24px; color: white;
    position: relative; overflow: hidden;
}
.profile-hero::before {
    content: ''; position: absolute; right: -60px; top: -60px;
    width: 260px; height: 260px; background: rgba(255,255,255,0.05); border-radius: 50%;
}
.profile-hero::after {
    content: ''; position: absolute; right: 40px; top: 40px;
    width: 140px; height: 140px; background: rgba(255,255,255,0.04); border-radius: 50%;
}
.hero-avatar-wrap { position: relative; flex-shrink: 0; z-index: 1; }
.hero-avatar {
    width: 88px; height: 88px; border-radius: 50%;
    background: var(--green-light);
    border: 4px solid rgba(255,255,255,0.35);
    display: flex; align-items: center; justify-content: center;
    font-size: 34px; font-weight: 900; color: white;
    overflow: hidden;
}
.hero-avatar img { width: 100%; height: 100%; object-fit: cover; }
.avatar-edit-btn {
    position: absolute; bottom: 0; right: 0;
    width: 28px; height: 28px; background: white; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 13px; cursor: pointer; border: 2px solid var(--green-main);
    box-shadow: 0 2px 6px rgba(0,0,0,0.2);
}
.hero-info { z-index: 1; }
.hero-name { font-family: 'Playfair Display', serif; font-size: 26px; font-weight: 700; }
.hero-email { font-size: 13px; opacity: 0.75; margin-top: 3px; }
.hero-role {
    display: inline-flex; align-items: center; gap: 5px;
    background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.25);
    padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 700;
    margin-top: 10px;
}
.hero-join { font-size: 12px; opacity: 0.6; margin-top: 6px; }

/* Cards */
.profile-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
@media (max-width: 640px) { .profile-grid { grid-template-columns: 1fr; } }

.profile-card {
    background: white; border: 1px solid var(--border);
    border-radius: 14px; padding: 24px 26px;
}
.card-title {
    font-size: 15px; font-weight: 900; color: var(--text-dark);
    margin-bottom: 20px; display: flex; align-items: center; gap: 8px;
}
.card-title::before {
    content: ''; display: block; width: 3px; height: 18px;
    background: var(--green-main); border-radius: 2px;
}

/* Form */
.form-group { margin-bottom: 16px; }
.form-label { display: block; font-size: 13px; font-weight: 800; color: var(--text-dark); margin-bottom: 6px; }
.form-control {
    width: 100%; padding: 10px 14px; border: 1.5px solid var(--border);
    border-radius: 10px; font-family: 'Nunito', sans-serif; font-size: 14px;
    color: var(--text-dark); outline: none; transition: border-color .2s; background: white;
}
.form-control:focus { border-color: var(--green-main); }
.form-control[readonly] { background: var(--green-bg); color: var(--text-mid); cursor: not-allowed; }
textarea.form-control { resize: vertical; min-height: 80px; }
.form-hint { font-size: 11px; color: var(--text-muted); margin-top: 4px; font-weight: 600; }

/* Buttons */
.btn-save {
    width: 100%; padding: 12px; background: var(--green-main); color: white;
    border: none; border-radius: 10px; font-family: 'Nunito', sans-serif;
    font-size: 14px; font-weight: 900; cursor: pointer; transition: background .2s;
    display: flex; align-items: center; justify-content: center; gap: 8px; margin-top: 4px;
}
.btn-save:hover { background: var(--green-dark); }

/* Seller CTA */
.seller-cta {
    background: white; border: 2px solid var(--border);
    border-radius: 14px; padding: 24px 26px; grid-column: 1 / -1;
}
.seller-cta-inner {
    display: flex; align-items: center; justify-content: space-between; gap: 20px;
}
@media (max-width: 640px) { .seller-cta-inner { flex-direction: column; align-items: flex-start; } }
.seller-cta-icon { font-size: 52px; flex-shrink: 0; }
.seller-cta-text h3 { font-size: 18px; font-weight: 900; color: var(--text-dark); margin-bottom: 6px; }
.seller-cta-text p { font-size: 13px; color: var(--text-mid); line-height: 1.6; }
.seller-cta-text .cta-benefits { display: flex; gap: 16px; margin-top: 10px; flex-wrap: wrap; }
.cta-benefit { font-size: 12px; font-weight: 700; color: var(--green-dark); display: flex; align-items: center; gap: 4px; }
.btn-jadi-seller {
    flex-shrink: 0; padding: 13px 28px; background: linear-gradient(135deg, var(--green-dark), var(--green-main));
    color: white; border: none; border-radius: 12px; font-family: 'Nunito', sans-serif;
    font-size: 14px; font-weight: 900; cursor: pointer; transition: opacity .2s; white-space: nowrap;
    text-decoration: none; display: inline-flex; align-items: center; gap: 8px;
    box-shadow: 0 4px 14px rgba(58,125,68,0.3);
}
.btn-jadi-seller:hover { opacity: 0.9; transform: translateY(-1px); }

/* Status badges */
.app-status-badge {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 8px 16px; border-radius: 20px; font-size: 13px; font-weight: 800;
}
.status-pending   { background: #fef3c7; color: #92400e; }
.status-reviewing { background: #dbeafe; color: #1e40af; }
.status-approved  { background: #dcfce7; color: #166534; }
.status-rejected  { background: #fee2e2; color: #991b1b; }

/* Alert */
.alert { padding: 13px 16px; border-radius: 10px; font-size: 13px; font-weight: 700; margin-bottom: 20px; display: flex; align-items: center; gap: 8px; }
.alert-success { background: #dcfce7; border: 1px solid #bbf7d0; color: #166534; }
.alert-error   { background: #fee2e2; border: 1px solid #fecaca; color: #991b1b; }

/* Avatar upload hidden input */
#avatarInput { display: none; }
</style>
@endpush

@section('content')
<div class="profile-page">

    {{-- Flash messages --}}
    @if(session('success'))
    <div class="alert alert-success">✅ {{ session('success') }}</div>
    @endif
    @if($errors->any())
    <div class="alert alert-error">❌ {{ $errors->first() }}</div>
    @endif

    {{-- Hero Profile --}}
    <div class="profile-hero">
        <form id="avatarForm" action="{{ route('buyer.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="hero-avatar-wrap">
                <div class="hero-avatar" id="heroAvatarEl">
                    @if($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" id="avatarPreview">
                    @else
                        <span id="avatarInitials">{{ strtoupper(substr($user->nama_lengkap ?? $user->name, 0, 2)) }}</span>
                    @endif
                </div>
                <label for="avatarInput" class="avatar-edit-btn" title="Ganti foto profil">✏️</label>
                <input type="file" name="avatar" id="avatarInput" accept="image/*">
                {{-- Hidden fields to pass other data when avatar auto-submit --}}
                <input type="hidden" name="nama_lengkap" value="{{ $user->nama_lengkap }}">
                <input type="hidden" name="no_whatsapp" value="{{ $user->no_whatsapp }}">
                <input type="hidden" name="alamat" value="{{ $user->alamat }}">
            </div>
        </form>
        <div class="hero-info">
            <div class="hero-name">{{ $user->nama_lengkap }}</div>
            <div class="hero-email">{{ $user->email }}</div>
            <div class="hero-role">
                @if($user->role === 'seller') 🌾 Seller
                @elseif($user->role === 'admin') 🛡️ Admin
                @else 🛒 Pembeli
                @endif
            </div>
            <div class="hero-join">Bergabung sejak {{ $user->created_at->format('d F Y') }}</div>
        </div>
    </div>

    <div class="profile-grid">

        {{-- Form Edit Profil --}}
        <div class="profile-card">
            <div class="card-title">👤 Informasi Pribadi</div>
            <form action="{{ route('buyer.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="form-group">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" class="form-control" value="{{ old('nama_lengkap', $user->nama_lengkap) }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Username</label>
                    <input type="text" class="form-control" value="{{ $user->name }}" readonly>
                    <div class="form-hint">Username tidak dapat diubah.</div>
                </div>
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" value="{{ $user->email }}" readonly>
                    <div class="form-hint">Email tidak dapat diubah.</div>
                </div>
                <div class="form-group">
                    <label class="form-label">Nomor WhatsApp</label>
                    <input type="text" name="no_whatsapp" class="form-control" value="{{ old('no_whatsapp', $user->no_whatsapp) }}" placeholder="Contoh: 08123456789" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Alamat Lengkap</label>
                    <textarea name="alamat" class="form-control" placeholder="Jalan, kecamatan, kota..." required>{{ old('alamat', $user->alamat) }}</textarea>
                </div>
                <button type="submit" class="btn-save">💾 Simpan Perubahan</button>
            </form>
        </div>

        {{-- Form Ganti Password --}}
        <div class="profile-card">
            <div class="card-title">🔒 Keamanan Akun</div>
            <form action="{{ route('buyer.profile.password') }}" method="POST">
                @csrf @method('PUT')
                <div class="form-group">
                    <label class="form-label">Password Lama</label>
                    <input type="password" name="current_password" class="form-control @error('current_password') is-error @enderror" placeholder="Masukkan password lama" required>
                    @error('current_password')
                    <div style="font-size:12px;color:#dc2626;font-weight:700;margin-top:4px;">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Password Baru</label>
                    <input type="password" name="password" class="form-control" placeholder="Minimal 8 karakter" required minlength="8">
                </div>
                <div class="form-group">
                    <label class="form-label">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password baru" required>
                </div>
                <div class="form-hint" style="margin-bottom:14px;">Gunakan kombinasi huruf, angka, dan simbol agar lebih aman.</div>
                <button type="submit" class="btn-save" style="background:#1e40af;">🔑 Ubah Password</button>
            </form>

            {{-- Info Akun --}}
            <div style="margin-top: 24px; padding-top: 20px; border-top: 1px dashed var(--border);">
                <div class="card-title" style="margin-bottom:14px;">📊 Info Akun</div>
                <div style="font-size:13px; color:var(--text-mid); line-height:2;">
                    <div>📅 <strong>Bergabung:</strong> {{ $user->created_at->format('d M Y') }}</div>
                    @if($user->last_login_at)
                    <div>🕐 <strong>Login terakhir:</strong> {{ $user->last_login_at->diffForHumans() }}</div>
                    @endif
                    <div>✅ <strong>Status:</strong>
                        @if($user->is_active)
                        <span style="color:var(--green-main);font-weight:800;">Aktif</span>
                        @else
                        <span style="color:#dc2626;font-weight:800;">Nonaktif</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Seller CTA — hanya tampil jika role buyer --}}
        @if($user->role === 'buyer')
        <div class="seller-cta">
            <div class="seller-cta-inner">
                <div class="seller-cta-icon">🌾</div>
                <div class="seller-cta-text" style="flex:1;">
                    <h3>Jual Hasil Panenmu di SEARA</h3>
                    <p>Bergabung sebagai petani seller dan jual langsung ke pembeli tanpa perantara. Harga lebih adil, penghasilan lebih besar!</p>
                    <div class="cta-benefits">
                        <span class="cta-benefit">✅ Tanpa komisi tinggi</span>
                        <span class="cta-benefit">✅ Pembeli langsung</span>
                        <span class="cta-benefit">✅ Harga kamu yang tentukan</span>
                    </div>
                </div>

                @php
                    $appStatus = $sellerApplication?->status;
                @endphp

                @if(!$sellerApplication || $appStatus === 'rejected')
                <a href="{{ route('buyer.apply.create') }}" class="btn-jadi-seller">
                    🌾 Daftar Jadi Seller
                </a>
                @elseif(in_array($appStatus, ['pending', 'reviewing']))
                <div style="text-align:center;">
                    <div class="app-status-badge status-{{ $appStatus }}">
                        @if($appStatus === 'pending') ⏳ Menunggu Tinjauan
                        @else 🔍 Sedang Ditinjau
                        @endif
                    </div>
                    <a href="{{ route('buyer.application.status') }}" style="display:block;margin-top:10px;font-size:12px;color:var(--green-main);font-weight:700;">Lihat Status →</a>
                </div>
                @elseif($appStatus === 'approved')
                <div class="app-status-badge status-approved">🎉 Pengajuan Disetujui</div>
                @endif
            </div>
        </div>
        @endif

    </div>
</div>

<script>
// Avatar preview & auto-submit
document.getElementById('avatarInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = function(re) {
        const wrap = document.getElementById('heroAvatarEl');
        const initials = document.getElementById('avatarInitials');
        if (initials) initials.style.display = 'none';

        let img = document.getElementById('avatarPreview');
        if (!img) {
            img = document.createElement('img');
            img.id = 'avatarPreview';
            img.style.cssText = 'width:100%;height:100%;object-fit:cover;';
            wrap.appendChild(img);
        }
        img.src = re.target.result;

        // Auto submit avatar form
        document.getElementById('avatarForm').submit();
    };
    reader.readAsDataURL(file);
});
</script>
@endsection
