<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth', 'role:perawat'])->prefix('perawat')->name('perawat.')->group(function () {
    Route::get('/dashboard',[DashboardController::class,'indexPerawat'])->name('dashboard');

});
