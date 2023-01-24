<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ScraperServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Scraper', 'App\Services\ScraperService');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    
}
