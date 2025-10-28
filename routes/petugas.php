<?php

use Illuminate\Support\Facades\Route;


Route::middleware(['auth', 'role:petugas'])->prefix('petugas')->name('petugas.')->group(function () {

});
