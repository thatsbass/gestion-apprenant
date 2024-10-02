<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Factories\AuthFactory;

class AuthServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton('AuthService', fn($app) => AuthFactory::make(config('db_service.default')));
    }
}
