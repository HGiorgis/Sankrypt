<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\VaultController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SpeechToTextController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Global API key middleware + rate limiting
Route::middleware(['api.key', 'throttle:api'])->group(function () {

    // Public routes
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:10,1'); // 10 requests per minute
    Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:5,1'); // 5 requests per minute


    // Protected routes (Sanctum + API key + rate limiting)
    Route::middleware('auth:sanctum')->group(function () {

        // Auth
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/user', [AuthController::class, 'user']);
        Route::post('/auth/change-password', [AuthController::class, 'changePassword']);

        // User preferences
        Route::put('/user/preferences', [UserController::class, 'updatePreferences']);
        Route::get('/user/security-settings', [UserController::class, 'getSecuritySettings']);

        // Vault
        Route::prefix('vault')->group(function () {
            Route::get('/', [VaultController::class, 'index']);
            Route::post('/', [VaultController::class, 'store']);
            Route::get('/{id}', [VaultController::class, 'show']);
            Route::put('/{id}', [VaultController::class, 'update']);
            Route::delete('/{id}', [VaultController::class, 'destroy']);
            Route::get('/category/{category}', [VaultController::class, 'getByCategory']);
        });
    });
});
