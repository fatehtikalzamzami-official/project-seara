<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    // ─────────────────────────────────────────────
    //  LANDING PAGE
    // ─────────────────────────────────────────────

    public function index()
    {
        // Kalau sudah login, langsung redirect ke dashboard sesuai role
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user()->role);
        }

        return view('splash.index'); // resources/views/welcome.blade.php (landing page SEARA)
    }

    // ─────────────────────────────────────────────
    //  REGISTER
    // ─────────────────────────────────────────────

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string', 'max:1000'],
            'no_whatsapp' => ['required', 'string', 'max:20'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ], [
            'email.unique' => 'Email ini sudah terdaftar. Silakan masuk atau gunakan email lain.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        // Buat username dari email (bagian sebelum @)
        $username = explode('@', $request->email)[0];

        $user = User::create([
            'name' => $username,
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'no_whatsapp' => $request->no_whatsapp,
            'alamat' => $request->alamat,
            'role' => 'buyer', // default role saat daftar
            'is_active' => true,
        ]);

        // Auto login setelah daftar
        Auth::login($user, true);

        return response()->json([
            'success' => true,
            'message' => 'Akun berhasil dibuat! Selamat datang di SEARA, ' . $user->nama_lengkap . '.',
            'redirect' => route('buyer.dashboard'),
        ]);
    }

    // ─────────────────────────────────────────────
    //  LOGIN
    // ─────────────────────────────────────────────

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        // Cek user aktif
        $user = User::where('email', $request->email)->first();

        if ($user && !$user->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Akun Anda telah dinonaktifkan. Hubungi admin untuk bantuan.',
            ], 403);
        }

        if (!Auth::attempt($credentials, $remember)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau kata sandi salah. Silakan coba lagi.',
            ], 401);
        }

        $request->session()->regenerate();

        // Update last_login_at
        Auth::user()->update(['last_login_at' => now()]);

        return response()->json([
            'success' => true,
            'message' => 'Selamat datang kembali, ' . Auth::user()->nama_lengkap . '!',
            'redirect' => $this->redirectByRole(Auth::user()->role, returnUrl: true),
        ]);
    }

    // ─────────────────────────────────────────────
    //  LOGOUT
    // ─────────────────────────────────────────────

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Anda berhasil keluar. Sampai jumpa!');
    }

    // ─────────────────────────────────────────────
    //  HELPER: redirect berdasarkan role
    // ─────────────────────────────────────────────

    private function redirectByRole(string $role, bool $returnUrl = false)
    {
        $routes = [
            'admin' => 'admin.dashboard',
            'seller' => 'seller.dashboard',
            'buyer' => 'buyer.dashboard',
        ];

        // fallback kalau role aneh / null
        $routeName = $routes[$role] ?? 'buyer.dashboard';

        // Cek apakah route ada
        if (!\Route::has($routeName)) {
            $routeName = 'home'; // fallback aman
        }

        $url = route($routeName);

        return $returnUrl ? $url : redirect($url);
    }
}