<?php


namespace Modules\Gallery\Providers;


use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Gallery\Entities\Gallery;
use Modules\Gallery\Observers\GalleryObserver;

class ObserveServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Gallery::observe(GalleryObserver::class);
    }
}
