<?php

namespace App\Listeners;

use App\Events\ChangeUserRoleEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ChangeUserRoleListener
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
     * @param  ChangeUserRoleEvent  $event
     * @return void
     */
    public function handle(ChangeUserRoleEvent $event)
    {
        // сброс всех прав доступа у пользователя
        $event->user->resetPermissions();
        // сброс всех ролей пользователя
        $event->user->roles()->detach();

        // присвоение новой роли
        $event->user->roles()->attach($event->role);
        // присвоение прав доступа относительно роли
        $event->user->permissions()->attach($event->role->permissions);

    }
}
