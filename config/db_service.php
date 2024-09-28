<?php

return [
    // Default authentication driver
    'default' => env('ACTIVE_DRIVER'),

    // PostgreSQL configuration (Sanctum and Passport)
    'pgsql' => [
        'auth' => [
                'class' => \App\Services\Authentification\PassportAuthService::class,
                'config' => [
                    'client_id' => env('PASSPORT_PASSWORD_GRANT_CLIENT_ID'),
                    'client_secret' => env('PASSPORT_PASSWORD_GRANT_CLIENT_SECRET'),
                    'expiration' => env('PASSPORT_EXPIRATION', 60 * 24), // Default: 24 hours
                ],
        ],
        'model' => [
            'user' => \App\Models\User::class, // User model
        ],
        'Repository'=> [
            'class' => \App\Repositories\UserRepository::class,
        ],
    ],

    // Firebase configuration
    'firebase' => [
        'auth' => [
            'class' => \App\Services\Authentification\FirebaseAuthService::class,
            'config' => [
                'credentials' => env('FIREBASE_CREDENTIALS'),
                'url' => env('FIREBASE_DATABASE_URL'),
            ],
        ],
        'model'=> [
            'user'=> \App\Models\Firebase\UserFirebase::class,
        ],
        'Repository'=> [
            'class' => \App\Repositories\Firebase\UserFirebaseRepository::class,
        ],
    ],

    'drivers' => [
        'ldap' => [
            // 'class' => \App\Services\Authentification\LdapAuthService::class,
            'config' => [
                'server' => env('LDAP_SERVER'),
                'port' => env('LDAP_PORT', 389),
            ],
        ],
    ],

    // Global authentication service configuration
    'global_config' => [
        'token_expiration' => env('TOKEN_EXPIRATION', 60 * 24),
        'refresh_token_enabled' => env('REFRESH_TOKEN_ENABLED', true),
        'password_reset_expiration' => env('PASSWORD_RESET_EXPIRATION', 60),
    ],
];
