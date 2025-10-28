<?php

use Illuminate\Support\Facades\Route;


Route::middleware(['auth', 'role:pasien'])->prefix('pasien')->name('pasien.')->group(function () {

});
