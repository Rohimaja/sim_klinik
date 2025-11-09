<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DokterController;
use App\Http\Controllers\Admin\JadwalDokterController;
use App\Http\Controllers\Admin\ObatController;
use App\Http\Controllers\Admin\PasienController;
use App\Http\Controllers\Admin\PerawatController;
use App\Http\Controllers\Admin\PetugasController;
use App\Http\Controllers\Admin\PoliController;
use App\Http\Controllers\Admin\TindakanController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard',[DashboardController::class,'indexAdmin'])->name('dashboard');

    Route::resource('master-dokter', DokterController::class);
    Route::resource('master-perawat', PerawatController::class);
    Route::resource('master-petugas', PetugasController::class)->parameters(['master-petugas' => 'master_petugas']);
    Route::resource('master-pasien', PasienController::class);
    Route::resource('master-poli', PoliController::class);
    Route::resource('master-obat', ObatController::class);
    Route::resource('master-tindakan', TindakanController::class);
    Route::resource('master-jadwal', JadwalDokterController::class);


});
