<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PassController;
use App\Http\Controllers\UserController;

Route::middleware('api')->group(function () {
    Route::post('register', [UserController::class, 'register']);
    Route::post('verify-secret-word', [PassController::class, 'verifySecretWord']);
    Route::post('save-password', [PassController::class, 'savePassword']);
    Route::post('get-passwords', [PassController::class, 'getpassword']);
    Route::post('suggest-password', [PassController::class, 'suggestPassword']);
});