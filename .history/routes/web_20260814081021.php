<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\LaporanHarianController as AdminLaporanHarianController;
use App\Http\Controllers\Manpower\DashboardController as ManpowerDashboardController;
use App\Http\Controllers\Manpower\LaporanHarianController as ManpowerLaporanHarianController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Halaman awal
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});


/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/laporan', [AdminLaporanHarianController::class, 'index'])
            ->name('laporan.index');

        Route::get('/laporan/{laporan}', [AdminLaporanHarianController::class, 'show'])
            ->name('laporan.show');
    });


/*
|--------------------------------------------------------------------------
| Manpower
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:manpower'])
    ->prefix('manpower')
    ->name('manpower.')
    ->group(function () {

        Route::get('/dashboard', [ManpowerDashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/laporan/create', [ManpowerLaporanHarianController::class, 'create'])
            ->name('laporan.create');

        Route::post('/laporan', [ManpowerLaporanHarianController::class, 'store'])
            ->name('laporan.store');
    });


/*
|--------------------------------------------------------------------------
| Profile
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});


require __DIR__.'/auth.php';
