<?php

namespace App\Listeners;


use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ResetCachePagesRouteListener
{

    /**
     * Handle the event.
     * @return void
     */
    public function handle()
    {
        \Artisan::call('cache:forget pages_routes');
        \Artisan::call('modelCache:clear');
    }
}
