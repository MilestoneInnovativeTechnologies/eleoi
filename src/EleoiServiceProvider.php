<?php

namespace Milestone\Eleoi;

use Illuminate\Support\ServiceProvider;

class EleoiServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
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
        }
    }
}
