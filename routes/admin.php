<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard',[DashboardController::class,'indexAdmin'])->name('dashboard');

});
