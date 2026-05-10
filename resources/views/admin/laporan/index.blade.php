@extends('layouts.admin')

@section('title', 'Laporan Aktif')

@php
    $priorityColor = [
        'critical' => ['bg' => '#fee2e2', 'text' => '#991b1b', 'dot' => '#e05c5c', 'label' => 'Kritis'],
        'high'     => ['bg' => '#ffedd5', 'text' => '#9a3412', 'dot' => '#f97316', 'label' => 'Tinggi'],
        'medium'   => ['bg' => '#fef9c3', 'text' => '#854d0e', 'dot' => '#eab308', 'label' => 'Sedang'],
        'low'      => ['bg' => '#f0fdf4', 'text' => '#166534', 'dot' => '#3dba7e', 'label' => 'Rendah'],
    ];
    $typeIcon = [
        'produk_palsu'            => '📦',
        'harga_tidak_wajar'       => '💸',
        'penipuan'                => '⚠️',
        'konten_tidak_pantas'     => '🚫',
        'penjual_tidak_responsif' => '📵',
        'lainnya'                 => '📋',
    ];
    $statusColor = [
        'pending'   => ['bg' => '#fef9c3', 'text' => '#854d0e'],
        'reviewing' => ['bg' => '#dbeafe', 'text' => '#1e40af'],
        'resolved'  => ['bg' => '#f0fdf4', 'text' => '#166534'],
        'dismissed' => ['bg' => '#f3f4f6', 'text' => '#6b7280'],
    ];
@endphp

@push('styles')
<style>
/* ── Page layout ─────────────────────────────────────── */
.lap-wrap { padding: 0 0 40px; }

/* ── Page header ─────────────────────────────────────── */
.lap-header {
    display: flex; align-items: flex-start; justify-content: space-between;
    margin-bottom: 24px; gap: 16px; flex-wrap: wrap;
}
.lap-title { font-size: 22px; font-weight: 800; color: var(--text); }
.lap-sub { font-size: 13px; color: var(--muted); font-weight: 500; margin-top: 2px; }

