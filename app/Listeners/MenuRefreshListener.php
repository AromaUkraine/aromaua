<?php

namespace App\Listeners;

use App\Services\MenuCmsService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class MenuRefreshListener
{

    public function handle()
    {
        app( MenuCmsService::class)->refresh();
    }
}
