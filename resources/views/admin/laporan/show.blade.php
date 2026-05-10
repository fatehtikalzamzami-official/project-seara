@extends('layouts.admin')

@section('title', 'Detail Laporan #' . $report->id)

@push('styles')
<style>
.det-wrap { max-width: 900px; }

/* Back button */
.back-btn {
    display: inline-flex; align-items: center; gap: 7px;
    font-size: 13px; font-weight: 700; color: var(--muted);
    text-decoration: none; margin-bottom: 20px;
    transition: color .18s;
}
.back-btn:hover { color: var(--accent); }
.back-btn svg { width: 15px; height: 15px; }

/* Header card */
.det-header {
    background: var(--surface); border: 1.5px solid var(--border);
    border-radius: 20px; padding: 24px 28px; margin-bottom: 20px;
    display: flex; align-items: flex-start; justify-content: space-between;
    gap: 20px; flex-wrap: wrap;
}
.det-title { font-size: 20px; font-weight: 800; color: var(--text); margin-bottom: 6px; }
.det-meta { display: flex; gap: 10px; flex-wrap: wrap; align-items: center; }

.pill {
    font-size: 12px; font-weight: 700; padding: 5px 12px;
    border-radius: 20px;
}
.pill-prio-critical { background:#fee2e2;color:#991b1b; }
.pill-prio-high     { background:#ffedd5;color:#9a3412; }
.pill-prio-medium   { background:#fef9c3;color:#854d0e; }
.pill-prio-low      { background:#f0fdf4;color:#166534; }

.pill-status-pending   { background:#fef9c3;color:#854d0e; }
.pill-status-reviewing { background:#dbeafe;color:#1e40af; }
.pill-status-resolved  { background:#f0fdf4;color:#166534; }
.pill-status-dismissed { background:#f3f4f6;color:#6b7280; }

/* Grid layout */
.det-grid { display: grid; grid-template-columns: 1fr 300px; gap: 20px; align-items: start; }

/* Section card */
.det-card {
    background: var(--surface); border: 1.5px solid var(--border);
    border-radius: 18px; overflow: hidden; margin-bottom: 16px;
}
.det-card-header {
    padding: 14px 20px; border-bottom: 1px solid var(--border);
    font-size: 12px; font-weight: 700; color: var(--muted);
    text-transform: uppercase; letter-spacing: .8px;
    display: flex; align-items: center; gap: 8px;
}
.det-card-body { padding: 20px; }

/* User row */
.user-row { display: flex; align-items: center; gap: 12px; }
.user-ava {
    width: 42px; height: 42px; border-radius: 12px; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    font-size: 15px; font-weight: 800; color: #fff;
}
.user-name { font-size: 14px; font-weight: 700; color: var(--text); }
.user-sub  { font-size: 12px; color: var(--muted); margin-top: 2px; }

/* Description */
.det-desc {
    font-size: 13px; color: var(--text); line-height: 1.7;
    background: var(--surface2); border-radius: 10px;
    padding: 14px 16px; white-space: pre-line;
}

/* Info list */
.info-list { display: flex; flex-direction: column; gap: 12px; }
.info-row { display: flex; justify-content: space-between; align-items: center; gap: 8px; }
.info-row .label { font-size: 12px; color: var(--muted); font-weight: 600; }
.info-row .val   { font-size: 13px; font-weight: 700; color: var(--text); text-align: right; }

/* Action panel */
.action-panel {
    background: var(--surface); border: 1.5px solid var(--border);
    border-radius: 18px; padding: 20px; position: sticky; top: 20px;
}
.action-panel-title { font-size: 13px; font-weight: 800; color: var(--text); margin-bottom: 16px; }

.ap-btn {
    width: 100%; padding: 11px 16px; border-radius: 12px;
    font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700;
    cursor: pointer; border: 1.5px solid transparent; transition: all .18s;
    display: flex; align-items: center; justify-content: center; gap: 7px;
    margin-bottom: 8px; text-decoration: none;
}
.ap-btn-primary   { background: var(--accent); color: #fff; border-color: var(--accent); }
.ap-btn-primary:hover { background: #2fa36a; }
.ap-btn-review    { background: #dbeafe; color: #1e40af; border-color: #93c5fd; }
.ap-btn-review:hover { background: #bfdbfe; }
.ap-btn-resolve   { background: #f0fdf4; color: #166534; border-color: #86efac; }
.ap-btn-resolve:hover { background: #dcfce7; }
.ap-btn-dismiss   { background: #fee2e2; color: #991b1b; border-color: #fca5a5; }
.ap-btn-dismiss:hover { background: #fecaca; }
.ap-btn-secondary { background: var(--surface2); color: var(--muted); border-color: var(--border); }
.ap-btn-secondary:hover { border-color: var(--accent); color: var(--text); }

/* Admin note */
.admin-note-box {
    background: #f0fdf4; border: 1.5px solid #86efac;
    border-radius: 12px; padding: 14px 16px; font-size: 13px;
    color: #166534; line-height: 1.6; white-space: pre-line;
}
.admin-note-box.dismissed {
    background: #f3f4f6; border-color: #d1d5db; color: #6b7280;
}

/* Resolve inline form */
.resolve-form { margin-top: 14px; }
.resolve-form textarea {
    width: 100%; border: 1.5px solid var(--border); border-radius: 10px;
    padding: 10px 12px; font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 12px; color: var(--text); resize: vertical; min-height: 80px;
    outline: none; transition: border-color .2s;
}
.resolve-form textarea:focus { border-color: var(--accent); }
.resolve-form select {
    width: 100%; border: 1.5px solid var(--border); border-radius: 10px;
    padding: 9px 12px; font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 12px; color: var(--text); outline: none;
    background: #fff; cursor: pointer; margin-bottom: 8px;
    transition: border-color .2s;
}
.resolve-form select:focus { border-color: var(--accent); }
.resolve-form-label { font-size: 11px; font-weight: 700; color: var(--muted); margin-bottom: 6px; text-transform: uppercase; letter-spacing: .6px; }

@media (max-width: 768px) {
    .det-grid { grid-template-columns: 1fr; }
    .action-panel { position: static; }
}
</style>
@endpush

@section('content')
<div class="det-wrap">

    {{-- Back --}}
    <a href="{{ route('admin.laporan') }}" class="back-btn">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
        </svg>
        Kembali ke Daftar Laporan
    </a>

    {{-- Header --}}
    <div class="det-header">
        <div>
            <div class="det-title">{{ $report->subject }}</div>
            <div class="det-meta">
                <span class="pill pill-prio-{{ $report->priority }}">{{ $report->priority_label }}</span>
                <span class="pill pill-status-{{ $report->status }}">{{ $report->status_label }}</span>
                <span style="font-size:12px;color:var(--muted)">
                    #{{ $report->id }} · {{ $report->created_at->format('d M Y, H:i') }}
                </span>
            </div>
        </div>
        <div style="font-size:36px">
            @php $typeIcon=['produk_palsu'=>'📦','harga_tidak_wajar'=>'💸','penipuan'=>'⚠️','konten_tidak_pantas'=>'🚫','penjual_tidak_responsif'=>'📵','lainnya'=>'📋']; @endphp
            {{ $typeIcon[$report->type] ?? '📋' }}
        </div>
    </div>

    <div class="det-grid">

        {{-- Left column --}}
        <div>

            {{-- Deskripsi --}}
            <div class="det-card">
                <div class="det-card-header">📝 Deskripsi Laporan</div>
                <div class="det-card-body">
                    <div class="det-desc">{{ $report->description }}</div>
                </div>
            </div>

            {{-- Pelapor --}}
            <div class="det-card">
                <div class="det-card-header">👤 Pelapor</div>
                <div class="det-card-body">
                    <div class="user-row">
                        <div class="user-ava" style="background:linear-gradient(135deg,var(--accent),#1a6640)">
                            {{ strtoupper(substr($report->reporter->nama_lengkap ?? 'U', 0, 1)) }}
                        </div>
                        <div>
                            <div class="user-name">{{ $report->reporter->nama_lengkap ?? '—' }}</div>
                            <div class="user-sub">{{ $report->reporter->email ?? '' }} · {{ ucfirst($report->reporter->role ?? '') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Terlapor --}}
            @if($report->reportedUser)
            <div class="det-card">
                <div class="det-card-header">🎯 Terlapor</div>
                <div class="det-card-body">
                    <div class="user-row">
                        <div class="user-ava" style="background:linear-gradient(135deg,#e05c5c,#991b1b)">
                            {{ strtoupper(substr($report->reportedUser->nama_lengkap ?? 'U', 0, 1)) }}
                        </div>
                        <div>
                            <div class="user-name">{{ $report->reportedUser->nama_lengkap }}</div>
                            <div class="user-sub">{{ $report->reportedUser->email }} · {{ ucfirst($report->reportedUser->role) }}</div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            {{-- Produk/Harvest terkait --}}
            @if($report->harvest)
            <div class="det-card">
                <div class="det-card-header">🌾 Produk Terkait</div>
                <div class="det-card-body">
                    <div style="font-size:14px;font-weight:700;color:var(--text)">
                        {{ $report->harvest->product->name ?? '—' }}
                    </div>
                    <div style="font-size:12px;color:var(--muted);margin-top:4px">
                        Harvest ID: #{{ $report->harvest_id }} ·
                        Panen: {{ $report->harvest->harvest_date?->format('d M Y') ?? '—' }} ·
                        Harga: Rp {{ number_format($report->harvest->price_per_unit, 0, ',', '.') }}
                    </div>
                </div>
            </div>
            @endif

            {{-- Catatan admin (kalau sudah ada) --}}
            @if($report->admin_note)
            <div class="det-card">
                <div class="det-card-header">📌 Catatan Admin</div>
                <div class="det-card-body">
                    <div class="admin-note-box {{ $report->status === 'dismissed' ? 'dismissed' : '' }}">{{ $report->admin_note }}</div>
                    @if($report->handler)
                    <div style="margin-top:10px;font-size:12px;color:var(--muted)">
                        Ditangani oleh <strong>{{ $report->handler->nama_lengkap }}</strong>
                        pada {{ $report->handled_at?->format('d M Y, H:i') }}
                    </div>
                    @endif
                </div>
            </div>
            @endif

        </div>

        {{-- Right column — Action panel --}}
        <div>
            <div class="action-panel">
                <div class="action-panel-title">⚡ Tindakan Moderasi</div>

                {{-- Info --}}
                <div class="info-list" style="margin-bottom:18px;padding-bottom:16px;border-bottom:1px solid var(--border)">
                    <div class="info-row">
                        <span class="label">Tipe</span>
                        <span class="val">{{ $report->type_label }}</span>
                    </div>
                    <div class="info-row">
                        <span class="label">Prioritas</span>
                        <span class="val">{{ $report->priority_label }}</span>
                    </div>
                    <div class="info-row">
                        <span class="label">Status</span>
                        <span class="val">{{ $report->status_label }}</span>
                    </div>
                    <div class="info-row">
                        <span class="label">Masuk</span>
                        <span class="val">{{ $report->created_at->diffForHumans() }}</span>
                    </div>
                </div>

                @if($report->status === 'pending')
                    {{-- Mulai tinjau --}}
                    <form method="POST" action="{{ route('admin.laporan.startReview', $report) }}">
                        @csrf @method('PATCH')
                        <button type="submit" class="ap-btn ap-btn-review">
                            🔍 Mulai Tinjau
                        </button>
                    </form>
                    {{-- Langsung selesaikan --}}
                    <button class="ap-btn ap-btn-resolve" onclick="toggleResolveForm()">
                        ✅ Selesaikan
                    </button>
                    <button class="ap-btn ap-btn-dismiss" onclick="toggleDismissForm()">
                        ✕ Tolak Laporan
                    </button>

                @elseif($report->status === 'reviewing')
                    <div style="font-size:12px;color:#1e40af;background:#dbeafe;border-radius:8px;padding:10px 12px;margin-bottom:12px;font-weight:600">
                        🔍 Laporan sedang ditinjau
                    </div>
                    <button class="ap-btn ap-btn-resolve" onclick="toggleResolveForm()">
                        ✅ Selesaikan
                    </button>
                    <button class="ap-btn ap-btn-dismiss" onclick="toggleDismissForm()">
                        ✕ Tolak Laporan
                    </button>

                @else
                    <div style="font-size:12px;color:var(--muted);text-align:center;padding:12px 0">
                        Laporan ini sudah {{ $report->status_label }}
                    </div>
                @endif

                {{-- Resolve / Dismiss form (hidden by default) --}}
                @if(in_array($report->status, ['pending','reviewing']))
                <form method="POST" action="{{ route('admin.laporan.resolve', $report) }}" id="resolveInlineForm" style="display:none;margin-top:14px">
                    @csrf
                    <input type="hidden" name="action" id="inlineAction" value="resolved">

                    <div class="resolve-form">
                        <div class="resolve-form-label">Update Prioritas (opsional)</div>
                        <select name="priority">
                            <option value="">— Jangan ubah —</option>
                            <option value="low">Rendah</option>
                            <option value="medium">Sedang</option>
                            <option value="high">Tinggi</option>
                            <option value="critical">Kritis</option>
                        </select>

                        <div class="resolve-form-label">Catatan Admin <span style="color:#e05c5c">*</span></div>
                        <textarea name="admin_note" required minlength="10"
                            id="adminNoteInline"
                            placeholder="Tuliskan tindakan / alasan keputusan…"></textarea>
                    </div>

                    <div style="display:flex;gap:8px;margin-top:10px">
                        <button type="button" class="ap-btn ap-btn-secondary" onclick="toggleResolveForm()" style="flex:1;padding:9px">
                            Batal
                        </button>
                        <button type="submit" id="submitResolveBtn" class="ap-btn ap-btn-resolve" style="flex:1;padding:9px">
                            Kirim
                        </button>
                    </div>
                </form>
                @endif

                {{-- Back --}}
                <a href="{{ route('admin.laporan') }}" class="ap-btn ap-btn-secondary" style="margin-top:12px">
                    ← Kembali
                </a>
            </div>
        </div>

    </div>

</div>
@endsection

@push('scripts')
<script>
let resolveFormVisible = false;

function toggleResolveForm() {
    resolveFormVisible = !resolveFormVisible;
    const form = document.getElementById('resolveInlineForm');
    const btn  = document.getElementById('submitResolveBtn');
    const note = document.getElementById('adminNoteInline');
    const action = document.getElementById('inlineAction');

    if (resolveFormVisible) {
        action.value = 'resolved';
        btn.textContent = '✅ Selesaikan';
        btn.className = 'ap-btn ap-btn-resolve';
        form.style.display = 'block';
        note.focus();
    } else {
        form.style.display = 'none';
    }
}

function toggleDismissForm() {
    resolveFormVisible = true;
    const form = document.getElementById('resolveInlineForm');
    const btn  = document.getElementById('submitResolveBtn');
    const note = document.getElementById('adminNoteInline');
    const action = document.getElementById('inlineAction');

    action.value = 'dismissed';
    btn.textContent = '✕ Tolak Laporan';
    btn.className = 'ap-btn ap-btn-dismiss';
    form.style.display = 'block';
    note.placeholder = 'Tuliskan alasan penolakan laporan…';
    note.focus();
}
</script>
@endpush