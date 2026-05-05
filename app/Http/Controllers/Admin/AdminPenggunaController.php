<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminPenggunaController extends Controller
{
    // ── INDEX ──────────────────────────────────────────────
    public function index(Request $request)
    {
        $query = User::query()
            ->whereIn('role', ['buyer', 'seller'])
            ->withCount([
                'orders as orders_count',
                'orders as selesai_count' => fn($q) =>
                    $q->where('status', 'selesai')
            ])
            ->with('sellerProfile');

        // Filter role (via tab)
        if ($request->role) {
            $query->where('role', $request->role);
        }

        // Filter status
        if ($request->status === 'aktif') {
            $query->where('is_active', true);
        } elseif ($request->status === 'nonaktif') {
            $query->where('is_active', false);
        }

        // Filter login method
        if ($request->login_method === 'google') {
            $query->whereNotNull('google_id');
        } elseif ($request->login_method === 'email') {
            $query->whereNull('google_id');
        }

        // Search
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_lengkap', 'like', "%{$request->search}%")
                    ->orWhere('email', 'like', "%{$request->search}%")
                    ->orWhere('no_whatsapp', 'like', "%{$request->search}%");
            });
        }

        // Sort
        match ($request->sort) {
            'terlama' => $query->oldest(),
            'nama_az' => $query->orderBy('nama_lengkap'),
            'nama_za' => $query->orderByDesc('nama_lengkap'),
            default => $query->latest(),
        };

        $users = $query->paginate(15)->withQueryString();

        $stats = [
            'total' => User::whereIn('role', ['buyer', 'seller'])->count(),
            'buyer' => User::where('role', 'buyer')->count(),
            'seller' => User::where('role', 'seller')->count(),
            'aktif' => User::where('is_active', true)->count(),
            'nonaktif' => User::where('is_active', false)->count(),
            'baru_bulan_ini' => User::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)->count(),
        ];

        return view('admin.pengguna', compact('users', 'stats'));
    }

    // ── SHOW (JSON untuk modal detail) ─────────────────────
    public function show(User $user)
    {
        // Kalau request biasa (bukan AJAX) → redirect ke index
        if (!request()->expectsJson() && !request()->ajax()) {
            return redirect()->route('admin.pengguna');
        }

        $user->load('sellerProfile');
        $user->loadCount([
            'orders as orders_count',
            'orders as selesai_count' => fn($q) => $q->where('status', 'selesai'),
        ]);

        return response()->json([
            'id' => $user->id,
            'nama_lengkap' => $user->nama_lengkap,
            'email' => $user->email,
            'no_whatsapp' => $user->no_whatsapp ?? '—',
            'role' => $user->role,
            'is_active' => $user->is_active,
            'google_id' => $user->google_id,
            'avatar' => $user->avatar,
            'created_at' => $user->created_at->format('d M Y, H:i'),
            'last_login_at' => $user->last_login_at?->diffForHumans() ?? 'Belum pernah login',
            'orders_count' => $user->orders_count ?? 0,
            'selesai_count' => $user->selesai_count ?? 0,
            'seller_profile' => $user->sellerProfile ? [
                'nama_toko' => $user->sellerProfile->nama_toko,
                'total_transaksi' => $user->sellerProfile->total_transaksi,
                'rating' => $user->sellerProfile->rating,
            ] : null,
        ]);
    }

    // ── TOGGLE AKTIF/NONAKTIF ──────────────────────────────
    public function toggle(User $user)
    {
        $user->update(['is_active' => !$user->is_active]);

        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('success', "Akun {$user->nama_lengkap} berhasil {$status}.");
    }

    // ── DESTROY ────────────────────────────────────────────
    public function destroy(User $user)
    {
        $nama = $user->nama_lengkap;
        $user->delete();

        return back()->with('success', "Akun {$nama} berhasil dihapus.");
    }
}