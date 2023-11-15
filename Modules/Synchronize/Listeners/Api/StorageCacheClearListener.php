<?php

namespace Modules\Synchronize\Listeners\Api;

use Illuminate\Support\Facades\Artisan;

class StorageCacheClearListener
{
    public function handle($event)
    {
        Artisan::call('cache:clear');
    }
}
