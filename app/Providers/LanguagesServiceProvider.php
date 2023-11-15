<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class LanguagesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind("languages",  'App\Services\Languages');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
