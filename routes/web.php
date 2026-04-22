<?php

use Illuminate\Support\Facades\Route;

// ── Splash Screen ──
Route::get('/', function () {
    return view('splash.index');
});
// ── Main App ──
Route::get('/home', function () {
    return view('home'); // ganti dengan controller kamu
})->name('home');
