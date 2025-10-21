<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PemeliharaanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// ======================
// ✅ Dashboard
// ======================
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {

    // ======================
    // ✅ Profile
    // ======================
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ======================
    // ✅ Master Data
    // ======================
    Route::resource('user', UserController::class);
    Route::resource('kategori', KategoriController::class);
    Route::resource('lokasi', LokasiController::class);

    // Barang
    Route::get('/barang/laporan', [BarangController::class, 'cetakLaporan'])->name('barang.laporan');
    Route::resource('barang', BarangController::class);

    // ======================
    // ✅ Peminjaman
    // ======================
    Route::get('/peminjaman/laporan', [PeminjamanController::class, 'cetakLaporan'])->name('peminjaman.laporan');
    Route::resource('peminjaman', PeminjamanController::class);
    Route::patch('/peminjaman/{peminjaman}/kembalikan', [PeminjamanController::class, 'updateStatus'])
        ->name('peminjaman.kembalikan');
    Route::get('/peminjaman/{peminjaman}', [PeminjamanController::class, 'show'])->name('peminjaman.show');

    // ======================
    // ✅ Pemeliharaan
    // ======================

    // Laporan HTML pemeliharaan
    Route::get('/pemeliharaan/laporan', [PemeliharaanController::class, 'cetakLaporan'])
        ->name('pemeliharaan.laporan');

    // Laporan PDF pemeliharaan
    Route::get('/pemeliharaan/laporan/pdf', [PemeliharaanController::class, 'laporanPdf'])
        ->name('pemeliharaan.laporan.pdf');

    // Resource CRUD pemeliharaan
    Route::resource('pemeliharaan', PemeliharaanController::class);

    // Tandai selesai pemeliharaan
    Route::patch('/pemeliharaan/{pemeliharaan}/selesaikan', [PemeliharaanController::class, 'selesaikan'])
        ->name('pemeliharaan.selesaikan');

});

require __DIR__ . '/auth.php';
