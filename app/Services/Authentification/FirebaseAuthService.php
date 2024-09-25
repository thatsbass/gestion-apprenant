<?php

namespace App\Services\Authentification;

use Kreait\Firebase\Auth;

class FirebaseAuthService
{
    protected $firebaseAuth;

    public function __construct()
    {
        $this->firebaseAuth = (new \Kreait\Firebase\Factory)
            ->withServiceAccount(config('firebase.credentials.path'))
            ->createAuth();
    }

    public function register(array $data)
    {
        return $this->firebaseAuth->createUser([
            'email' => $data['email'],
            'password' => $data['password'],
            'displayName' => $data['nom'] . ' ' . $data['prenom'],
        ]);
    }

    public function login($email, $password)
    {
        // Utilisez une bibliothèque d'authentification JWT pour gérer le login
    }

    public function logout($uid)
    {
        // Gérer la déconnexion de l'utilisateur
    }
}
