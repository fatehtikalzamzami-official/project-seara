<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SellerApplicationController;
use App\Http\Controllers\SellerProductController;
use App\Http\Controllers\SellerProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\BuyerDashboardController;
use App\Http\Controllers\PriceOfferController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\BuyerProfileController;
use App\Http\Controllers\DashboardControllerAdmin;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminPenggunaController;
use App\Http\Controllers\Seller\SellerChatController;
use App\Http\Controllers\Seller\SellerLaporanController;
use App\Http\Controllers\Seller\SellerPengaturanController;
use App\Http\Controllers\Seller\SellerKeuanganController;
use App\Http\Controllers\Seller\SellerOrderController;
use App\Http\Controllers\Seller\SellerJadwalPanenController;
use App\Http\Controllers\Admin\LaporanController;
use App\Models\HarvestSchedule;


// ─────────────────────────────────────────────────────────────
//  PUBLIC ROUTES
// ─────────────────────────────────────────────────────────────

Route::get('/', [AuthController::class, 'index'])->name('home');

// ─────────────────────────────────────────────────────────────
//  SEARCH ROUTES
// ─────────────────────────────────────────────────────────────
Route::get('/cari', [SearchController::class, 'index'])->name('search.index');
Route::get('/cari/suggest', [SearchController::class, 'suggest'])->name('search.suggest');

Route::get('/explore', [SellerProfileController::class, 'explore'])->name('explore');
Route::get('/toko/{slug}', [SellerProfileController::class, 'show'])->name('store.show');
Route::get('/petani/{param}', [SellerProfileController::class, 'show'])->name('seller.profile');

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

Route::get('/login', [AuthController::class, 'index'])->name('login');

// ─────────────────────────────────────────────────────────────
//  CHAT
// ─────────────────────────────────────────────────────────────

Route::middleware(['auth'])->prefix('chat')->name('chat.')->group(function () {
    Route::get('/', [ChatController::class, 'index'])->name('index');
    Route::post('/open', [ChatController::class, 'openOrCreate'])->name('open');
    Route::get('/{chatRoom}', [ChatController::class, 'show'])->name('show');
    Route::post('/{chatRoom}/send', [ChatController::class, 'send'])->name('send');
    Route::get('/{chatRoom}/poll', [ChatController::class, 'poll'])->name('poll');
    Route::get('/unread/count', [ChatController::class, 'unreadCount'])->name('unread');
    Route::get('/online-status', [ChatController::class, 'onlineStatus'])->name('online-status');
});

// ─────────────────────────────────────────────────────────────
//  KERANJANG
// ─────────────────────────────────────────────────────────────

Route::middleware(['auth'])->prefix('keranjang')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/', [CartController::class, 'store'])->name('store');
    Route::patch('/{cartItem}', [CartController::class, 'update'])->name('update');
    Route::delete('/{cartItem}', [CartController::class, 'destroy'])->name('destroy');
    Route::delete('/', [CartController::class, 'clear'])->name('clear');
    Route::get('/count', [CartController::class, 'count'])->name('count');
});

Route::middleware(['auth'])->prefix('wishlist')->name('wishlist.')->group(function () {
    Route::get('/', [WishlistController::class, 'index'])->name('index');
    Route::post('/toggle', [WishlistController::class, 'toggle'])->name('toggle');
    Route::delete('/{wishlist}', [WishlistController::class, 'destroy'])->name('destroy');
    Route::get('/count', [WishlistController::class, 'count'])->name('count');
});

// ─────────────────────────────────────────────────────────────
//  ORDERS / CHECKOUT
// ─────────────────────────────────────────────────────────────

Route::middleware(['auth'])->prefix('orders')->name('orders.')->group(function () {
    Route::get('/', [OrderController::class, 'index'])->name('index');
    Route::get('/checkout/cart', [OrderController::class, 'checkoutFromCart'])->name('checkout.cart');
    Route::get('/checkout/offer/{priceOffer}', [OrderController::class, 'checkoutFromOffer'])->name('checkout.offer');
    Route::post('/', [OrderController::class, 'store'])->name('store');
    Route::get('/{order}', [OrderController::class, 'show'])->name('show');
    Route::post('/{order}/payment-proof', [OrderController::class, 'uploadPaymentProof'])->name('payment-proof');
    Route::post('/{order}/cancel', [OrderController::class, 'cancel'])->name('cancel');
});

