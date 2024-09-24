<?php

return [
    "default" => env("ACTIVE_DRIVER", "firebase"),
        "pgsql" => [
            "auth" => [
                "sanctum" => [
                    "class" => \App\Services\Authentification\SanctumAuthService::class,
                    "config" => [
                        "expiration" => env("SANCTUM_EXPIRATION", 60 * 24),
                    ],
                ],
                "passport" => [
                    "class" => \App\Services\Authentification\PassportAuthService::class,
                    "config" => [
                        "client_id" => env("PASSPORT_PASSWORD_GRANT_CLIENT_ID"),
                        "client_secret" => env("PASSPORT_PASSWORD_GRANT_CLIENT_SECRET"),
                        "expiration" => env("PASSPORT_EXPIRATION", 60 * 24),
                    ],
                ],
            ],
            "model" => [
                "user" => \App\Models\User::class,
            ]
        ],
        "firebase" => [
            "auth" => [
                "class" => \App\Services\Authentification\FirebaseAuthService::class,
                "config" => [
                    'firebase_credentials' => env('FIREBASE_CREDENTIALS'),
                    'firebase_database_url' => env('FIREBASE_DATABASE_URL'),
                ],
            ],
        ],
];
