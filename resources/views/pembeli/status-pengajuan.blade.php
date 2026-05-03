@extends('layouts.app')

@section('title', 'Status Pengajuan Seller — SEARA')

@push('styles')
<style>
.status-page { max-width: 620px; margin: 60px auto; padding: 0 20px 80px; }

.status-card { background: white; border: 1px solid var(--border); border-radius: 18px; overflow: hidden; box-shadow: var(--shadow-sm); }
.status-head { padding: 28px 30px; }

/* Status colors */
.status-pending  { background: linear-gradient(135deg, #fef9c3, #fef3c7); border-bottom: 1px solid #fde68a; }
.status-reviewing{ background: linear-gradient(135deg, #dbeafe, #bfdbfe); border-bottom: 1px solid #93c5fd; }
.status-approved { background: linear-gradient(135deg, #dcfce7, #bbf7d0); border-bottom: 1px solid #86efac; }
.status-rejected { background: linear-gradient(135deg, #fee2e2, #fecaca); border-bottom: 1px solid #fca5a5; }

.status-icon { font-size: 52px; margin-bottom: 12px; }
.status-title { font-size: 22px; font-weight: 900; color: var(--text-dark); }
.status-sub { font-size: 13px; color: var(--text-mid); margin-top: 6px; line-height: 1.6; }

.status-body { padding: 24px 30px; }
.info-row { display: flex; gap: 12px; padding: 10px 0; border-bottom: 1px dashed var(--border); font-size: 13px; }
.info-row:last-child { border-bottom: none; }
.info-label { width: 150px; flex-shrink: 0; color: var(--text-muted); font-weight: 700; }
.info-val { flex: 1; color: var(--text-dark); font-weight: 600; }

.rejection-box { background: #fee2e2; border: 1px solid #fca5a5; border-radius: 12px; padding: 16px 18px; margin-top: 16px; font-size: 13px; color: #991b1b; }
.rejection-box strong { display: block; font-size: 14px; margin-bottom: 4px; }

.btn-primary { display: inline-flex; align-items: center; gap: 8px; padding: 12px 24px; background: var(--green-main); color: white; border-radius: 12px; font-size: 14px; font-weight: 800; text-decoration: none; transition: background .2s; margin-top: 20px; }
.btn-primary:hover { background: var(--green-dark); }
.btn-outline { display: inline-flex; align-items: center; gap: 8px; padding: 12px 24px; border: 2px solid var(--green-main); color: var(--green-main); border-radius: 12px; font-size: 14px; font-weight: 800; text-decoration: none; transition: all .2s; margin-top: 20px; margin-left: 10px; }
.btn-outline:hover { background: var(--green-pale); }

.no-app { text-align: center; padding: 60px 20px; }
.no-app-icon { font-size: 60px; margin-bottom: 16px; }
.no-app-title { font-size: 20px; font-weight: 900; color: var(--text-dark); margin-bottom: 8px; }
.no-app-sub { font-size: 14px; color: var(--text-muted); margin-bottom: 24px; }
</style>
@endpush

@section('content')
<div class="status-page">

    @if(session('success'))
    <div style="background:#dcfce7;border:1px solid #bbf7d0;color:#166534;padding:14px 18px;border-radius:12px;font-size:14px;font-weight:700;margin-bottom:20px;display:flex;align-items:center;gap:8px;">
        ✅ {{ session('success') }}
    </div>
    @endif

    @if(session('info'))
    <div style="background:#dbeafe;border:1px solid #93c5fd;color:#1e40af;padding:14px 18px;border-radius:12px;font-size:14px;font-weight:700;margin-bottom:20px;display:flex;align-items:center;gap:8px;">
        ℹ️ {{ session('info') }}
    </div>
    @endif

    @if(!$application)
    <div class="no-app">
        <div class="no-app-icon">📋</div>
        <div class="no-app-title">Belum Ada Pengajuan</div>
        <div class="no-app-sub">Kamu belum pernah mengajukan pendaftaran seller.</div>
        <a href="{{ route('buyer.apply.create') }}" class="btn-primary">🌾 Daftar Jadi Petani</a>
        <a href="{{ route('buyer.dashboard') }}" class="btn-outline">← Kembali</a>
    </div>

    @else
    @php
        $statusConfig = match($application->status) {
            'pending'   => ['icon'=>'⏳','title'=>'Pengajuan Diterima','sub'=>'Pengajuanmu sedang menunggu tinjauan tim SEARA. Proses ini biasanya memakan waktu 1–3 hari kerja.','headClass'=>'status-pending'],
            'reviewing' => ['icon'=>'🔍','title'=>'Sedang Ditinjau','sub'=>'Tim SEARA sedang meninjau dokumen dan data pengajuanmu. Kami akan segera memberikan keputusan.','headClass'=>'status-reviewing'],
            'approved'  => ['icon'=>'🎉','title'=>'Pengajuan Disetujui!','sub'=>'Selamat! Akunmu sudah aktif sebagai seller. Kamu sekarang bisa mulai mengelola toko dan mengunggah produk.','headClass'=>'status-approved'],
            'rejected'  => ['icon'=>'😔','title'=>'Pengajuan Ditolak','sub'=>'Mohon maaf, pengajuanmu belum dapat kami setujui saat ini. Kamu bisa mengajukan ulang setelah memperbaiki kekurangan.','headClass'=>'status-rejected'],
            default     => ['icon'=>'❓','title'=>ucfirst($application->status),'sub'=>'','headClass'=>''],
        };
    @endphp

    <div class="status-card">
        <div class="status-head {{ $statusConfig['headClass'] }}">
            <div class="status-icon">{{ $statusConfig['icon'] }}</div>
            <div class="status-title">{{ $statusConfig['title'] }}</div>
            <div class="status-sub">{{ $statusConfig['sub'] }}</div>
        </div>

        <div class="status-body">
            <div class="info-row">
                <div class="info-label">Nama Toko</div>
                <div class="info-val">{{ $application->nama_toko }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Kategori</div>
                <div class="info-val">{{ $application->kategori_utama }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Lokasi</div>
                <div class="info-val">{{ $application->kota_kabupaten }}, {{ $application->provinsi }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Tanggal Pengajuan</div>
                <div class="info-val">{{ $application->submitted_at ? \Carbon\Carbon::parse($application->submitted_at)->translatedFormat('d F Y, H:i') : '-' }}</div>
            </div>
            @if($application->reviewed_at)
            <div class="info-row">
                <div class="info-label">Tanggal Ditinjau</div>
                <div class="info-val">{{ \Carbon\Carbon::parse($application->reviewed_at)->translatedFormat('d F Y, H:i') }}</div>
            </div>
            @endif

            @if($application->status === 'rejected' && $application->catatan_penolakan)
            <div class="rejection-box">
                <strong>Alasan Penolakan:</strong>
                {{ $application->catatan_penolakan }}
            </div>
            @endif

            <div>
                @if($application->status === 'approved')
                <a href="{{ route('seller.dashboard') }}" class="btn-primary">🌾 Ke Dashboard Seller</a>
                @elseif($application->status === 'rejected')
                <a href="{{ route('buyer.apply.create') }}" class="btn-primary">📝 Ajukan Ulang</a>
                <a href="{{ route('buyer.dashboard') }}" class="btn-outline">← Beranda</a>
                @else
                <a href="{{ route('buyer.dashboard') }}" class="btn-outline">← Kembali Belanja</a>
                @endif
            </div>
        </div>
    </div>
    @endif

</div>
@endsection
