<?php

namespace App\Listeners;

use App\Services\CacheKeysService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ResetPagesCacheListener
{

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle()
    {
        app(CacheKeysService::class)->reset(CacheKeysService::PAGE_ACTIVE_PUBLISH);
    }
}
