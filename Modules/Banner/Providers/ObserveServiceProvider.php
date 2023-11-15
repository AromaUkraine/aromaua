<?php

namespace Modules\Banner\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Banner\Entities\Banner;
use Modules\Banner\Observers\BannerObserver;

class ObserveServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Banner::observe(BannerObserver::class);
    }
}