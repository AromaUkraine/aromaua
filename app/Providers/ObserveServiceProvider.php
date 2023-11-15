<?php

namespace App\Providers;


use App\Models\Menu;
use App\Models\Settings;
use App\Observers\MenuObserver;
use App\Observers\SettingsObserver;
use Illuminate\Support\ServiceProvider;

class ObserveServiceProvider extends ServiceProvider
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
        Menu::observe(MenuObserver::class);
    }
}
