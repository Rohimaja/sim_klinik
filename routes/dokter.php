<?php

use App\Http\Controllers\Dokter\DashboardController;
use App\Http\Controllers\Dokter\KunjunganController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth', 'role:dokter'])->prefix('dokter')->name('dokter.')->group(function () {
    Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');
    Route::get('/kunjungan', [KunjunganController::class, 'index'])->name('kunjungan.index');
    Route::get('/kunjungan/{kunjungan}', [KunjunganController::class, 'show'])->name('kunjungan.show');
    Route::get('/kunjungan/create/{kunjungan}', [KunjunganController::class, 'create'])->name('kunjungan.create');
    Route::get('/kunjungan/{kunjungan}/edit', [KunjunganController::class, 'edit'])->name('kunjungan.edit');
    Route::post('/kunjungan', [KunjunganController::class, 'store'])->name('kunjungan.store');
    Route::put('/kunjungan/{kunjungan}', [KunjunganController::class, 'update'])->name('kunjungan.update');
    Route::post('kunjungan/{id}/update-status', [KunjunganController::class, 'updateStatus'])->name('kunjungan.panggil');
    Route::get('/getFilterKunjungan', [KunjunganController::class, 'getFilterKunjungan']);
    // Route::resource('kunjungan', KunjunganController::class);
});
