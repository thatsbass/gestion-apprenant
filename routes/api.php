<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\PromotionController;
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

Route::post('/promotions',[PromotionController::class,'store']); // done
Route::patch('/promotions/{id}', [PromotionController::class,'updatePromotionInfos']); 
Route::patch('promotions/{id}/refentiels', [PromotionController::class,'addReferentielToPromotion']);
Route::patch('promotions/{id}/etat', [PromotionController::class,'updateStatusPromotion']);
Route::get('promotions/encours', [PromotionController::class,'getPromotionActif']);
Route::patch('promotions/{id}/cloturer', [PromotionController::class,'closePromotion']);
Route::get('promotions/{id}/refentiels', [PromotionController::class,'getAllReferentielsByPromotion']);
Route::get('promotions/{id}/stats', [PromotionController::class,'getStatsByPromotion']);