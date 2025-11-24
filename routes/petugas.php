<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Petugas\KunjunganPasienController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth', 'role:petugas'])->prefix('petugas')->name('petugas.')->group(function () {
    Route::get('/dashboard',[DashboardController::class,'indexPetugas'])->name('dashboard');
    Route::get('/kunjungan', [KunjunganPasienController::class, 'index'])->name('kunjungan.index');
    Route::get('/kunjungan/tambah-pasien', [KunjunganPasienController::class, 'create'])
        ->name('kunjungan.create');
});
