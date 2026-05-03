@extends('layouts.app')

@section('title', 'Daftar Jadi Petani — SEARA')

@push('styles')
<style>
.apply-page { max-width: 760px; margin: 0 auto; padding: 28px 20px 80px; }

.apply-hero { background: linear-gradient(135deg, var(--green-dark), var(--green-main)); border-radius: var(--r); padding: 28px 32px; margin-bottom: 28px; color: white; }
.apply-hero h1 { font-family: 'Playfair Display', serif; font-size: 26px; font-weight: 700; }
.apply-hero p { font-size: 13px; opacity: .8; margin-top: 6px; line-height: 1.6; }

.apply-card { background: white; border: 1px solid var(--border); border-radius: 14px; padding: 28px 30px; margin-bottom: 20px; }
.apply-card h2 { font-size: 16px; font-weight: 900; color: var(--text-dark); margin-bottom: 18px; display: flex; align-items: center; gap: 8px; }
.apply-card h2::before { content: ''; display: block; width: 3px; height: 18px; background: var(--green-main); border-radius: 2px; }

.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.form-group { margin-bottom: 16px; }
.form-group label { display: block; font-size: 13px; font-weight: 800; color: var(--text-dark); margin-bottom: 6px; }
.form-group label .req { color: var(--accent); margin-left: 2px; }
.form-control {
    width: 100%; padding: 10px 14px; border: 1.5px solid var(--border);
    border-radius: 10px; font-family: 'Nunito', sans-serif; font-size: 14px;
    color: var(--text-dark); outline: none; transition: border-color .2s; background: white;
}
.form-control:focus { border-color: var(--green-main); }
.form-control.is-error { border-color: #ef4444; }
textarea.form-control { resize: vertical; min-height: 90px; }
.form-hint { font-size: 11px; color: var(--text-muted); margin-top: 4px; font-weight: 600; }
.form-error { font-size: 12px; color: #dc2626; font-weight: 700; margin-top: 4px; }

.upload-area {
    border: 2px dashed var(--border); border-radius: 12px; padding: 24px;
    text-align: center; cursor: pointer; transition: all .2s; background: var(--green-bg);
    position: relative; overflow: hidden;
}
.upload-area:hover { border-color: var(--green-main); background: var(--green-pale); }
.upload-area input[type=file] { position: absolute; inset: 0; opacity: 0; cursor: pointer; }
.upload-icon { font-size: 32px; margin-bottom: 8px; }
.upload-label { font-size: 13px; font-weight: 700; color: var(--text-mid); }
.upload-hint { font-size: 11px; color: var(--text-muted); margin-top: 4px; }
.upload-preview { display: none; max-width: 200px; margin: 10px auto 0; border-radius: 8px; border: 1px solid var(--border); }

.btn-submit {
    width: 100%; padding: 15px; background: var(--green-main); color: white;
    border: none; border-radius: 12px; font-family: 'Nunito', sans-serif;
    font-size: 16px; font-weight: 900; cursor: pointer; transition: background .2s;
    display: flex; align-items: center; justify-content: center; gap: 8px;
    box-shadow: 0 4px 14px rgba(58,125,68,.3);
}
.btn-submit:hover { background: var(--green-dark); }

.info-box { background: #fffbeb; border: 1px solid #fde68a; border-radius: 12px; padding: 16px 18px; margin-bottom: 20px; font-size: 13px; color: #92400e; display: flex; gap: 10px; }
.info-box .info-icon { font-size: 20px; flex-shrink: 0; }

@media (max-width: 600px) {
    .form-row { grid-template-columns: 1fr; }
}
</style>
@endpush

@section('content')
<div class="apply-page">

    <div class="apply-hero">
        <h1>🌾 Daftar Jadi Petani di SEARA</h1>
        <p>Jual hasil panen langsung ke pembeli. Tanpa perantara, harga lebih adil untuk semua.<br>
        Isi formulir berikut dan tim kami akan meninjau pengajuanmu dalam 1–3 hari kerja.</p>
    </div>

    <div class="info-box">
        <div class="info-icon">ℹ️</div>
        <div>Pastikan data yang kamu isi <strong>akurat dan valid</strong>. Foto KTP dan selfie dengan KTP diperlukan untuk verifikasi identitas. Data tidak akan dibagikan ke pihak lain.</div>
    </div>

    @if(session('error'))
    <div style="background:#fee2e2;border:1px solid #fecaca;color:#991b1b;padding:14px 18px;border-radius:12px;font-size:14px;font-weight:700;margin-bottom:20px;">
        ❌ {{ session('error') }}
    </div>
    @endif

    <form action="{{ route('buyer.apply.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Informasi Toko --}}
        <div class="apply-card">
            <h2>🏪 Informasi Toko</h2>

            <div class="form-group">
                <label>Nama Toko <span class="req">*</span></label>
                <input type="text" name="nama_toko" class="form-control @error('nama_toko') is-error @enderror"
                    placeholder="Contoh: Kebun Segar Pak Budi" value="{{ old('nama_toko') }}" required>
                @error('nama_toko')<div class="form-error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label>Deskripsi Toko <span class="req">*</span></label>
                <textarea name="deskripsi_toko" class="form-control @error('deskripsi_toko') is-error @enderror"
                    placeholder="Ceritakan tentang toko dan produk kamu..." required>{{ old('deskripsi_toko') }}</textarea>
                @error('deskripsi_toko')<div class="form-error">{{ $message }}</div>@enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Kategori Utama <span class="req">*</span></label>
                    <select name="kategori_utama" class="form-control @error('kategori_utama') is-error @enderror" required>
                        <option value="">Pilih kategori...</option>
                        @foreach(['Sayuran','Buah-buahan','Pertanian','Perkebunan','Rempah','Peternakan','Perikanan','Bibit','Pupuk'] as $k)
                        <option value="{{ $k }}" {{ old('kategori_utama') === $k ? 'selected' : '' }}>{{ $k }}</option>
                        @endforeach
                    </select>
                    @error('kategori_utama')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label>Provinsi <span class="req">*</span></label>
                    <input type="text" name="provinsi" class="form-control @error('provinsi') is-error @enderror"
                        placeholder="Contoh: Jawa Barat" value="{{ old('provinsi') }}" required>
                    @error('provinsi')<div class="form-error">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Kota / Kabupaten <span class="req">*</span></label>
                    <input type="text" name="kota_kabupaten" class="form-control @error('kota_kabupaten') is-error @enderror"
                        placeholder="Contoh: Kabupaten Bandung" value="{{ old('kota_kabupaten') }}" required>
                    @error('kota_kabupaten')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label>Alamat Lengkap <span class="req">*</span></label>
                    <input type="text" name="alamat_toko" class="form-control @error('alamat_toko') is-error @enderror"
                        placeholder="Jl. Mawar No. 5, RT 02/RW 03..." value="{{ old('alamat_toko') }}" required>
                    @error('alamat_toko')<div class="form-error">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        {{-- Data Rekening --}}
        <div class="apply-card">
            <h2>🏦 Informasi Rekening</h2>
            <div class="form-row">
                <div class="form-group">
                    <label>Nama Bank <span class="req">*</span></label>
                    <select name="nama_bank" class="form-control @error('nama_bank') is-error @enderror" required>
                        <option value="">Pilih bank...</option>
                        @foreach(['BCA','BRI','BNI','Mandiri','BSI','CIMB Niaga','Danamon','Permata','BTN','Lainnya'] as $b)
                        <option value="{{ $b }}" {{ old('nama_bank') === $b ? 'selected' : '' }}>{{ $b }}</option>
                        @endforeach
                    </select>
                    @error('nama_bank')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label>Nomor Rekening <span class="req">*</span></label>
                    <input type="text" name="no_rekening" class="form-control @error('no_rekening') is-error @enderror"
                        placeholder="1234567890" value="{{ old('no_rekening') }}" required>
                    @error('no_rekening')<div class="form-error">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="form-group">
                <label>Nama Pemilik Rekening <span class="req">*</span></label>
                <input type="text" name="atas_nama_rekening" class="form-control @error('atas_nama_rekening') is-error @enderror"
                    placeholder="Sesuai dengan nama di buku tabungan" value="{{ old('atas_nama_rekening') }}" required>
                @error('atas_nama_rekening')<div class="form-error">{{ $message }}</div>@enderror
            </div>
        </div>

        {{-- Verifikasi KTP --}}
        <div class="apply-card">
            <h2>🪪 Verifikasi Identitas (KTP)</h2>

            <div class="form-group">
                <label>Nomor KTP <span class="req">*</span></label>
                <input type="text" name="no_ktp" class="form-control @error('no_ktp') is-error @enderror"
                    placeholder="16 digit nomor KTP" maxlength="16" value="{{ old('no_ktp') }}" required>
                @error('no_ktp')<div class="form-error">{{ $message }}</div>@enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Foto KTP <span class="req">*</span></label>
                    <div class="upload-area" id="ktpArea">
                        <input type="file" name="foto_ktp" accept="image/*" id="ktpInput"
                            onchange="previewImg(this, 'ktpPreview')">
                        <div class="upload-icon">🪪</div>
                        <div class="upload-label">Upload Foto KTP</div>
                        <div class="upload-hint">JPG / PNG, maks. 4MB</div>
                        <img id="ktpPreview" class="upload-preview" alt="Preview KTP">
                    </div>
                    @error('foto_ktp')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label>Selfie dengan KTP <span class="req">*</span></label>
                    <div class="upload-area" id="selfieArea">
                        <input type="file" name="foto_selfie_ktp" accept="image/*" id="selfieInput"
                            onchange="previewImg(this, 'selfiePreview')">
                        <div class="upload-icon">🤳</div>
                        <div class="upload-label">Upload Selfie + KTP</div>
                        <div class="upload-hint">Foto kamu sambil pegang KTP</div>
                        <img id="selfiePreview" class="upload-preview" alt="Preview Selfie">
                    </div>
                    @error('foto_selfie_ktp')<div class="form-error">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        <button type="submit" class="btn-submit">
            🌾 Kirim Pengajuan
        </button>
    </form>

</div>
@endsection

@push('scripts')
<script>
function previewImg(input, previewId) {
    const preview = document.getElementById(previewId);
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
