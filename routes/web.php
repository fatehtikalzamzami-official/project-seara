<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SellerApplicationController;
use App\Http\Controllers\SellerProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\BuyerDashboardController;
use App\Http\Controllers\PriceOfferController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;

// ─────────────────────────────────────────────────────────────
//  PUBLIC ROUTES
// ─────────────────────────────────────────────────────────────

Route::get('/', [AuthController::class, 'index'])->name('home');

Route::get('/explore', [SellerProfileController::class, 'explore'])->name('explore');
Route::get('/toko/{slug}', [SellerProfileController::class, 'show'])->name('store.show');
Route::get('/petani/{seller}', [SellerProfileController::class, 'show'])->name('seller.profile');

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

Route::get('/logout', function () {
    \Illuminate\Support\Facades\Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
});

// ─────────────────────────────────────────────────────────────
//  CHAT
// ─────────────────────────────────────────────────────────────

Route::middleware(['auth'])->prefix('chat')->name('chat.')->group(function () {
    Route::get('/',                 [ChatController::class, 'index'])->name('index');
    Route::post('/open',            [ChatController::class, 'openOrCreate'])->name('open');
    Route::get('/{chatRoom}',       [ChatController::class, 'show'])->name('show');
    Route::post('/{chatRoom}/send', [ChatController::class, 'send'])->name('send');
    Route::get('/{chatRoom}/poll',  [ChatController::class, 'poll'])->name('poll');
    Route::get('/unread/count',     [ChatController::class, 'unreadCount'])->name('unread');
    Route::get('/online-status',    [ChatController::class, 'onlineStatus'])->name('online-status');
});

// ─────────────────────────────────────────────────────────────
//  KERANJANG
// ─────────────────────────────────────────────────────────────

Route::middleware(['auth'])->prefix('keranjang')->name('cart.')->group(function () {
    Route::get('/',              [CartController::class, 'index'])->name('index');
    Route::post('/',             [CartController::class, 'store'])->name('store');
    Route::patch('/{cartItem}',  [CartController::class, 'update'])->name('update');
    Route::delete('/{cartItem}', [CartController::class, 'destroy'])->name('destroy');
    Route::delete('/',           [CartController::class, 'clear'])->name('clear');
    Route::get('/count',         [CartController::class, 'count'])->name('count');
});

Route::middleware(['auth'])->prefix('wishlist')->name('wishlist.')->group(function () {
    Route::get('/',              [WishlistController::class, 'index'])->name('index');
    Route::post('/toggle',       [WishlistController::class, 'toggle'])->name('toggle');
    Route::delete('/{wishlist}', [WishlistController::class, 'destroy'])->name('destroy');
    Route::get('/count',         [WishlistController::class, 'count'])->name('count');
});

// ─────────────────────────────────────────────────────────────
//  ORDERS / CHECKOUT
// ─────────────────────────────────────────────────────────────

Route::middleware(['auth'])->prefix('orders')->name('orders.')->group(function () {
    Route::get('/',                              [OrderController::class, 'index'])->name('index');
    Route::get('/checkout/cart',                 [OrderController::class, 'checkoutFromCart'])->name('checkout.cart');
    Route::get('/checkout/offer/{priceOffer}',   [OrderController::class, 'checkoutFromOffer'])->name('checkout.offer');
    Route::post('/',                             [OrderController::class, 'store'])->name('store');
    Route::get('/{order}',                       [OrderController::class, 'show'])->name('show');
    Route::post('/{order}/payment-proof',        [OrderController::class, 'uploadPaymentProof'])->name('payment-proof');
    Route::post('/{order}/cancel',               [OrderController::class, 'cancel'])->name('cancel');
});

// ─────────────────────────────────────────────────────────────
//  PRICE OFFERS
// ─────────────────────────────────────────────────────────────

Route::middleware(['auth'])->prefix('offers')->name('offers.')->group(function () {
    Route::post('/',                     [PriceOfferController::class, 'store'])->name('store');
    Route::post('/{priceOffer}/accept',  [PriceOfferController::class, 'accept'])->name('accept');
    Route::post('/{priceOffer}/reject',  [PriceOfferController::class, 'reject'])->name('reject');
    Route::post('/{priceOffer}/counter', [PriceOfferController::class, 'counter'])->name('counter');
    Route::post('/{priceOffer}/cancel',  [PriceOfferController::class, 'cancel'])->name('cancel');
    Route::get('/status',                [PriceOfferController::class, 'status'])->name('status');
});

// ─────────────────────────────────────────────────────────────
//  BUYER ROUTES
// ─────────────────────────────────────────────────────────────

Route::middleware(['auth', 'role:buyer,seller,admin'])->prefix('buyer')->name('buyer.')->group(function () {
    Route::get('/dashboard', [BuyerDashboardController::class, 'index'])->name('dashboard');
    Route::get('/produk/{id}', [ProductController::class, 'show'])->name('product.show');

    // Pengajuan jadi seller
    Route::get('/daftar-seller',    [SellerApplicationController::class, 'create'])->name('apply.create');
    Route::post('/daftar-seller',   [SellerApplicationController::class, 'store'])->name('apply.store');
    Route::get('/status-pengajuan', [SellerApplicationController::class, 'status'])->name('application.status');
});

// ─────────────────────────────────────────────────────────────
//  SELLER ROUTES
// ─────────────────────────────────────────────────────────────

Route::middleware(['auth', 'role:seller'])->prefix('seller')->name('seller.')->group(function () {
    Route::get('/dashboard', [SellerProfileController::class, 'dashboard'])->name('dashboard');

    Route::get('/profil',         [SellerProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profil',         [SellerProfileController::class, 'update'])->name('profile.update');
    Route::post('/profil/toggle', [SellerProfileController::class, 'toggleOpen'])->name('profile.toggle');
});

// ─────────────────────────────────────────────────────────────
//  ADMIN ROUTES
// ─────────────────────────────────────────────────────────────

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', fn() => view('admin.dashboard'))->name('dashboard');

    Route::get('/seller-applications',                                      [SellerApplicationController::class, 'index'])->name('applications.index');
    Route::get('/seller-applications/{sellerApplication}',                  [SellerApplicationController::class, 'show'])->name('applications.show');
    Route::post('/seller-applications/{sellerApplication}/reviewing',       [SellerApplicationController::class, 'setReviewing'])->name('applications.reviewing');
    Route::post('/seller-applications/{sellerApplication}/approve',         [SellerApplicationController::class, 'approve'])->name('applications.approve');
    Route::post('/seller-applications/{sellerApplication}/reject',          [SellerApplicationController::class, 'reject'])->name('applications.reject');

    Route::post('/toko/{sellerProfile}/suspend',   [SellerProfileController::class, 'suspend'])->name('stores.suspend');
    Route::post('/toko/{sellerProfile}/reinstate', [SellerProfileController::class, 'reinstate'])->name('stores.reinstate');
});