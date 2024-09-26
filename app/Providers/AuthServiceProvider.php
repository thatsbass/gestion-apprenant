<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Factories\AuthFactory;

class AuthServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('AuthService', function ($app) {
            return AuthFactory::make(config('db_service.default'));
        });
    }
}
