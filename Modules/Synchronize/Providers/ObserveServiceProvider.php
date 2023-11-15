<?php

namespace Modules\Synchronize\Providers;

use Modules\Synchronize\Entities\Synchronize;
use Modules\Synchronize\Observers\SynchronizeObserver;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class ObserveServiceProvider extends ServiceProvider
{

    public function boot()
    {
        Synchronize::observe(SynchronizeObserver::class);
    }
}
