<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class SellerPengaturanController extends Controller
{
    /**
     * Tampilkan halaman pengaturan.
     */
    public function index()
    {
        return view('seller.pengaturan');
    }

    /**
     * Update informasi pribadi (nama, telepon, alamat).
     */
    public function updateProfile(Request $request)
    {
        $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'no_telepon' => ['nullable', 'string', 'max:20'],
            'alamat' => ['nullable', 'string', 'max:500'],
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'nama_lengkap.max' => 'Nama lengkap maksimal 255 karakter.',
            'no_telepon.max' => 'Nomor telepon maksimal 20 karakter.',
        ]);

        Auth::user()->update([
            'nama_lengkap' => $request->nama_lengkap,
            'no_telepon' => $request->no_telepon,
            'alamat' => $request->alamat,
        ]);

        return redirect()
            ->route('seller.settings.index', ['#akun'])
            ->with('success', 'Informasi pribadi berhasil diperbarui.');
    }

    /**
     * Update password akun.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()],
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'password.required' => 'Password baru wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal 8 karakter.',
        ]);

        // Verifikasi password lama
        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()
                ->withErrors(['current_password' => 'Password saat ini salah.'])
                ->with('open_panel', 'keamanan');
        }

        // Pastikan password baru tidak sama dengan yang lama
        if (Hash::check($request->password, Auth::user()->password)) {
            return back()
                ->withErrors(['password' => 'Password baru tidak boleh sama dengan password lama.'])
                ->with('open_panel', 'keamanan');
        }

        Auth::user()->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()
            ->route('seller.settings.index', ['#keamanan'])
            ->with('success', 'Password berhasil diperbarui. Silakan login ulang jika diperlukan.');
    }

    /**
     * Update preferensi notifikasi.
     */
    public function updateNotifikasi(Request $request)
    {
        $keys = [
            'notif_order_masuk',
            'notif_pembayaran',
            'notif_pesan_chat',
            'notif_tawaran_harga',
            'notif_laporan_mingguan',
            'push_order',
            'push_chat',
            'push_promo',
        ];

        // Checkbox yang tidak dicentang tidak dikirim, default false
        $notifikasi = [];
        foreach ($keys as $key) {
            $notifikasi[$key] = $request->boolean($key);
        }

        Auth::user()->update([
            'notifikasi' => $notifikasi,
        ]);

        return redirect()
            ->route('seller.settings.index', ['#notifikasi'])
            ->with('success', 'Preferensi notifikasi berhasil disimpan.');
    }

    /**
     * Update informasi toko.
     */
    public function updateToko(Request $request)
    {
        $request->validate([
            'nama_toko' => ['required', 'string', 'max:255'],
            'deskripsi_toko' => ['nullable', 'string', 'max:1000'],
            'provinsi' => ['nullable', 'string', 'max:100'],
            'kota_kabupaten' => ['nullable', 'string', 'max:100'],
            'kategori_utama' => ['nullable', 'string', 'max:100'],
        ], [
            'nama_toko.required' => 'Nama toko wajib diisi.',
            'nama_toko.max' => 'Nama toko maksimal 255 karakter.',
            'deskripsi_toko.max' => 'Deskripsi toko maksimal 1000 karakter.',
        ]);

        $sellerProfile = Auth::user()->sellerProfile;

        if (!$sellerProfile) {
            return back()
                ->withErrors(['nama_toko' => 'Profil toko tidak ditemukan.'])
                ->with('open_panel', 'toko');
        }

        $sellerProfile->update([
            'nama_toko' => $request->nama_toko,
            'deskripsi_toko' => $request->deskripsi_toko,
            'provinsi' => $request->provinsi,
            'kota_kabupaten' => $request->kota_kabupaten,
            'kategori_utama' => $request->kategori_utama,
        ]);

        return redirect()
            ->route('seller.settings.index', ['#toko'])
            ->with('success', 'Informasi toko berhasil diperbarui.');
    }

    /**
     * Update informasi rekening bank.
     */
    public function updateRekening(Request $request)
    {
        $request->validate([
            'nama_bank' => ['nullable', 'string', 'max:100'],
            'no_rekening' => ['nullable', 'string', 'max:30'],
            'atas_nama_rekening' => ['nullable', 'string', 'max:255'],
        ], [
            'no_rekening.max' => 'Nomor rekening maksimal 30 karakter.',
            'atas_nama_rekening.max' => 'Nama rekening maksimal 255 karakter.',
        ]);

        $sellerProfile = Auth::user()->sellerProfile;

        if (!$sellerProfile) {
            return back()
                ->withErrors(['nama_bank' => 'Profil toko tidak ditemukan.'])
                ->with('open_panel', 'toko');
        }

        $sellerProfile->update([
            'nama_bank' => $request->nama_bank,
            'no_rekening' => $request->no_rekening,
            'atas_nama_rekening' => $request->atas_nama_rekening,
        ]);

        return redirect()
            ->route('seller.settings.index', ['#toko'])
            ->with('success', 'Informasi rekening berhasil diperbarui.');
    }

    /**
     * Hapus akun seller secara permanen.
     */
    public function deleteAccount(Request $request)
    {
        $request->validate([
            'konfirmasi' => ['required', 'in:HAPUS AKUN'],
        ], [
            'konfirmasi.required' => 'Konfirmasi penghapusan wajib diisi.',
            'konfirmasi.in' => 'Ketik HAPUS AKUN untuk konfirmasi.',
        ]);

        $user = Auth::user();

        // Logout sebelum hapus agar sesi tidak rusak
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Hapus user — relasi cascade di DB akan ikut menghapus
        // seller_profiles, harvests, products, dll.
        $user->delete();

        return redirect()
            ->route('login')
            ->with('success', 'Akun Anda telah dihapus. Terima kasih telah menggunakan SEARA.');
    }
}