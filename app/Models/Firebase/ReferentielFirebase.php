<?php

namespace App\Models\Firebase;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;

class ReferentielFirebase extends FirebaseModel
{
    use HasApiTokens, HasFactory;

    protected $fillable = [
        'code',
        'libelle',
        'description',
        'statut', // actif, inactif, archiver
        'photo',
        'competences' 
    ];

    protected string $collection = 'referentiels';
}