/* ── Stat cards ──────────────────────────────────────── */
.stat-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 14px; margin-bottom: 24px;
}
.stat-card {
    background: var(--surface); border: 1.5px solid var(--border);
    border-radius: 16px; padding: 18px 20px;
    display: flex; flex-direction: column; gap: 4px;
    transition: border-color .2s, box-shadow .2s;
}
.stat-card:hover { border-color: var(--accent); box-shadow: 0 0 0 3px rgba(61,186,126,.08); }
.stat-label { font-size: 11px; font-weight: 700; color: var(--muted); text-transform: uppercase; letter-spacing: .8px; }
.stat-num { font-size: 28px; font-weight: 800; color: var(--text); line-height: 1; }
.stat-card.danger .stat-num  { color: #e05c5c; }
.stat-card.warn   .stat-num  { color: #f59e0b; }
.stat-card.info   .stat-num  { color: #3b82f6; }
.stat-card.green  .stat-num  { color: var(--accent); }
.stat-trend { font-size: 11px; color: var(--muted); margin-top: 2px; }

/* ── Toolbar ─────────────────────────────────────────── */
.toolbar {
    display: flex; align-items: center; gap: 10px;
    margin-bottom: 18px; flex-wrap: wrap;
}
.toolbar-search {
    flex: 1; min-width: 200px; max-width: 340px;
    display: flex; align-items: center; gap: 8px;
    background: var(--surface); border: 1.5px solid var(--border);
    border-radius: 12px; padding: 9px 14px;
    transition: border-color .2s;
}
.toolbar-search:focus-within { border-color: var(--accent); box-shadow: 0 0 0 3px rgba(61,186,126,.1); }
.toolbar-search svg { width: 15px; height: 15px; color: var(--muted); flex-shrink: 0; }
.toolbar-search input { border: none; outline: none; background: transparent; font-family: inherit; font-size: 13px; color: var(--text); width: 100%; }
.toolbar-search input::placeholder { color: var(--muted); }

.tb-select {
    background: var(--surface); border: 1.5px solid var(--border);
    border-radius: 12px; padding: 9px 14px;
    font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px;
    font-weight: 600; color: var(--text); cursor: pointer; outline: none;
    transition: border-color .2s;
}
.tb-select:focus { border-color: var(--accent); }

/* Tab pills */
.tab-pills { display: flex; gap: 4px; background: var(--surface); border: 1.5px solid var(--border); border-radius: 12px; padding: 4px; }
.tab-pill {
    padding: 6px 14px; border-radius: 8px; font-size: 12px;
    font-weight: 700; cursor: pointer; border: none; background: transparent;
    color: var(--muted); font-family: 'Plus Jakarta Sans', sans-serif;
    transition: background .18s, color .18s; white-space: nowrap;
}
.tab-pill.active { background: var(--accent); color: #fff; }
.tab-pill:hover:not(.active) { background: rgba(61,186,126,.08); color: var(--text); }

/* ── Table ───────────────────────────────────────────── */
.lap-table-wrap {
    background: var(--surface); border: 1.5px solid var(--border);
    border-radius: 18px; overflow: hidden; box-shadow: 0 1px 4px rgba(0,0,0,.04);
}
.lap-table { width: 100%; border-collapse: collapse; }
.lap-table thead tr { background: var(--surface2); border-bottom: 1.5px solid var(--border); }
.lap-table th {
    padding: 12px 16px; text-align: left; font-size: 11px;
    font-weight: 700; color: var(--muted); text-transform: uppercase;
    letter-spacing: .8px; white-space: nowrap;
}
.lap-table tbody tr {
    border-bottom: 1px solid var(--border);
    transition: background .15s;
}
.lap-table tbody tr:last-child { border-bottom: none; }
.lap-table tbody tr:hover { background: #fafffe; }
.lap-table td { padding: 14px 16px; vertical-align: middle; }

/* Priority dot */
.prio-dot {
    display: inline-flex; align-items: center; gap: 6px;
    font-size: 12px; font-weight: 700; padding: 4px 10px;
    border-radius: 20px; white-space: nowrap;
}
.prio-dot::before { content: ''; width: 7px; height: 7px; border-radius: 50%; background: currentColor; }

/* Status pill */
.status-pill { font-size: 11px; font-weight: 700; padding: 4px 10px; border-radius: 20px; white-space: nowrap; }

/* Type tag */
.type-tag { font-size: 12px; font-weight: 600; color: var(--text); display: flex; align-items: center; gap: 5px; }

/* Reporter */
.reporter-cell { display: flex; align-items: center; gap: 10px; }
.reporter-ava {
    width: 34px; height: 34px; border-radius: 10px; flex-shrink: 0;
    background: linear-gradient(135deg, var(--accent), #1a6640);
    display: flex; align-items: center; justify-content: center;
    font-size: 12px; font-weight: 800; color: #fff;
}
.reporter-name { font-size: 13px; font-weight: 700; color: var(--text); }
.reporter-sub { font-size: 11px; color: var(--muted); }

/* Subject */
.subject-cell .subj-title { font-size: 13px; font-weight: 700; color: var(--text); margin-bottom: 2px; }
.subject-cell .subj-desc { font-size: 11px; color: var(--muted); display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden; }

/* Actions */
.act-btn {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 6px 12px; border-radius: 8px; font-size: 12px;
    font-weight: 700; border: 1.5px solid transparent; cursor: pointer;
    transition: all .18s; font-family: 'Plus Jakarta Sans', sans-serif;
    text-decoration: none;
}
.act-btn-view { background: var(--surface2); border-color: var(--border); color: var(--text); }
.act-btn-view:hover { border-color: var(--accent); color: var(--accent); }
.act-btn-review { background: #dbeafe; border-color: #93c5fd; color: #1e40af; }
.act-btn-review:hover { background: #bfdbfe; }

/* Empty state */
.empty-state { padding: 60px 24px; text-align: center; }
.empty-state .es-icon { font-size: 48px; margin-bottom: 14px; }
.empty-state .es-title { font-size: 16px; font-weight: 800; color: var(--text); margin-bottom: 6px; }
.empty-state .es-sub { font-size: 13px; color: var(--muted); }

/* Pagination */
.pag-wrap { display: flex; align-items: center; justify-content: space-between; padding: 16px 20px; border-top: 1px solid var(--border); }
.pag-info { font-size: 12px; color: var(--muted); font-weight: 600; }

/* Toast */
.seara-toast {
    position: fixed; bottom: 24px; left: 50%; transform: translateX(-50%);
    background: var(--bg); color: #fff; padding: 12px 22px; border-radius: 12px;
    font-size: 13px; font-weight: 700; z-index: 9999; opacity: 0;
    transition: opacity .3s; pointer-events: none; white-space: nowrap;
    box-shadow: 0 6px 24px rgba(0,0,0,.25);
}
.seara-toast.show { opacity: 1; }

/* Resolve modal */
.modal-backdrop {
    display: none; position: fixed; inset: 0; z-index: 999;
    background: rgba(0,0,0,.45); backdrop-filter: blur(4px);
    align-items: center; justify-content: center;
}
.modal-backdrop.open { display: flex; }
.modal-box {
    background: #fff; border-radius: 20px; padding: 28px; width: 100%;
    max-width: 460px; margin: 16px; box-shadow: 0 20px 60px rgba(0,0,0,.2);
    animation: modalIn .22s ease;
}
@keyframes modalIn { from { opacity:0; transform:scale(.94) translateY(10px); } to { opacity:1; transform:scale(1) translateY(0); } }
.modal-title { font-size: 16px; font-weight: 800; color: var(--text); margin-bottom: 18px; }
.modal-label { font-size: 12px; font-weight: 700; color: var(--muted); margin-bottom: 6px; text-transform: uppercase; letter-spacing: .6px; }
.modal-textarea {
    width: 100%; border: 1.5px solid var(--border); border-radius: 12px;
    padding: 10px 14px; font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 13px; color: var(--text); resize: vertical; min-height: 90px; outline: none;
    transition: border-color .2s;
}
.modal-textarea:focus { border-color: var(--accent); }
.modal-select {
    width: 100%; border: 1.5px solid var(--border); border-radius: 12px;
    padding: 10px 14px; font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 13px; color: var(--text); outline: none; background: #fff;
    transition: border-color .2s; cursor: pointer;
}
.modal-select:focus { border-color: var(--accent); }
.modal-actions { display: flex; gap: 10px; margin-top: 20px; }
.modal-btn {
    flex: 1; padding: 11px; border-radius: 12px; font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 13px; font-weight: 700; cursor: pointer; border: 1.5px solid transparent;
    transition: all .18s;
}
.modal-btn-cancel { background: var(--surface2); border-color: var(--border); color: var(--muted); }
.modal-btn-cancel:hover { border-color: var(--accent); color: var(--text); }
.modal-btn-resolve { background: var(--accent); color: #fff; border-color: var(--accent); }
.modal-btn-resolve:hover { background: #2fa36a; }
.modal-btn-dismiss { background: #e05c5c; color: #fff; border-color: #e05c5c; }
.modal-btn-dismiss:hover { background: #c94f4f; }

/* Blink on critical */
@keyframes criticalPulse { 0%,100% { opacity:1; } 50% { opacity:.5; } }
.critical-blink { animation: criticalPulse 1.8s ease-in-out infinite; }

@media (max-width: 1100px) {
    .stat-grid { grid-template-columns: repeat(3,1fr); }
}
@media (max-width: 768px) {
    .stat-grid { grid-template-columns: repeat(2,1fr); }
    .lap-table th:nth-child(4), .lap-table td:nth-child(4) { display: none; }
}
</style>
@endpush

@section('content')
<div class="lap-wrap">

    {{-- Header --}}
    <div class="lap-header">
        <div>
            <div class="lap-title">⚠️ Laporan Aktif</div>
            <div class="lap-sub">Kelola dan tinjau laporan dari pengguna platform SEARA</div>
        </div>
    </div>

    {{-- Flash messages --}}
    @if(session('success'))
    <div style="background:#f0fdf4;border:1.5px solid #86efac;border-radius:12px;padding:12px 18px;margin-bottom:18px;font-size:13px;font-weight:700;color:#166534;display:flex;align-items:center;gap:8px;">
        ✅ {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div style="background:#fee2e2;border:1.5px solid #fca5a5;border-radius:12px;padding:12px 18px;margin-bottom:18px;font-size:13px;font-weight:700;color:#991b1b;display:flex;align-items:center;gap:8px;">
        ❌ {{ session('error') }}
    </div>
    @endif

    {{-- Stat cards --}}
    <div class="stat-grid">
        <div class="stat-card danger">
            <div class="stat-label">Total Aktif</div>
            <div class="stat-num">{{ $stats['active'] }}</div>
            <div class="stat-trend">Perlu penanganan</div>
        </div>
        <div class="stat-card warn">
            <div class="stat-label">Menunggu</div>
            <div class="stat-num">{{ $stats['pending'] }}</div>
            <div class="stat-trend">Belum ditinjau</div>
        </div>
        <div class="stat-card info">
            <div class="stat-label">Ditinjau</div>
            <div class="stat-num">{{ $stats['reviewing'] }}</div>
            <div class="stat-trend">Sedang diproses</div>
        </div>
        <div class="stat-card danger">
            <div class="stat-label">🔴 Kritis</div>
            <div class="stat-num {{ $stats['critical'] > 0 ? 'critical-blink' : '' }}">{{ $stats['critical'] }}</div>
            <div class="stat-trend">Prioritas tertinggi</div>
        </div>
        <div class="stat-card green">
            <div class="stat-label">Selesai Hari Ini</div>
            <div class="stat-num">{{ $stats['resolved_today'] }}</div>
            <div class="stat-trend">Laporan diselesaikan</div>
        </div>
    </div>

    {{-- Toolbar --}}
    <form method="GET" action="{{ route('admin.laporan') }}" id="filterForm">
        <div class="toolbar">
            {{-- Search --}}
            <div class="toolbar-search">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path stroke-linecap="round" d="m21 21-4.35-4.35"/></svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari laporan, pelapor..." onchange="document.getElementById('filterForm').submit()">
            </div>

            {{-- Status tabs --}}
            <div class="tab-pills">
                @foreach([
                    'active'    => 'Semua Aktif',
                    'pending'   => 'Pending',
                    'reviewing' => 'Ditinjau',
                    'resolved'  => 'Selesai',
                    'dismissed' => 'Ditolak',
                ] as $val => $lab)
                <button type="submit" name="status" value="{{ $val }}"
                    class="tab-pill {{ $status === $val ? 'active' : '' }}">
                    {{ $lab }}
                </button>
                @endforeach
            </div>

            {{-- Type filter --}}
            <select name="type" class="tb-select" onchange="document.getElementById('filterForm').submit()">
                <option value="">Semua Tipe</option>
                @foreach(\App\Models\Report::typeLabels() as $val => $lab)
                <option value="{{ $val }}" {{ request('type') === $val ? 'selected' : '' }}>{{ $lab }}</option>
                @endforeach
            </select>

            {{-- Priority filter --}}
            <select name="priority" class="tb-select" onchange="document.getElementById('filterForm').submit()">
                <option value="">Semua Prioritas</option>
                @foreach(\App\Models\Report::priorityLabels() as $val => $lab)
                <option value="{{ $val }}" {{ request('priority') === $val ? 'selected' : '' }}>{{ $lab }}</option>
                @endforeach
            </select>
        </div>
    </form>

    {{-- Table --}}
    <div class="lap-table-wrap">
        @if($reports->isEmpty())
        <div class="empty-state">
            <div class="es-icon">🎉</div>
            <div class="es-title">Tidak ada laporan aktif</div>
            <div class="es-sub">Semua laporan sudah ditangani atau belum ada laporan masuk</div>
        </div>
        @else
        <table class="lap-table">
            <thead>
                <tr>
                    <th>Prioritas</th>
                    <th>Laporan</th>
                    <th>Pelapor</th>
                    <th>Terlapor</th>
                    <th>Tipe</th>
                    <th>Status</th>
                    <th>Waktu</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reports as $r)
                @php
                    $pc = $priorityColor[$r->priority] ?? $priorityColor['medium'];
                    $sc = $statusColor[$r->status] ?? $statusColor['pending'];
                @endphp
                <tr>
                    {{-- Priority --}}
                    <td>
                        <span class="prio-dot" style="background:{{ $pc['bg'] }};color:{{ $pc['dot'] }}">
                            {{ $pc['label'] }}
                        </span>
                    </td>

                    {{-- Subject --}}
                    <td>
                        <div class="subject-cell">
                            <div class="subj-title">{{ Str::limit($r->subject, 45) }}</div>
                            <div class="subj-desc">{{ Str::limit($r->description, 60) }}</div>
                        </div>
                    </td>

                    {{-- Reporter --}}
                    <td>
                        <div class="reporter-cell">
                            <div class="reporter-ava">{{ strtoupper(substr($r->reporter->nama_lengkap ?? 'U', 0, 1)) }}</div>
                            <div>
                                <div class="reporter-name">{{ $r->reporter->nama_lengkap ?? '—' }}</div>
                                <div class="reporter-sub">{{ $r->reporter->role ?? '' }}</div>
                            </div>
                        </div>
                    </td>

                    {{-- Reported user --}}
                    <td>
                        @if($r->reportedUser)
                        <div class="reporter-cell">
                            <div class="reporter-ava" style="background:linear-gradient(135deg,#e05c5c,#991b1b)">
                                {{ strtoupper(substr($r->reportedUser->nama_lengkap ?? 'U', 0, 1)) }}
                            </div>
                            <div>
                                <div class="reporter-name">{{ $r->reportedUser->nama_lengkap }}</div>
                                <div class="reporter-sub">{{ $r->reportedUser->role }}</div>
                            </div>
                        </div>
                        @else
                        <span style="color:var(--muted);font-size:12px">—</span>
                        @endif
                    </td>

                    {{-- Type --}}
                    <td>
                        <span class="type-tag">
                            {{ $typeIcon[$r->type] ?? '📋' }} {{ $r->type_label }}
                        </span>
                    </td>

                    {{-- Status --}}
                    <td>
                        <span class="status-pill" style="background:{{ $sc['bg'] }};color:{{ $sc['text'] }}">
                            {{ $r->status_label }}
                        </span>
                    </td>

                    {{-- Time --}}
                    <td>
                        <div style="font-size:12px;color:var(--muted);white-space:nowrap">
                            {{ $r->created_at->diffForHumans() }}
                        </div>
                        <div style="font-size:11px;color:var(--muted)">{{ $r->created_at->format('d M Y') }}</div>
                    </td>

                    {{-- Actions --}}
                    <td>
                        <div style="display:flex;gap:6px;align-items:center">
                            <a href="{{ route('admin.laporan.show', $r) }}" class="act-btn act-btn-view">
                                <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                Detail
                            </a>
                            @if($r->status === 'pending')
                            <form method="POST" action="{{ route('admin.laporan.startReview', $r) }}">
                                @csrf @method('PATCH')
                                <button type="submit" class="act-btn act-btn-review">Tinjau</button>
                            </form>
                            @endif
                            @if(in_array($r->status, ['pending','reviewing']))
                            <button class="act-btn" onclick="openResolveModal({{ $r->id }})"
                                style="background:#f0fdf4;border-color:#86efac;color:#166534">
                                Selesaikan
                            </button>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="pag-wrap">
            <div class="pag-info">
                Menampilkan {{ $reports->firstItem() }}–{{ $reports->lastItem() }} dari {{ $reports->total() }} laporan
            </div>
            {{ $reports->links() }}
        </div>
        @endif
    </div>

</div>

{{-- ── Resolve Modal ───────────────────────────────────────── --}}
<div class="modal-backdrop" id="resolveModal" onclick="if(event.target===this)closeResolveModal()">
    <div class="modal-box">
        <div class="modal-title">Selesaikan Laporan</div>

        <form method="POST" id="resolveForm">
            @csrf
            <input type="hidden" name="action" id="resolveAction" value="resolved">

            <div style="margin-bottom:14px">
                <div class="modal-label">Catatan Admin <span style="color:#e05c5c">*</span></div>
                <textarea name="admin_note" class="modal-textarea"
                    placeholder="Tuliskan tindakan yang diambil, alasan keputusan, dll…"
                    minlength="10" required></textarea>
            </div>

            <div style="margin-bottom:4px">
                <div class="modal-label">Update Prioritas (opsional)</div>
                <select name="priority" class="modal-select">
                    <option value="">— Jangan ubah —</option>
                    <option value="low">Rendah</option>
                    <option value="medium">Sedang</option>
                    <option value="high">Tinggi</option>
                    <option value="critical">Kritis</option>
                </select>
            </div>

            <div class="modal-actions">
                <button type="button" class="modal-btn modal-btn-cancel" onclick="closeResolveModal()">Batal</button>
                <button type="button" class="modal-btn modal-btn-dismiss"
                    onclick="setAction('dismissed')">Tolak Laporan</button>
                <button type="button" class="modal-btn modal-btn-resolve"
                    onclick="setAction('resolved')">✅ Selesaikan</button>
            </div>
        </form>
    </div>
</div>

{{-- Toast --}}
<div class="seara-toast" id="searaToast"></div>

@endsection

@push('scripts')
<script>
// ── Resolve modal ─────────────────────────────────────────────────────────
const resolveModal = document.getElementById('resolveModal');
const resolveForm  = document.getElementById('resolveForm');

function openResolveModal(reportId) {
    resolveForm.action = `/admin/laporan/${reportId}/resolve`;
    resolveModal.classList.add('open');
    resolveModal.querySelector('textarea').focus();
}
function closeResolveModal() {
    resolveModal.classList.remove('open');
    resolveForm.reset();
}
function setAction(action) {
    document.getElementById('resolveAction').value = action;
    resolveForm.requestSubmit();
}

// ── Toast ─────────────────────────────────────────────────────────────────
function showToast(msg, type = 'success') {
    const t = document.getElementById('searaToast');
    t.textContent = msg;
    t.style.background = type === 'error' ? '#991b1b' : '#132b1e';
    t.classList.add('show');
    setTimeout(() => t.classList.remove('show'), 2800);
}

@if(session('success')) showToast('{{ session('success') }}'); @endif
@if(session('error'))   showToast('{{ session('error') }}', 'error'); @endif
</script>
@endpush