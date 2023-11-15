<?php

namespace App\Listeners;

use App\Events\CacheResetPagesRouteEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CacheResetPagesRouteListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  CacheResetPagesRouteEvent  $event
     * @return void
     */
    public function handle(CacheResetPagesRouteEvent $event)
    {
        \Artisan::call('cache:forget pages_routes');
    }
}
