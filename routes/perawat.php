<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Perawat\KunjunganPerawatController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth', 'role:perawat'])->prefix('perawat')->name('perawat.')->group(function () {
    Route::get('/dashboard',[DashboardController::class,'indexPerawat'])->name('dashboard');
    Route::get('/kunjungan', [KunjunganPerawatController::class, 'index'])->name('kunjungan.index');
    Route::get('/kunjungan/skrining-pasien', [KunjunganPerawatController::class, 'create'])
        ->name('kunjungan.create');
});
