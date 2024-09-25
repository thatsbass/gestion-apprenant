<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Authentification\AuthFactory;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Enregistre les services d'authentification.
     */
    public function register()
    {
        $this->app->singleton('AuthService', function ($app) {
            return AuthFactory::make(config('auth.default'));
        });
    }
}
