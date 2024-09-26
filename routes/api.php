<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

// Routes publiques
Route::post('auth/login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

// Routes protégées
Route::middleware(['auth:api'])->group(function () {
    Route::post('auth/logout', [AuthController::class,'logout']);
});
