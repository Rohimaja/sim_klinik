<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth', 'role:dokter'])->prefix('dokter')->name('dokter.')->group(function () {
    Route::get('/dashboard',[DashboardController::class,'indexDokter'])->name('dashboard');

});
