<?php

return [
    // Driver d'authentification par défaut
    'default' => env('ACTIVE_DRIVER', 'firebase'),

    // Configuration pour PostgreSQL (Sanctum et Passport)
    'pgsql' => [
        'auth' => [
            'sanctum' => [
                'class' => \App\Services\Authentification\SanctumAuthService::class,
                'config' => [
                    'expiration' => env('SANCTUM_EXPIRATION', 60 * 24), // 24 heures par défaut
                ],
            ],
            'passport' => [
                'class' => \App\Services\Authentification\PassportAuthService::class,
                'config' => [
                    'client_id' => env('PASSPORT_PASSWORD_GRANT_CLIENT_ID'),
                    'client_secret' => env('PASSPORT_PASSWORD_GRANT_CLIENT_SECRET'),
                    'expiration' => env('PASSPORT_EXPIRATION', 60 * 24), // 24 heures par défaut
                ],
            ],
        ],
        'model' => [
            'user' => \App\Models\User::class, // Modèle utilisateur
        ],
    ],

    // Configuration pour Firebase
    'firebase' => [
        'auth' => [
            'class' => \App\Services\Authentification\FirebaseAuthService::class,
            'config' => [
                'firebase_credentials' => env('FIREBASE_CREDENTIALS'), // Chemin du fichier JSON des clés Firebase
                'firebase_database_url' => env('FIREBASE_DATABASE_URL'), // URL de la base de données Firebase
            ],
        ],
    ],


    'drivers' => [
        'ldap' => [
            'class' => \App\Services\Authentification\LdapAuthService::class,
            'config' => [
                'server' => env('LDAP_SERVER'),
                'port' => env('LDAP_PORT', 389),
            ],
        ],
    ],

    // Configuration globale des services d'authentification
    'global_config' => [
        'token_expiration' => env('TOKEN_EXPIRATION', 60 * 24), // Durée par défaut des tokens (24 heures)
        'refresh_token_enabled' => env('REFRESH_TOKEN_ENABLED', true), // Activer/désactiver les tokens d'actualisation
        'password_reset_expiration' => env('PASSWORD_RESET_EXPIRATION', 60), // Durée d'expiration des tokens de réinitialisation de mot de passe (en minutes)
    ],
];
