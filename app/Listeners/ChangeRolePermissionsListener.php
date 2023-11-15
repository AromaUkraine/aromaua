<?php

namespace App\Listeners;

use App\Events\ChangeRolePermissionsEvent;
use App\Helpers\ArrayHelper;
use App\Models\Permission;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ChangeRolePermissionsListener
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
     * @param  ChangeRolePermissionsEvent  $event
     * @return void
     */
    public function handle(ChangeRolePermissionsEvent $event)
    {

        $permission = Permission::whereIn('slug',$event->permissions)->get();

        // сброс всех доступов по роли
        $event->role->permissions()->detach();

        // назначение новых прав доступа для роли
        if(!ArrayHelper::cnt($permission->toArray(), 0)){
            $event->role->permissions()->attach($permission);
        }


    }
}
