<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\HarvestSchedule;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SellerJadwalPanenController extends Controller
{
    /**
     * Tampilkan daftar jadwal panen milik seller yang login.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = HarvestSchedule::with('category')
            ->forSeller($user->id)
            ->orderBy('estimasi_panen', 'asc');

        // Filter status
        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        // Filter kategori
        if ($categoryId = $request->get('category_id')) {
            $query->where('category_id', $categoryId);
        }

        // Search
        if ($search = $request->get('search')) {
            $query->where('nama_tanaman', 'like', "%{$search}%");
        }

        $jadwals = $query->paginate(12)->withQueryString();

        // Stats
        $stats = [
            'total'         => HarvestSchedule::forSeller($user->id)->count(),
            'aktif'         => HarvestSchedule::forSeller($user->id)->active()->count(),
            'siap_panen'    => HarvestSchedule::forSeller($user->id)->where('status', 'siap_panen')->count(),
            'upcoming_7'    => HarvestSchedule::forSeller($user->id)->upcoming(7)->count(),
            'selesai'       => HarvestSchedule::forSeller($user->id)->where('status', 'selesai')->count(),
        ];

        // Estimasi total kuantitas siap panen
        $estimasiKuantitas = HarvestSchedule::forSeller($user->id)
            ->where('status', 'siap_panen')
            ->sum('estimasi_kuantitas');

        $categories = Category::all();

        return view('seller.jadwal.index', compact(
            'jadwals', 'stats', 'categories', 'estimasiKuantitas'
        ));
    }

    /**
     * Simpan jadwal panen baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_tanaman'       => 'required|string|max:255',
            'category_id'        => 'nullable|exists:categories,id',
            'tanggal_tanam'      => 'nullable|date|before_or_equal:estimasi_panen',
            'estimasi_panen'     => 'required|date|after_or_equal:today',
            'estimasi_kuantitas' => 'nullable|numeric|min:0',
            'satuan'             => 'nullable|string|max:20',
            'kebun_lokasi'       => 'nullable|string|max:255',
            'metode_tanam'       => 'nullable|in:konvensional,organik,hidroponik,permakultur,lainnya',
            'luas_lahan'         => 'nullable|numeric|min:0',
            'is_organic'         => 'boolean',
            'catatan'            => 'nullable|string|max:1000',
        ], [
            'nama_tanaman.required'   => 'Nama tanaman wajib diisi.',
            'estimasi_panen.required' => 'Estimasi tanggal panen wajib diisi.',
            'estimasi_panen.after_or_equal' => 'Estimasi panen tidak boleh di masa lalu.',
            'tanggal_tanam.before_or_equal' => 'Tanggal tanam harus sebelum atau sama dengan estimasi panen.',
        ]);

        $validated['user_id']   = Auth::id();
        $validated['is_organic'] = $request->boolean('is_organic');
        $validated['status']    = 'direncanakan';

        HarvestSchedule::create($validated);

        return redirect()->route('seller.jadwal.index')
            ->with('success', '✅ Jadwal panen berhasil ditambahkan!');
    }

    /**
     * Update jadwal panen yang sudah ada.
     */
    public function update(Request $request, HarvestSchedule $jadwal)
    {
        // Pastikan milik seller yang login
        if ($jadwal->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        $validated = $request->validate([
            'nama_tanaman'       => 'required|string|max:255',
            'category_id'        => 'nullable|exists:categories,id',
            'tanggal_tanam'      => 'nullable|date',
            'estimasi_panen'     => 'required|date',
            'estimasi_kuantitas' => 'nullable|numeric|min:0',
            'satuan'             => 'nullable|string|max:20',
            'kebun_lokasi'       => 'nullable|string|max:255',
            'metode_tanam'       => 'nullable|in:konvensional,organik,hidroponik,permakultur,lainnya',
            'luas_lahan'         => 'nullable|numeric|min:0',
            'is_organic'         => 'boolean',
            'catatan'            => 'nullable|string|max:1000',
            'status'             => 'required|in:direncanakan,sedang_tumbuh,siap_panen,selesai,gagal',
        ]);

        $validated['is_organic'] = $request->boolean('is_organic');

        $jadwal->update($validated);

        return redirect()->route('seller.jadwal.index')
            ->with('success', '✅ Jadwal panen berhasil diperbarui!');
    }

    /**
     * Update hanya status (PATCH cepat dari card/table).
     */
    public function updateStatus(Request $request, HarvestSchedule $jadwal)
    {
        if ($jadwal->user_id !== Auth::id()) {
            return response()->json(['error' => 'Akses ditolak.'], 403);
        }

        $request->validate([
            'status' => 'required|in:direncanakan,sedang_tumbuh,siap_panen,selesai,gagal',
        ]);

        $jadwal->update(['status' => $request->status]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'status'  => $jadwal->status,
                'label'   => $jadwal->status_label,
            ]);
        }

        return back()->with('success', 'Status jadwal diperbarui.');
    }

    /**
     * Return data jadwal sebagai JSON (untuk modal edit).
     */
    public function editData(HarvestSchedule $jadwal)
    {
        if ($jadwal->user_id !== Auth::id()) {
            return response()->json(['error' => 'Akses ditolak.'], 403);
        }

        return response()->json([
            'id'                 => $jadwal->id,
            'nama_tanaman'       => $jadwal->nama_tanaman,
            'category_id'        => $jadwal->category_id,
            'metode_tanam'       => $jadwal->metode_tanam,
            'tanggal_tanam'      => $jadwal->tanggal_tanam?->format('Y-m-d'),
            'estimasi_panen'     => $jadwal->estimasi_panen->format('Y-m-d'),
            'estimasi_kuantitas' => $jadwal->estimasi_kuantitas,
            'satuan'             => $jadwal->satuan,
            'luas_lahan'         => $jadwal->luas_lahan,
            'kebun_lokasi'       => $jadwal->kebun_lokasi,
            'status'             => $jadwal->status,
            'catatan'            => $jadwal->catatan,
            'is_organic'         => $jadwal->is_organic ? 1 : 0,
        ]);
    }

    /**
     * Hapus jadwal panen.
     */
    public function destroy(HarvestSchedule $jadwal)
    {
        if ($jadwal->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        $jadwal->delete();

        return redirect()->route('seller.jadwal.index')
            ->with('success', '🗑️ Jadwal panen berhasil dihapus.');
    }
}
