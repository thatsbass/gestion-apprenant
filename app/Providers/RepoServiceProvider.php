<?php

namespace App\Providers;

use App\Repositories\Firebase\UserFirebaseRepository;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\ComposeRepository;
use App\Repositories\Interfaces\ComposeRepositoryInterface;

class RepoServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, function ($app) {
            $driver = config("db_service.default");
            $repoActive = config("db_service.{$driver}.Repository");
            $class = $repoActive['class'];
            return new $class;
        });

        $this->app->bind(ComposeRepositoryInterface::class, function ($app) {
            return new ComposeRepository(
                $app->make(UserFirebaseRepository::class),
                $app->make(UserRepository::class)
            );
        });
    }

    


    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
