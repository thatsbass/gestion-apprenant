<?php

namespace App\Providers;

use App\Services\Interfaces\ReferentielServiceInterface;
use App\Repositories\Interfaces\ReferentielRepositoryInterface;
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
    
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
