<?php

namespace App\Models\Firebase;

use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class PromotionFirebase extends FirebaseModel
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'libelle',
        'date_debut',
        'date_fin',
        'duree',
        'etat', // actif, cloture, inactif,
        'photo',
        'referntiels',
    ];

    protected $table = 'promotions';
}