// ─────────────────────────────────────────────────────────────
//  PRICE OFFERS
// ─────────────────────────────────────────────────────────────

Route::middleware(['auth'])->prefix('offers')->name('offers.')->group(function () {
    Route::post('/', [PriceOfferController::class, 'store'])->name('store');
    Route::post('/{priceOffer}/accept', [PriceOfferController::class, 'accept'])->name('accept');
    Route::post('/{priceOffer}/reject', [PriceOfferController::class, 'reject'])->name('reject');
    Route::post('/{priceOffer}/counter', [PriceOfferController::class, 'counter'])->name('counter');
    Route::post('/{priceOffer}/cancel', [PriceOfferController::class, 'cancel'])->name('cancel');
    Route::get('/status', [PriceOfferController::class, 'status'])->name('status');
});

// ─────────────────────────────────────────────────────────────
//  BUYER ROUTES
// ─────────────────────────────────────────────────────────────

Route::middleware(['auth', 'role:buyer,seller,admin'])->prefix('buyer')->name('buyer.')->group(function () {
    Route::get('/dashboard', [BuyerDashboardController::class, 'index'])->name('dashboard');
    Route::get('/panen-hari-ini', [BuyerDashboardController::class, 'panenHariIni'])->name('panen.today');
    Route::get('/produk/{id}', [ProductController::class, 'show'])->name('product.show');

    // Profil buyer
    Route::get('/profile', [BuyerProfileController::class, 'show'])->name('profile');
    Route::put('/profile', [BuyerProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [BuyerProfileController::class, 'updatePassword'])->name('profile.password');

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

    // Produk Seller
    Route::get('/produk', [SellerProductController::class, 'index'])->name('products.index');
    Route::post('/produk', [SellerProductController::class, 'store'])->name('products.store');
    Route::put('/produk/{harvest}', [SellerProductController::class, 'update'])->name('products.update');
    Route::delete('/produk/{harvest}', [SellerProductController::class, 'destroy'])->name('products.destroy');

    Route::get('/profil/lihat', [SellerProfileController::class, 'view'])->name('profile.view');
    Route::get('/profil', [SellerProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profil', [SellerProfileController::class, 'update'])->name('profile.update');
    Route::post('/profil/toggle', [SellerProfileController::class, 'toggleOpen'])->name('profile.toggle');

    // Chat Seller
    Route::prefix('chat')->name('chat.')->group(function () {
        Route::get('/', [SellerChatController::class, 'index'])->name('index');
        Route::get('/{chatRoom}', [SellerChatController::class, 'show'])->name('show');
        Route::post('/{chatRoom}/send', [SellerChatController::class, 'send'])->name('send');
        Route::get('/{chatRoom}/poll', [SellerChatController::class, 'poll'])->name('poll');
    });

    // Laporan Seller
    Route::get('/laporan', [SellerLaporanController::class, 'index'])
        ->name('laporan.index');

    Route::get('/laporan/export', [SellerLaporanController::class, 'export'])
        ->name('laporan.export');

    Route::get('/pengaturan', [SellerPengaturanController::class, 'index'])
        ->name('settings.index');

    Route::put('/pengaturan/profil', [SellerPengaturanController::class, 'updateProfile'])
        ->name('settings.update.profile');

    Route::put('/pengaturan/password', [SellerPengaturanController::class, 'updatePassword'])
        ->name('settings.update.password');

    Route::put('/pengaturan/notifikasi', [SellerPengaturanController::class, 'updateNotifikasi'])
        ->name('settings.update.notifikasi');

    Route::put('/pengaturan/toko', [SellerPengaturanController::class, 'updateToko'])
        ->name('settings.update.toko');

    Route::put('/pengaturan/rekening', [SellerPengaturanController::class, 'updateRekening'])
        ->name('settings.update.rekening');

    Route::delete('/pengaturan/akun', [SellerPengaturanController::class, 'deleteAccount'])
        ->name('settings.delete.account');

    // Keuangan Seller
    Route::prefix('keuangan')->name('keuangan.')->group(function () {

        Route::get('/', [SellerKeuanganController::class, 'index'])
            ->name('index');

        Route::get('/export', [SellerKeuanganController::class, 'export'])
            ->name('export');

        Route::post('/withdraw', [SellerKeuanganController::class, 'withdraw'])
            ->name('withdraw');

        Route::get('/riwayat', [SellerKeuanganController::class, 'riwayat'])
            ->name('riwayat');

        Route::get('/invoice/{order}', [SellerKeuanganController::class, 'invoice'])
            ->name('invoice');
    });

    // Pesanan Seller
    Route::get('/pesanan', [SellerOrderController::class, 'index'])
        ->name('orders.index');

    Route::patch('/pesanan/{order}/status', [SellerOrderController::class, 'updateStatus'])
        ->name('orders.updateStatus');

    Route::get('/pesanan/{order}/print', [SellerOrderController::class, 'print'])
        ->name('orders.print');

    //Jadwal Panen Seller
    Route::resource('jadwal', SellerJadwalPanenController::class)
        ->only(['index', 'store', 'update', 'destroy'])
        ->names('jadwal');

    Route::patch('jadwal/{jadwal}/status', [SellerJadwalPanenController::class, 'updateStatus'])
        ->name('jadwal.status');
});

// ─────────────────────────────────────────────────────────────
//  ADMIN ROUTES (sudah pakai middleware role:admin)
// ─────────────────────────────────────────────────────────────

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardControllerAdmin::class, 'indexAdmin'])->name('dashboard');

    // Manajemen Pengguna (sudah ada)
    Route::get('/pengguna', [AdminUserController::class, 'index'])->name('pengguna');
    Route::get('/pengguna/{user}', [AdminUserController::class, 'show'])->name('pengguna.show');
    Route::get('/pengguna/{user}/detail', [AdminUserController::class, 'show'])->name('pengguna.detail');
    Route::patch('/pengguna/{user}/toggle', [AdminUserController::class, 'toggleStatus'])->name('pengguna.toggle');
    Route::delete('/pengguna/{user}', [AdminUserController::class, 'destroy'])->name('pengguna.destroy');

    // Data Pembeli (opsional, bisa diarahkan ke AdminUserController dengan filter)
    Route::get('/users', function () {
        return view('admin.users');
    })->name('users');

    // Data Seller (opsional)
    Route::get('/sellers', function () {
        return view('admin.sellers');
    })->name('sellers');

    // ───────── PENGATURAN ULANG VERIFIKASI SELLER ─────────
    // Hanya satu grup, tanpa duplikasi, menggunakan method dari SellerApplicationController
    Route::prefix('verifikasi')->name('verifikasi.')->group(function () {
        Route::get('/', [SellerApplicationController::class, 'index'])->name('index');          // admin.verifikasi.index
        Route::get('/{sellerApplication}/detail', [SellerApplicationController::class, 'detailJson'])->name('detail'); // AJAX
        Route::post('/{sellerApplication}/set-reviewing', [SellerApplicationController::class, 'setReviewing'])->name('set-reviewing');
        Route::post('/{sellerApplication}/approve', [SellerApplicationController::class, 'approve'])->name('approve');
        Route::post('/{sellerApplication}/reject', [SellerApplicationController::class, 'reject'])->name('reject');
    });

    // Laporan Aktif
    Route::get('/laporan',                         [LaporanController::class, 'index'])         ->name('laporan');
Route::get('/laporan/{report}',                [LaporanController::class, 'show'])          ->name('laporan.show');
Route::patch('/laporan/{report}/start-review', [LaporanController::class, 'startReview'])  ->name('laporan.startReview');
Route::post('/laporan/{report}/resolve',       [LaporanController::class, 'resolve'])       ->name('laporan.resolve');
Route::patch('/laporan/{report}/priority',     [LaporanController::class, 'updatePriority'])->name('laporan.priority');

    // Suspend / reinstate toko seller
    Route::post('/toko/{sellerProfile}/suspend', [SellerProfileController::class, 'suspend'])->name('stores.suspend');
    Route::post('/toko/{sellerProfile}/reinstate', [SellerProfileController::class, 'reinstate'])->name('stores.reinstate');

});