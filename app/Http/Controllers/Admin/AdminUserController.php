<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminUserController extends Controller
{
    /**
     * Tampilkan daftar pengguna umum (role = buyer).
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'buyer')
            ->withCount([
                'orders',                                           // total transaksi
                'orders as selesai_count' => fn($q) =>            // transaksi selesai
                    $q->where('status', 'delivered'),
            ]);

        // ── Search ──────────────────────────────────────────
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('no_whatsapp', 'like', "%{$search}%");
            });
        }

        // ── Filter status ────────────────────────────────────
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'aktif' ? 1 : 0);
        }

        // ── Filter metode login ──────────────────────────────
        if ($request->input('login_method') === 'google') {
            $query->whereNotNull('google_id');
        } elseif ($request->input('login_method') === 'email') {
            $query->whereNull('google_id');
        }

        // ── Sort ─────────────────────────────────────────────
        $sort = $request->input('sort', 'terbaru');
        match ($sort) {
            'terlama' => $query->oldest(),
            'nama_az' => $query->orderBy('nama_lengkap'),
            'nama_za' => $query->orderByDesc('nama_lengkap'),
            'transaksi' => $query->orderByDesc('orders_count'),
            default => $query->latest(),   // terbaru
        };

        $users = $query->paginate(15)->withQueryString();

        // ── Statistik ringkasan ──────────────────────────────
        $stats = [
            'total' => User::where('role', 'buyer')->count(),
            'aktif' => User::where('role', 'buyer')->where('is_active', 1)->count(),
            'nonaktif' => User::where('role', 'buyer')->where('is_active', 0)->count(),
            'google' => User::where('role', 'buyer')->whereNotNull('google_id')->count(),
            'baru_bulan_ini' => User::where('role', 'buyer')
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
        ];

        return view('admin.pengguna', compact('users', 'stats'));
    }

    /**
     * Detail satu pengguna.
     */
    public function show(User $user)
    {
        abort_if($user->role !== 'buyer', 404);

        $user->load([
            'orders' => fn($q) => $q->latest()->limit(5),
        ]);

        return view('admin.pengguna-detail', compact('user'));
    }

    /**
     * Toggle status aktif / nonaktif pengguna.
     */
    public function toggleStatus(User $user)
    {
        abort_if($user->role !== 'buyer', 403);

        $user->update(['is_active' => !$user->is_active]);

        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('success', "Akun {$user->nama_lengkap} berhasil {$status}.");
    }

    /**
     * Hapus permanen pengguna (soft-delete via deleted_at).
     * Hanya bisa dilakukan jika belum ada transaksi aktif.
     */
    public function destroy(User $user)
    {
        abort_if($user->role !== 'buyer', 403);

        $hasActiveOrder = $user->orders()
            ->whereNotIn('status', ['delivered', 'cancelled', 'refunded'])
            ->exists();

        if ($hasActiveOrder) {
            return back()->with('error', 'Pengguna tidak dapat dihapus karena masih memiliki transaksi aktif.');
        }

        $user->delete(); // soft delete (deleted_at)

        return back()->with('success', "Akun {$user->nama_lengkap} berhasil dihapus.");
    }
}