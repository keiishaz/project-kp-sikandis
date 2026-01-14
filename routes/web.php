<?php

use App\Http\Controllers\Admin\KendaraanController as AdminKendaraanController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\OperatorController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Operator\DashboardController as OperatorDashboardController;
use App\Http\Controllers\Operator\KendaraanController as OperatorKendaraanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::prefix('admin')
    ->middleware(['auth', 'role:admin'])
    ->name('admin.')
    ->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::get('kendaraan/export-excel', [AdminKendaraanController::class, 'exportExcel'])->name('kendaraan.export');
        Route::resource('kendaraan', AdminKendaraanController::class);
        Route::resource('kelola-operator', OperatorController::class)->except(['show']);
    });

Route::prefix('operator')
    ->middleware(['auth', 'role:operator,admin'])
    ->name('operator.')
    ->group(function () {
        Route::get('/', [OperatorDashboardController::class, 'index'])->name('dashboard');

        Route::get('kendaraan/export-excel', [OperatorKendaraanController::class, 'exportExcel'])->name('kendaraan.export');
        Route::resource('kendaraan', OperatorKendaraanController::class);
    });
