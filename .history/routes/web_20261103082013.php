<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KandangController;
use App\Http\Controllers\PopulasiController;
use App\Http\Controllers\ProduksiTelurController;
use App\Http\Controllers\PenjualanTelurController;
use App\Http\Controllers\PakanKandangController;
use App\Http\Controllers\PemberianPakanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Manpower\LaporanHarianController;
use App\Http\Controllers\BobotAyamController;
use App\Http\Controllers\ArusKasController;
use App\Http\Controllers\GudangTelurController;
use App\Http\Controllers\StokTelurController;
use App\Http\Controllers\UmumController;

// LANDING PAGE (publik)
Route::get('/', function () {
    return view('landing');
})->name('landing');

/* ========== KHUSUS ADMIN ========== */
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('kandang', KandangController::class);
    Route::resource('populasi', PopulasiController::class);
    Route::resource('bobot', BobotAyamController::class);
    Route::resource('produksi-telur', ProduksiTelurController::class);
    Route::resource('penjualan-telur', PenjualanTelurController::class);
    Route::resource('pemberian-pakan', PemberianPakanController::class);
    Route::resource('pakan-kandang', PakanKandangController::class);

    // Laporan Pakan
    Route::get('/laporan-pakan', [PakanKandangController::class, 'laporan'])->name('pakan.laporan');
    Route::get('/laporan-pakan/export', [PakanKandangController::class, 'exportExcel'])->name('pakan.laporan.export');

    // Arus Kas
    Route::get('/arus-kas/export', [ArusKasController::class, 'exportExcel'])->name('arus-kas.export');
    Route::resource('arus-kas', ArusKasController::class)
        ->parameters(['arus-kas' => 'arusKas']);

    // Laporan harian (rekap kiriman man power)
    Route::get('/admin/laporan', [LaporanHarianController::class, 'index'])->name('admin.laporan.index');

    Route::resource('gudang-telur', GudangTelurController::class)
        ->parameters(['gudang-telur' => 'gudangTelur']);

    // Stok Telur
    Route::get('/stok-telur', [StokTelurController::class, 'index'])->name('stok-telur.index');
    Route::post('/stok-telur/stok', [StokTelurController::class, 'storeStok'])->name('stok-telur.stok.store');
    Route::delete('/stok-telur/stok/{stokMasukTelur}', [StokTelurController::class, 'destroyStok'])->name('stok-telur.stok.destroy');
    Route::post('/stok-telur/return', [StokTelurController::class, 'storeReturn'])->name('stok-telur.return.store');
    Route::delete('/stok-telur/return/{returnTelur}', [StokTelurController::class, 'destroyReturn'])->name('stok-telur.return.destroy');
});

/* ========== KHUSUS MAN POWER ========== */
Route::middleware(['auth', 'role:manpower'])->group(function () {
    Route::get('/manpower/laporan', [LaporanHarianController::class, 'create'])->name('manpower.laporan.create');
    Route::post('/manpower/laporan', [LaporanHarianController::class, 'store'])->name('manpower.laporan.store');
});

/* ========== KHUSUS UMUM (MODE BACA / READ-ONLY) ========== */
Route::middleware(['auth', 'role:umum'])->prefix('umum')->name('umum.')->group(function () {
    Route::get('/', [UmumController::class, 'index'])->name('home');
    Route::get('/populasi', [UmumController::class, 'populasi'])->name('populasi');
    Route::get('/produksi', [UmumController::class, 'produksi'])->name('produksi');
    Route::get('/penjualan', [UmumController::class, 'penjualan'])->name('penjualan');
    Route::get('/pakan', [UmumController::class, 'pakan'])->name('pakan');
    Route::get('/laporan-harian', [UmumController::class, 'laporan'])->name('laporan');
});

/* Redirect setelah login sesuai role */
Route::get('/home', function () {
    return match (auth()->user()->role ?? '') {
        'admin'    => redirect()->route('dashboard'),
        'manpower' => redirect()->route('manpower.laporan.create'),
        'umum'     => redirect()->route('umum.home'),
        default    => abort(403),
    };
})->middleware('auth')->name('home.redirect');

require __DIR__.'/auth.php';
