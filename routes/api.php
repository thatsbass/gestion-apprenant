<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ApprenantController;
use App\Http\Controllers\ReferentielController;
use Illuminate\Support\Facades\Route;

// Routes publiques
Route::post('auth/login', [AuthController::class, 'login']);
Route::post('/users', [UserController::class, 'store']);
Route::get('/users', [UserController::class, 'index']);

// Routes protégées
Route::middleware(['auth:api'])->group(function () {
    Route::post('auth/logout', [AuthController::class,'logout']);
});



Route::post('/referentiels', [ReferentielController::class, 'store']);
Route::get('/referentiels', [ReferentielController::class, 'index']);

Route::post('/apprenants/import', [ApprenantController::class, 'import']);
