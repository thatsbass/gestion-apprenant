<?php

namespace App\Models\Firebase;

class UserFirebase extends FirebaseModel
{
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
 protected $table = 'users';
}
