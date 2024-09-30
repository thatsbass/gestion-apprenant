<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ApprenantController;
use App\Http\Controllers\ReferentielController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'v1'], function () { 

// Authentification
Route::post('auth/login', [AuthController::class, 'login']);
Route::middleware(['auth:api'])->group(function () {
    Route::post('auth/logout', [AuthController::class,'logout']);
});

// Users
Route::prefix('users')->group(function () {
    Route::post('/', [UserController::class, 'store']);
    Route::get('/', [UserController::class, 'index']);
    });

// Referentiels
Route::prefix('referentiels')->group(function () {
Route::post('/', [ReferentielController::class, 'store']);
Route::get('/', [ReferentielController::class, 'index']);
});

// Apprenant
Route::prefix('apprenants')->group(function () {
Route::post('/import', [ApprenantController::class, 'import']);
});

// Promotion
Route::prefix('promotions')->group(function () {
Route::post('/',[PromotionController::class,'store']); 
Route::patch('/{id}', [PromotionController::class,'updatePromotionInfos']); 
Route::patch('/{id}/refentiels', [PromotionController::class,'addReferentielToPromotion']);
Route::patch('/{id}/etat', [PromotionController::class,'updateStatusPromotion']);
Route::get('/encours', [PromotionController::class,'getPromotionActif']);
Route::patch('/{id}/cloturer', [PromotionController::class,'closePromotion']);
Route::get('/{id}/refentiels', [PromotionController::class,'getAllReferentielsByPromotion']);
Route::get('/{id}/stats', [PromotionController::class,'getStatsByPromotion']);
});

});