<?php
use App\Http\Controllers\Api\Account\EditProfile;
use App\Http\Controllers\Api\Auth\ForgetPasswordController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\RegisterVerificationController;
use App\Http\Controllers\Api\Features\DiseaseDetection;
use App\Http\Controllers\Api\Home\DashboardController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('login', [LoginController::class, 'login']);
    Route::post('registerAccount', [RegisterController::class, 'registerAccount']);
    Route::post('registerAccount/verification/send', [RegisterVerificationController::class, 'sendOTP']);
    Route::post('registerAccount/verification/check', [RegisterVerificationController::class, 'checkOTP']);
    Route::post('forgetPassword', [ForgetPasswordController::class, 'forgetPassword']);
    Route::post('forgetPassword/verification/send', [ForgetPasswordController::class, 'sendOTP']);
    Route::post('forgetPassword/verification/check', [ForgetPasswordController::class, 'checkOTP']);
    Route::post('forgetPassword/changePassword', [ForgetPasswordController::class, 'changePassword']);
});

Route::middleware(['auth:sanctum'])->group(function() {
        Route::prefix('home')->group(function() {
        Route::post('dashboard', [DashboardController::class, 'dashboard']);
    });
    Route::prefix('features')->group(function() {
        Route::post('disease-detection', [DiseaseDetection::class, 'prediction']);
    });
    Route::prefix('account')->group(function() {
        Route::post('profile', [EditProfile::class, 'editProfile']);
    });
});

