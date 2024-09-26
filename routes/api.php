<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

// Routes publiques
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

// Routes protégées
Route::middleware(['auth:api'])->group(function () {
    Route::post('logout', [AuthController::class,'logout']);
    // Route::get('profile', [UserController::class, 'profile']);
    // Ajoutez d'autres routes protégées ici
});

// Routes spécifiques pour l'authentification par Passport
// Route::middleware(['auth:api'])->group(function () {
//     Route::get('users', [UserController::class, 'index']);
// });
