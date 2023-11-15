<?php

namespace App\Listeners;

use App\Services\CacheKeysService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ResetCacheFrontendMenuListener
{

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle()
    {
         app(CacheKeysService::class)->reset(CacheKeysService::FRONTEND_MENU_KEY);
    }
}
