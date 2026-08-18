<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\KandangController;
use App\Http\Controllers\PopulasiController;
use App\Http\Controllers\ProduksiTelurController;
use App\Http\Controllers\PenjualanTelurController;
use App\Http\Controllers\PakanKandangController;
use App\Http\Controllers\PemberianPakanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Manpower\LaporanHarianController;

// Belum login → lempar ke login. Sudah login → sesuai role.
Route::get('/', function () {
    if (! Auth::check()) {
        return redirect()->route('login');
    }

    /** @var \App\Models\User $user */
    $user = Auth::user();

    return $user->role === 'admin'
        ? redirect()->route('dashboard')
        : redirect()->route('manpower.laporan.create');
});

/* ========== KHUSUS ADMIN ========== */
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('kandang', KandangController::class);
    Route::resource('populasi', PopulasiController::class);
    Route::resource('produksi-telur', ProduksiTelurController::class);
    Route::resource('penjualan-telur', PenjualanTelurController::class);
    Route::resource('pemberian-pakan', PemberianPakanController::class);
    Route::resource('pakan-kandang', PakanKandangController::class);

    Route::get('/laporan-pakan', [PakanKandangController::class, 'laporan'])->name('pakan.laporan');

    // Admin melihat kiriman recording manpower
    Route::get('/admin/laporan', [LaporanHarianController::class, 'index'])->name('admin.laporan.index');
});

/* ========== KHUSUS MANPOWER ========== */
Route::middleware(['auth', 'role:manpower'])->group(function () {
    Route::get('/manpower/laporan', [LaporanHarianController::class, 'create'])->name('manpower.laporan.create');
    Route::post('/manpower/laporan', [LaporanHarianController::class, 'store'])->name('manpower.laporan.store');
});

require __DIR__.'/auth.php';
