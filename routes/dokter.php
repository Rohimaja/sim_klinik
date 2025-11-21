<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Dokter\KunjunganDokterController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth', 'role:dokter'])->prefix('dokter')->name('dokter.')->group(function () {
    Route::get('/dashboard',[DashboardController::class,'indexDokter'])->name('dashboard');
    Route::get('/kunjungan', [KunjunganDokterController::class, 'index'])->name('kunjungan.index');
});
