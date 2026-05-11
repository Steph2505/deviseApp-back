<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DevisController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    // Auth
    Route::get('/auth/me',      [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::prefix('devises')->group(function () {

        Route::get('/', [DevisController::class, 'index']);
        Route::post('/store', [DevisController::class, 'store']);
        Route::get('/{devise}', [DevisController::class, 'show']);
        Route::put('/{devise}', [DevisController::class, 'update']);
        Route::delete('/{devise}', [DevisController::class, 'destroy']);
    });

    Route::prefix('users')->group(function () {

        Route::get('/', [UserController::class, 'index']);
        Route::post('/', [UserController::class, 'store']);
        Route::get('/create', [UserController::class, 'create']);
        Route::get('/{user}', [UserController::class, 'show']);
        Route::put('/{user}', [UserController::class, 'updated']);
        Route::delete('/{user}', [UserController::class, 'destroy']);
    });

});