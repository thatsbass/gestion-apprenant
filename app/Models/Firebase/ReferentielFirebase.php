<?php

namespace App\Models\Firebase;

use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class ReferentielFirebase extends FirebaseModel
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'code',
        'libelle',
        'description',
        'statut', // actif, inactif, archiver
        'photo',
        'competences' 
    ];

    protected $table = 'referentiels';
}