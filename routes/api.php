<?php
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\RegisterVerification;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('login', [LoginController::class, 'login']);
    Route::post('registerAccount', [RegisterController::class, 'registerAccount']);
    Route::post('registerAccount/verification/send', [RegisterVerification::class, 'sendOTP']);
    Route::post('registerAccount/verification/check', [RegisterVerification::class, 'checkOTP']);
});

