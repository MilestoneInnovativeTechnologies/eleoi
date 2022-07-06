<?php

namespace Milestone\Eleoi;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class EleoiServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/eleoi.php','eleoi');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if($this->app->runningInConsole()){
            $this->loadMigrationsFrom(__DIR__.'/../migrations');
            $this->publishes([__DIR__ . '/../public' => public_path()],'eleoi-assets');
            $this->publishes([__DIR__ . '/../install' => base_path()],'eleoi-install');
            $this->publishes([__DIR__ . '/../install/src' => base_path('src')],'eleoi-resources');
            $this->publishes([__DIR__ . '/../public' => public_path(),__DIR__ . '/../install/src' => base_path('src')],'eleoi-updates');
            $this->publishes([__DIR__ . '/../config/eleoi.php' => config_path('eleoi.php')],'eleoi-config');
        } else {
            Route::pattern('eleoi_segments', '.*');
            $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
            $this->loadViewsFrom(__DIR__ . '/../views','Eleoi');
        }
    }
}
