<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // I-force lang ang HTTPS kung nasa Railway production talaga
        if (env('RAILWAY_ENVIRONMENT')) {
            URL::forceScheme('https');
        }
    }
}
