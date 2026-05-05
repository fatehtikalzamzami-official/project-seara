<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', '!=', 'admin')
            ->withCount([
                'orders',
                'orders as selesai_count' => fn($q) => $q->where('status', 'delivered'),
            ])
            ->with('sellerProfile:user_id,nama_toko,rating,total_transaksi,is_verified');

        // ── Filter role (tab) ─────────────────────────────
        if ($role = $request->input('role')) {
            $query->where('role', $role);
        }

        // ── Search ────────────────────────────────────────
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('no_whatsapp', 'like', "%{$search}%");
            });
        }

        // ── Filter status ─────────────────────────────────
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'aktif' ? 1 : 0);
        }

        // ── Filter metode login ───────────────────────────
        if ($request->input('login_method') === 'google') {
            $query->whereNotNull('google_id');
        } elseif ($request->input('login_method') === 'email') {
            $query->whereNull('google_id');
        }

        // ── Sort ──────────────────────────────────────────
        match ($request->input('sort', 'terbaru')) {
            'terlama' => $query->oldest(),
            'nama_az' => $query->orderBy('nama_lengkap'),
            'nama_za' => $query->orderByDesc('nama_lengkap'),
            'transaksi' => $query->orderByDesc('orders_count'),
            default => $query->latest(),
        };

        $users = $query->paginate(15)->withQueryString();

        // ── Hitung per-role untuk badge tab ──────────────
        $roleCounts = User::where('role', '!=', 'admin')
            ->selectRaw('role, COUNT(*) as total')
            ->groupBy('role')
            ->pluck('total', 'role');

        $stats = [
            'total' => User::where('role', '!=', 'admin')->count(),
            'buyer' => $roleCounts['buyer'] ?? 0,
            'seller' => $roleCounts['seller'] ?? 0,
            'aktif' => User::where('role', '!=', 'admin')->where('is_active', 1)->count(),
            'nonaktif' => User::where('role', '!=', 'admin')->where('is_active', 0)->count(),
            'baru_bulan_ini' => User::where('role', '!=', 'admin')
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
        ];

        return view('admin.pengguna', compact('users', 'stats'));
    }

    public function show(User $user)
    {
        abort_if($user->role === 'admin', 404);

        $user->loadCount([
            'orders',
            'orders as selesai_count' => fn($q) => $q->where('status', 'delivered'),
        ])->load('sellerProfile');

        // 🔥 kalau request dari fetch (AJAX)
        if (request()->ajax()) {
            return response()->json([
                'nama_lengkap' => $user->nama_lengkap,
                'email' => $user->email,
                'role' => $user->role,
                'is_active' => $user->is_active,
                'no_whatsapp' => $user->no_whatsapp,
                'google_id' => $user->google_id,
                'orders_count' => $user->orders_count,
                'selesai_count' => $user->selesai_count,
                'created_at' => $user->created_at->format('d M Y'),
                'last_login_at' => $user->last_login_at
                    ? $user->last_login_at->diffForHumans()
                    : 'Belum login',
                'seller_profile' => $user->sellerProfile ? [
                    'nama_toko' => $user->sellerProfile->nama_toko,
                    'total_transaksi' => $user->sellerProfile->total_transaksi,
                    'rating' => $user->sellerProfile->rating,
                ] : null
            ]);
        }

        // fallback kalau buka manual di browser
        return view('admin.pengguna-detail', compact('user'));
    }
    public function toggleStatus(User $user)
    {
        abort_if($user->role === 'admin', 403);
        $user->update(['is_active' => !$user->is_active]);
        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Akun {$user->nama_lengkap} berhasil {$status}.");
    }

    public function destroy(User $user)
    {
        abort_if($user->role === 'admin', 403);

        $hasActiveOrder = $user->orders()
            ->whereNotIn('status', ['delivered', 'cancelled', 'refunded'])
            ->exists();

        if ($hasActiveOrder) {
            return back()->with('error', 'Pengguna tidak dapat dihapus karena masih memiliki transaksi aktif.');
        }

        $name = $user->nama_lengkap;
        $user->delete();
        return back()->with('success', "Akun {$name} berhasil dihapus.");
    }
}