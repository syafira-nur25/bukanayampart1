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
    // Catatan: Route custom seperti /export HARUS diletakkan SEBELUM Route::resource
    // agar tidak ditangkap sebagai parameter {arusKas}
    Route::get('/arus-kas/export', [ArusKasController::class, 'exportExcel'])->name('arus-kas.export');
    Route::resource('arus-kas', ArusKasController::class)
        ->parameters(['arus-kas' => 'arusKas']); // <-- biar parameternya {arusKas}, bukan {arus_ka}

    // Laporan harian (rekap kiriman man power)
    Route::get('/admin/laporan', [LaporanHarianController::class, 'index'])->name('admin.laporan.index');
    Route::resource('gudang-telur', GudangTelurController::class)
    ->parameters(['gudang-telur' => 'gudangTelur']);

// Stok Telur
Route::get('/stok-telur', [StokTelurController::class, 'index'])->name('stok-telur.index');
Route::post('/stok-telur/return', [StokTelurController::class, 'storeReturn'])->name('stok-telur.return.store');
Route::delete('/stok-telur/return/{returnTelur}', [StokTelurController::class, 'destroyReturn'])->name('stok-telur.return.destroy');

    // Export Excel (aktifkan kalau method exportExcel sudah ada di controller)
    // Route::get('/admin/laporan/export', [LaporanHarianController::class, 'exportExcel'])->name('admin.laporan.export');
});

/* ========== KHUSUS MAN POWER ========== */
Route::middleware(['auth', 'role:manpower'])->group(function () {
    Route::get('/manpower/laporan', [LaporanHarianController::class, 'create'])->name('manpower.laporan.create');
    Route::post('/manpower/laporan', [LaporanHarianController::class, 'store'])->name('manpower.laporan.store');
});

require __DIR__.'/auth.php';
