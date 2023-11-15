<?php

namespace Modules\Synchronize\Providers;


use Illuminate\Support\ServiceProvider;
use Modules\Synchronize\Console\SynchronizeReset;
use Modules\Synchronize\Console\ApiSynchronizeImport;

class CommandServiceProvider extends ServiceProvider
{
    public function boot()
    {


    }

    public function register()
    {
        $this->commands([
            SynchronizeReset::class,
            ApiSynchronizeImport::class
        ]);
    }
}
