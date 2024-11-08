<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PassController;
use App\Http\Controllers\UserController;

Route::middleware('api')->group(function () {
    Route::post('register', [UserController::class, 'register']);
    
    Route::post('login', [UserController::class, 'login']);
    Route::post('verify-secret-word', [PassController::class, 'verifySecretWord']);

    

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('suggest-password', [PassController::class, 'suggestPassword']);
        Route::post('register-secret-word', [UserController::class, 'registerSecretWord']);
        Route::post('save-password', [PassController::class, 'savePassword']);
        Route::post('get-sistems', [PassController::class, 'getSistemsUser']);
        Route::post('get-passwords', [PassController::class, 'getpassword']);
    });

});