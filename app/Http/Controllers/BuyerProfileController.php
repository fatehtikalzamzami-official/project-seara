<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class BuyerProfileController extends Controller
{
    // ── Tampilkan halaman profil buyer
    public function show()
    {
        $user = Auth::user();
        $sellerApplication = $user->sellerApplication;

        return view('pembeli.profile', compact('user', 'sellerApplication'));
    }

    // ── Update data profil buyer
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'no_whatsapp'  => 'required|string|max:20',
            'alamat'       => 'required|string|max:1000',
            'avatar'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'no_whatsapp.required'  => 'Nomor WhatsApp wajib diisi.',
            'alamat.required'       => 'Alamat wajib diisi.',
            'avatar.image'          => 'File harus berupa gambar.',
            'avatar.max'            => 'Ukuran foto maksimal 2MB.',
        ]);

        $data = [
            'nama_lengkap' => $request->nama_lengkap,
            'no_whatsapp'  => $request->no_whatsapp,
            'alamat'       => $request->alamat,
        ];

        // Upload avatar jika ada
        if ($request->hasFile('avatar')) {
            // Hapus avatar lama jika bukan default
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($data);

        return redirect()->route('buyer.profile')->with('success', 'Profil berhasil diperbarui!');
    }

    // ── Ganti password
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => 'required|string',
            'password'         => 'required|string|min:8|confirmed',
        ], [
            'current_password.required' => 'Password lama wajib diisi.',
            'password.min'              => 'Password baru minimal 8 karakter.',
            'password.confirmed'        => 'Konfirmasi password tidak cocok.',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama tidak sesuai.']);
        }

        $user->update(['password' => Hash::make($request->password)]);

        return redirect()->route('buyer.profile')->with('success', 'Password berhasil diubah!');
    }
}
