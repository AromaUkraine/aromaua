<?php

namespace App\Listeners;

use App\Models\Menu;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DestroyMenuItemListener
{

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $permissionsIds = collect($event->permissions)->pluck('id');

        Menu::whereIn('permission_id',$permissionsIds)->delete();
    }
}
