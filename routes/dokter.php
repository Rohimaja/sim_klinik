<?php

use App\Http\Controllers\Dokter\DashboardController;
use App\Http\Controllers\Dokter\KunjunganController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth', 'role:dokter'])->prefix('dokter')->name('dokter.')->group(function () {
    Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');
    Route::resource('kunjungan', KunjunganController::class);
});
