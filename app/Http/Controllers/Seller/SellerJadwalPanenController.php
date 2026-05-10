<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\HarvestSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerJadwalPanenController extends Controller
{
    /* ────────────────────────────────────────────────
     |  INDEX  –  Daftar jadwal panen milik seller
     ──────────────────────────────────────────────── */
    public function index(Request $request)
    {
        $query = HarvestSchedule::forSeller()
            ->with('category')
            ->orderBy('estimasi_panen');

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter kategori
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter bulan estimasi panen
        if ($request->filled('bulan')) {
            $query->whereMonth('estimasi_panen', $request->bulan)
                ->whereYear('estimasi_panen', $request->filled('tahun')
                    ? $request->tahun
                    : now()->year);
        }

        $schedules = $query->paginate(12)->withQueryString();
        $categories = Category::orderBy('name')->get();

        // ── Stats untuk summary bar ──
        $all = HarvestSchedule::forSeller()->get();

        $stats = [
            'total' => $all->count(),
            'direncanakan' => $all->where('status', 'direncanakan')->count(),
            'sedang_tumbuh' => $all->where('status', 'sedang_tumbuh')->count(),
            'siap_panen' => $all->where('status', 'siap_panen')->count(),
            'selesai' => $all->where('status', 'selesai')->count(),
        ];

        // Jadwal yang panen dalam 7 hari ke depan
        $upcoming = HarvestSchedule::forSeller()
            ->whereBetween('estimasi_panen', [now(), now()->addDays(7)])
            ->whereNotIn('status', ['selesai', 'gagal'])
            ->count();

        return view('seller.jadwal_panen', compact(
            'schedules',
            'categories',
            'stats',
            'upcoming'
        ));
    }

    /* ────────────────────────────────────────────────
     |  STORE  –  Simpan jadwal baru
     ──────────────────────────────────────────────── */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_tanaman' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'tanggal_tanam' => 'nullable|date',
            'estimasi_panen' => 'required|date|after_or_equal:today',
            'estimasi_kuantitas' => 'nullable|numeric|min:0',
            'satuan' => 'nullable|string|max:20',
            'kebun_lokasi' => 'nullable|string|max:255',
            'metode_tanam' => 'nullable|in:organik,hidroponik,konvensional',
            'status' => 'required|in:direncanakan,sedang_tumbuh,siap_panen,selesai,gagal',
            'catatan' => 'nullable|string|max:1000',
            'luas_lahan' => 'nullable|numeric|min:0',
            'is_organic' => 'nullable|boolean',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['is_organic'] = $request->boolean('is_organic');

        HarvestSchedule::create($validated);

        return redirect()->route('seller.jadwal.index')
            ->with('success', '🌱 Jadwal panen berhasil ditambahkan!');
    }

    /* ────────────────────────────────────────────────
     |  UPDATE  –  Perbarui jadwal
     ──────────────────────────────────────────────── */
    public function update(Request $request, HarvestSchedule $jadwal)
    {
        $this->authorizeSchedule($jadwal);

        $validated = $request->validate([
            'nama_tanaman' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'tanggal_tanam' => 'nullable|date',
            'estimasi_panen' => 'required|date',
            'estimasi_kuantitas' => 'nullable|numeric|min:0',
            'satuan' => 'nullable|string|max:20',
            'kebun_lokasi' => 'nullable|string|max:255',
            'metode_tanam' => 'nullable|in:organik,hidroponik,konvensional',
            'status' => 'required|in:direncanakan,sedang_tumbuh,siap_panen,selesai,gagal',
            'catatan' => 'nullable|string|max:1000',
            'luas_lahan' => 'nullable|numeric|min:0',
            'is_organic' => 'nullable|boolean',
        ]);

        $validated['is_organic'] = $request->boolean('is_organic');

        $jadwal->update($validated);

        return redirect()->route('seller.jadwal.index')
            ->with('success', '✅ Jadwal panen berhasil diperbarui!');
    }

    /* ────────────────────────────────────────────────
     |  DESTROY  –  Hapus jadwal
     ──────────────────────────────────────────────── */
    public function destroy(HarvestSchedule $jadwal)
    {
        $this->authorizeSchedule($jadwal);
        $jadwal->delete();

        return redirect()->route('seller.jadwal.index')
            ->with('success', '🗑️ Jadwal berhasil dihapus.');
    }

    /* ────────────────────────────────────────────────
     |  QUICK STATUS UPDATE (AJAX-ready)
     ──────────────────────────────────────────────── */
    public function updateStatus(Request $request, HarvestSchedule $jadwal)
    {
        $this->authorizeSchedule($jadwal);

        $request->validate([
            'status' => 'required|in:direncanakan,sedang_tumbuh,siap_panen,selesai,gagal',
        ]);

        $jadwal->update(['status' => $request->status]);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'status' => $jadwal->status]);
        }

        return back()->with('success', 'Status jadwal diperbarui.');
    }

    /* ────────────────────────────────────────────────
     |  PRIVATE HELPER
     ──────────────────────────────────────────────── */
    private function authorizeSchedule(HarvestSchedule $jadwal): void
    {
        abort_if($jadwal->user_id !== Auth::id(), 403, 'Akses ditolak.');
    }
}