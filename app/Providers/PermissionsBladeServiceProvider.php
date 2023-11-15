<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class PermissionsBladeServiceProvider extends ServiceProvider
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

        Blade::directive('role', function ($role) {
            return "<?php if(auth()->check() && auth()->user()->hasRole({$role})): ?>"; //return this if statement inside php tag
        });

        Blade::directive('endrole', function ($role) {
            return "<?php endif; ?>"; //return this endif statement inside php tag
        });

        Blade::directive('permission', function ($permission) {
            return "<?php if(auth()->check() && auth()->user()->hasPerm({$permission})): ?>"; //return this if statement inside php tag
        });

        Blade::directive('endpermission', function ($permission) {
            return "<?php endif; ?>"; //return this endif statement inside php tag
        });
    }
}
