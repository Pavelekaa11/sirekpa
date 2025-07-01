<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\PantaiController;
use App\Http\Controllers\RekomendasiController;

// Arahkan '/' ke halaman beranda
Route::get('/', [BerandaController::class, 'index'])->name('beranda');

Route::get('/pantai/{id}', [PantaiController::class, 'show'])->name('show');

// Pencarian berdasarkan nama pantai
Route::get('/cari', [BerandaController::class, 'cari'])->name('beranda.cari');

// Form preferensi & hasil rekomendasi
Route::get('/rekomendasi', [RekomendasiController::class, 'form'])->name('form');
Route::post('/rekomendasi/hasil', [RekomendasiController::class, 'hasil'])->name('hasil');
