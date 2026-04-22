<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| SEARA — Web Routes
|--------------------------------------------------------------------------
| Alur: / (Splash) → /home (E-Commerce) → /dashboard (Admin Dashboard)
*/

// ── Splash Screen ──────────────────────────────────────────────────────
Route::get('/', function () {
    return view('splash.index');
})->name('splash');

// ── E-Commerce / Toko ──────────────────────────────────────────────────
Route::get('/home', [HomeController::class, 'index'])->name('home');


