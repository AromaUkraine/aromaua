<?php

namespace App\Listeners;

use App\Services\PermissionService;

class PermissionRefreshListener
{

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle()
    {
        app( PermissionService::class)->refresh();
    }
}
