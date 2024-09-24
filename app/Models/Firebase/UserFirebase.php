<?php

namespace App\Models\Firebase;


use Laravel\Sanctum\HasApiTokens;

class UserFirebase extends FirebaseModel
{
    use HasApiTokens;
        protected $fillable = [
            'nom',
            'prenom',
            'telephone',
            'adresse',
            'fonction',
            'email',
            'password',
            'role',
            'statut',
            'photo',
        ];
    protected string $collection = 'users';
}
