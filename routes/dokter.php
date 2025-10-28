<?php

use Illuminate\Support\Facades\Route;


Route::middleware(['auth', 'role:dokter'])->prefix('dokter')->name('dokter.')->group(function () {

});
