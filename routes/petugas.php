<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Petugas\KunjunganController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth', 'role:petugas'])->prefix('petugas')->name('petugas.')->group(function () {
    Route::get('/dashboard',[DashboardController::class,'indexPetugas'])->name('dashboard');
    Route::resource('kunjungan', KunjunganController::class);
    Route::post('kunjungan/{id}/update-status', [KunjunganController::class, 'updateStatus'])->name('kunjungan.updateStatus');
    Route::get('/list-pasien',[KunjunganController::class,'listPasien'])->name('kunjungan.list-pasien');

});
