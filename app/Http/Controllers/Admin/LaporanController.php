<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    /**
     * Daftar laporan aktif (pending + reviewing) dengan filter & search.
     */
    public function index(Request $request)
    {
        $query = Report::with(['reporter', 'reportedUser', 'harvest.product', 'handler'])
            ->orderByRaw("FIELD(priority,'critical','high','medium','low')")
            ->orderBy('created_at', 'asc');

        // Filter status
        $status = $request->get('status', 'active');
        if ($status === 'active') {
            $query->whereIn('status', ['pending', 'reviewing']);
        } elseif (in_array($status, ['pending', 'reviewing', 'resolved', 'dismissed'])) {
            $query->where('status', $status);
        }

        // Filter tipe
        if ($type = $request->get('type')) {
            $query->where('type', $type);
        }

        // Filter prioritas
        if ($priority = $request->get('priority')) {
            $query->where('priority', $priority);
        }

        // Search
        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('subject', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('reporter', fn($r) => $r->where('nama_lengkap', 'like', "%{$search}%"))
                  ->orWhereHas('reportedUser', fn($r) => $r->where('nama_lengkap', 'like', "%{$search}%"));
            });
        }

        $reports = $query->paginate(15)->withQueryString();

        // Stats untuk header cards
        $stats = [
            'active'    => Report::active()->count(),
            'pending'   => Report::pending()->count(),
            'reviewing' => Report::reviewing()->count(),
            'critical'  => Report::active()->where('priority', 'critical')->count(),
            'resolved_today' => Report::resolved()
                ->whereDate('handled_at', today())->count(),
        ];

        return view('admin.laporan.index', compact('reports', 'stats', 'status'));
    }

    /**
     * Detail laporan.
     */
    public function show(Report $report)
    {
        $report->load(['reporter', 'reportedUser.sellerProfile', 'harvest.product', 'handler']);
        return view('admin.laporan.show', compact('report'));
    }

    /**
     * Mulai meninjau laporan (status → reviewing).
     */
    public function startReview(Report $report)
    {
        if ($report->status !== 'pending') {
            return back()->with('error', 'Laporan tidak dalam status pending.');
        }

        $report->update([
            'status'     => 'reviewing',
            'handled_by' => Auth::id(),
        ]);

        return back()->with('success', 'Laporan sedang ditinjau.');
    }

    /**
     * Selesaikan laporan (resolved / dismissed) beserta catatan admin.
     */
    public function resolve(Request $request, Report $report)
    {
        $request->validate([
            'action'     => 'required|in:resolved,dismissed',
            'admin_note' => 'required|string|min:10|max:1000',
            'priority'   => 'nullable|in:low,medium,high,critical',
        ]);

        $report->update([
            'status'     => $request->action,
            'admin_note' => $request->admin_note,
            'handled_by' => Auth::id(),
            'handled_at' => now(),
            'priority'   => $request->priority ?? $report->priority,
        ]);

        // Opsional: nonaktifkan akun terlapor jika resolved + critical
        if ($request->action === 'resolved'
            && $report->priority === 'critical'
            && $report->reportedUser) {
            // $report->reportedUser->update(['is_active' => false]);
            // ↑ Uncomment jika ingin auto-suspend akun terlapor
        }

        $label = $request->action === 'resolved' ? 'diselesaikan' : 'ditolak';
        return redirect()->route('admin.laporan')
            ->with('success', "Laporan berhasil {$label}.");
    }

    /**
     * Update prioritas laporan via AJAX.
     */
    public function updatePriority(Request $request, Report $report)
    {
        $request->validate(['priority' => 'required|in:low,medium,high,critical']);
        $report->update(['priority' => $request->priority]);

        return response()->json(['success' => true, 'priority' => $report->priority]);
    }

    /**
     * Statistik untuk chart di dashboard (opsional — bisa dipanggil via AJAX).
     */
    public function stats()
    {
        $byType = Report::active()
            ->select('type', DB::raw('count(*) as total'))
            ->groupBy('type')
            ->pluck('total', 'type');

        $byDay = Report::where('created_at', '>=', now()->subDays(7))
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return response()->json(compact('byType', 'byDay'));
    }
}