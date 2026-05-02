<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SellerApplicationController;
use App\Http\Controllers\SellerProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;


use App\Http\Controllers\BuyerDashboardController;

Route::middleware(['auth', 'role:buyer,seller,admin'])
    ->prefix('buyer')
    ->name('buyer.')
    ->group(function () {
        Route::get('/dashboard', [BuyerDashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/produk/{id}', [ProductController::class, 'show'])
            ->name('product.show');
    });

Route::get('/logout', function () {
    \Illuminate\Support\Facades\Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
});
// ─────────────────────────────────────────────────────────────
//  PUBLIC ROUTES
// ─────────────────────────────────────────────────────────────

Route::get('/', [AuthController::class, 'index'])->name('home');



// Eksplorasi toko publik
Route::get('/explore', [SellerProfileController::class, 'explore'])->name('explore');
Route::get('/toko/{slug}', [SellerProfileController::class, 'show'])->name('store.show');

// ─────────────────────────────────────────────────────────────
//  AUTH ROUTES (hanya untuk guest)
// ─────────────────────────────────────────────────────────────

Route::middleware('guest')->group(function () {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// ─────────────────────────────────────────────────────────────
//  BUYER ROUTES
// ─────────────────────────────────────────────────────────────

Route::middleware(['auth', 'role:buyer,seller,admin'])->prefix('buyer')->name('buyer.')->group(function () {
Route::middleware(['auth', 'role:buyer,seller,admin'])
    ->prefix('buyer')
    ->name('buyer.')
    ->group(function () {
        Route::get('/dashboard', [BuyerDashboardController::class, 'index'])
            ->name('dashboard');
    });

    // Pengajuan jadi seller
    Route::get('/daftar-seller', [SellerApplicationController::class, 'create'])->name('apply.create');
    Route::post('/daftar-seller', [SellerApplicationController::class, 'store'])->name('apply.store');
    Route::get('/status-pengajuan', [SellerApplicationController::class, 'status'])->name('application.status');
});

// ─────────────────────────────────────────────────────────────
//  SELLER ROUTES
// ─────────────────────────────────────────────────────────────

Route::middleware(['auth', 'role:seller'])->prefix('seller')->name('seller.')->group(function () {
    Route::get('/dashboard', [SellerProfileController::class, 'dashboard'])->name('dashboard');

    // Manajemen profil toko
    Route::get('/profil', [SellerProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profil', [SellerProfileController::class, 'update'])->name('profile.update');
    Route::post('/profil/toggle', [SellerProfileController::class, 'toggleOpen'])->name('profile.toggle');
});

// ─────────────────────────────────────────────────────────────
//  ADMIN ROUTES
// ─────────────────────────────────────────────────────────────

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', fn() => view('admin.dashboard'))->name('dashboard');

    // Manajemen pengajuan seller
    Route::get('/seller-applications', [SellerApplicationController::class, 'index'])->name('applications.index');
    Route::get('/seller-applications/{sellerApplication}', [SellerApplicationController::class, 'show'])->name('applications.show');
    Route::post('/seller-applications/{sellerApplication}/reviewing', [SellerApplicationController::class, 'setReviewing'])->name('applications.reviewing');
    Route::post('/seller-applications/{sellerApplication}/approve', [SellerApplicationController::class, 'approve'])->name('applications.approve');
    Route::post('/seller-applications/{sellerApplication}/reject', [SellerApplicationController::class, 'reject'])->name('applications.reject');

    // Manajemen toko
    Route::post('/toko/{sellerProfile}/suspend', [SellerProfileController::class, 'suspend'])->name('stores.suspend');
    Route::post('/toko/{sellerProfile}/reinstate', [SellerProfileController::class, 'reinstate'])->name('stores.reinstate');
});