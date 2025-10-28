<?php

use Illuminate\Support\Facades\Route;


Route::middleware(['auth', 'role:perawat'])->prefix('perawat')->name('perawat.')->group(function () {

});
