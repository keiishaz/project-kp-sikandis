<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\OperatorController;
use App\Http\Controllers\PublicKendaraanController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\KendaraanController as AdminKendaraanController;
use App\Http\Controllers\Operator\DashboardController as OperatorDashboardController;
use App\Http\Controllers\Operator\KendaraanController as OperatorKendaraanController;

use App\Http\Controllers\Admin\ActivityLogController as AdminActivityLogController;

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
        
        Route::get('/activity-logs', [AdminActivityLogController::class, 'index'])->name('activity_logs.index');

        Route::get('kendaraan/export-excel', [AdminKendaraanController::class, 'exportExcel'])->name('kendaraan.export');
        Route::post('kendaraan/{kendaraan}/regenerate-qr', [AdminKendaraanController::class, 'regenerateQr'])->name('kendaraan.regenerate');
        Route::get('kendaraan/{kendaraan}/print-qr', [AdminKendaraanController::class, 'printQr'])->name('kendaraan.print');
        Route::resource('kendaraan', AdminKendaraanController::class);
        Route::resource('kelola-operator', OperatorController::class)->except(['show']);
    });

Route::prefix('operator')
    ->middleware(['auth', 'role:operator,admin'])
    ->name('operator.')
    ->group(function () {
        Route::get('/', [OperatorDashboardController::class, 'index'])->name('dashboard');

        Route::get('kendaraan/export-excel', [OperatorKendaraanController::class, 'exportExcel'])->name('kendaraan.export');
        Route::post('kendaraan/{kendaraan}/regenerate-qr', [OperatorKendaraanController::class, 'regenerateQr'])->name('kendaraan.regenerate');
        Route::get('kendaraan/{kendaraan}/print-qr', [OperatorKendaraanController::class, 'printQr'])->name('kendaraan.print');
        Route::resource('kendaraan', OperatorKendaraanController::class);
    });

Route::get('/{kode_qr}', [PublicKendaraanController::class, 'show'])
    ->name('umum.public');


