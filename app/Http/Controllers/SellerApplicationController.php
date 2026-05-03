<?php

namespace App\Http\Controllers;

use App\Models\SellerApplication;
use App\Models\SellerProfile;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SellerApplicationController extends Controller
{
    // ── Buyer: Formulir pendaftaran seller ────────────────────────────────
    public function create()
    {
        $user = Auth::user();

        // Cek apakah sudah punya pengajuan aktif
        $existing = SellerApplication::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'reviewing'])
            ->first();

        if ($existing) {
            return redirect()->route('buyer.application.status')
                ->with('info', 'Kamu sudah memiliki pengajuan yang sedang diproses.');
        }

        // Cek apakah sudah jadi seller
        if ($user->role === 'seller') {
            return redirect()->route('seller.dashboard')
                ->with('info', 'Kamu sudah terdaftar sebagai seller.');
        }

        return view('pembeli.daftar-seller');
    }

    // ── Buyer: Simpan pengajuan ───────────────────────────────────────────
    public function store(Request $request)
    {
        $user = Auth::user();

        // Cek duplikat pengajuan
        $existing = SellerApplication::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'reviewing'])
            ->first();

        if ($existing) {
            return redirect()->route('buyer.application.status')
                ->with('error', 'Kamu sudah memiliki pengajuan yang sedang diproses.');
        }

        $request->validate([
            'nama_toko'            => 'required|string|max:100',
            'deskripsi_toko'       => 'required|string|max:1000',
            'kategori_utama'       => 'required|string|max:100',
            'provinsi'             => 'required|string|max:100',
            'kota_kabupaten'       => 'required|string|max:100',
            'alamat_toko'          => 'required|string|max:500',
            'no_ktp'               => 'required|string|size:16',
            'foto_ktp'             => 'required|image|max:4096',
            'foto_selfie_ktp'      => 'required|image|max:4096',
            'no_rekening'          => 'required|string|max:30',
            'nama_bank'            => 'required|string|max:50',
            'atas_nama_rekening'   => 'required|string|max:100',
        ]);

        // Generate slug unik
        $baseSlug = Str::slug($request->nama_toko);
        $slug     = $baseSlug;
        $counter  = 1;
        while (SellerApplication::where('slug_toko', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter++;
        }

        $fotoKtp    = $request->file('foto_ktp')->store('ktp', 'public');
        $fotoSelfie = $request->file('foto_selfie_ktp')->store('ktp-selfie', 'public');

        SellerApplication::create([
            'user_id'              => $user->id,
            'nama_toko'            => $request->nama_toko,
            'slug_toko'            => $slug,
            'deskripsi_toko'       => $request->deskripsi_toko,
            'kategori_utama'       => $request->kategori_utama,
            'provinsi'             => $request->provinsi,
            'kota_kabupaten'       => $request->kota_kabupaten,
            'alamat_toko'          => $request->alamat_toko,
            'no_ktp'               => $request->no_ktp,
            'foto_ktp'             => $fotoKtp,
            'foto_selfie_ktp'      => $fotoSelfie,
            'no_rekening'          => $request->no_rekening,
            'nama_bank'            => $request->nama_bank,
            'atas_nama_rekening'   => $request->atas_nama_rekening,
            'status'               => 'pending',
            'submitted_at'         => now(),
        ]);

        return redirect()->route('buyer.application.status')
            ->with('success', 'Pengajuan berhasil dikirim! Kami akan meninjau dalam 1–3 hari kerja.');
    }

    // ── Buyer: Status pengajuan ───────────────────────────────────────────
    public function status()
    {
        $application = SellerApplication::where('user_id', Auth::id())
            ->latest()
            ->first();

        return view('pembeli.status-pengajuan', compact('application'));
    }

    // ─────────────────────────────────────────────────────────────────────
    // ADMIN METHODS
    // ─────────────────────────────────────────────────────────────────────

    // ── Admin: Daftar semua pengajuan ─────────────────────────────────────
    public function index(Request $request)
    {
        $status = $request->query('status', 'pending');

        $applications = SellerApplication::with('user')
            ->when($status !== 'all', fn($q) => $q->where('status', $status))
            ->latest('submitted_at')
            ->paginate(20);

        $countByStatus = SellerApplication::selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        return view('admin.applications.index', compact('applications', 'status', 'countByStatus'));
    }

    // ── Admin: Detail pengajuan ───────────────────────────────────────────
    public function show(SellerApplication $sellerApplication)
    {
        $sellerApplication->load('user', 'reviewer');
        return view('admin.applications.show', compact('sellerApplication'));
    }

    // ── Admin: Tandai sedang direview ─────────────────────────────────────
    public function setReviewing(SellerApplication $sellerApplication)
    {
        abort_unless($sellerApplication->status === 'pending', 422, 'Status tidak valid.');

        $sellerApplication->update([
            'status'      => 'reviewing',
            'reviewed_by' => Auth::id(),
        ]);

        return back()->with('success', 'Pengajuan ditandai sedang direview.');
    }

    // ── Admin: Setujui pengajuan → buat SellerProfile & ubah role user ───
    public function approve(SellerApplication $sellerApplication)
    {
        abort_unless(
            in_array($sellerApplication->status, ['pending', 'reviewing']),
            422,
            'Pengajuan tidak dapat disetujui.'
        );

        $user = $sellerApplication->user;

        // Generate slug unik untuk profil toko
        $baseSlug = $sellerApplication->slug_toko;
        $slug     = $baseSlug;
        $counter  = 1;
        while (SellerProfile::where('slug_toko', $slug)->withTrashed()->exists()) {
            $slug = $baseSlug . '-' . $counter++;
        }

        // Buat SellerProfile
        SellerProfile::create([
            'user_id'            => $user->id,
            'application_id'     => $sellerApplication->id,
            'nama_toko'          => $sellerApplication->nama_toko,
            'slug_toko'          => $slug,
            'deskripsi_toko'     => $sellerApplication->deskripsi_toko,
            'kategori_utama'     => $sellerApplication->kategori_utama,
            'provinsi'           => $sellerApplication->provinsi,
            'kota_kabupaten'     => $sellerApplication->kota_kabupaten,
            'alamat_toko'        => $sellerApplication->alamat_toko,
            'no_rekening'        => $sellerApplication->no_rekening,
            'nama_bank'          => $sellerApplication->nama_bank,
            'atas_nama_rekening' => $sellerApplication->atas_nama_rekening,
            'is_open'            => true,
            'is_verified'        => true,
            'verified_at'        => now(),
        ]);

        // Buat Seller record (legacy / untuk relasi harvest)
        Seller::firstOrCreate(
            ['user_id' => $user->id],
            ['shop_name' => $sellerApplication->nama_toko]
        );

        // Update status aplikasi & role user
        $sellerApplication->update([
            'status'      => 'approved',
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
        ]);

        $user->update(['role' => 'seller']);

        return back()->with('success', "Pengajuan {$sellerApplication->nama_toko} disetujui. Akun seller aktif.");
    }

    // ── Admin: Tolak pengajuan ────────────────────────────────────────────
    public function reject(Request $request, SellerApplication $sellerApplication)
    {
        abort_unless(
            in_array($sellerApplication->status, ['pending', 'reviewing']),
            422,
            'Pengajuan tidak dapat ditolak.'
        );

        $request->validate([
            'catatan_penolakan' => 'required|string|max:500',
        ]);

        $sellerApplication->update([
            'status'             => 'rejected',
            'catatan_penolakan'  => $request->catatan_penolakan,
            'reviewed_by'        => Auth::id(),
            'reviewed_at'        => now(),
        ]);

        return back()->with('success', 'Pengajuan ditolak dan catatan dikirim ke pemohon.');
    }
}
