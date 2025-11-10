<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth', 'superadmin'])->prefix('superadmin')->name('superadmin.')->group(function () {
    Route::get('/dashboard',[DashboardController::class,'indexSuperAdmin'])->name('dashboard');

    Route::resource('master-admin', AdminController::class);

});
