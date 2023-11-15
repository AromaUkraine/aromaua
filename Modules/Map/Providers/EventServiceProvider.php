<?php


namespace Modules\Map\Providers;


use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Map\Events\UpdateGoogleMapEvent;
use Modules\Map\Listeners\UpdateSimpleGoogleMapListener;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        UpdateGoogleMapEvent::class => [
            UpdateSimpleGoogleMapListener::class
        ]
    ];
}
