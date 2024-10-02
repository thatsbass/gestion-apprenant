<?php

namespace App\Providers;

use App\Repositories\Firebase\PromotionFirebaseRepository;
use App\Repositories\Interfaces\PromotionFirebaseRepositoryInterface;
use App\Services\Firebase\FirebaseStorageService;
use App\Services\Interfaces\FirebaseStorageInterface;
use App\Services\Interfaces\PromotionServiceInterface;
use App\Services\Interfaces\ReferentielServiceInterface;
use App\Repositories\Interfaces\ReferentielRepositoryInterface;
use App\Services\PromotionService;
use App\Services\ReferentielService;
use Illuminate\Support\ServiceProvider;
use App\Exports\ModelExport;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ModelExport::class, function ($app, $modelExport) {
            $model = config("models.export.{$modelExport}");
            return new $model();
        });

        $this->app->bind(ReferentielRepositoryInterface::class, ReferentielService::class);
        $this->app->bind(ReferentielServiceInterface::class, ReferentielService::class);
        $this->app->bind(PromotionServiceInterface::class, PromotionService::class);
        $this->app->bind(PromotionFirebaseRepositoryInterface::class,PromotionFirebaseRepository::class);
        $this->app->bind(FirebaseStorageInterface::class, FirebaseStorageService::class);
    
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
