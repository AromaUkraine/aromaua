<?php

namespace App\Listeners;

use App\Models\Permission;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DestroyPagePermissionListener
{

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        //57, 58
        $permissions = Permission::withCondition($event->page->pageable->id, $event->page->id)->get();
        foreach ($permissions as $perm){
            $event->permissions[] = $perm;

            $perm->delete();
        }
    }
}
