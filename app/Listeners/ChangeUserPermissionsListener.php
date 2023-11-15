<?php

namespace App\Listeners;

use App\Events\ChangeUserPermissionsEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ChangeUserPermissionsListener
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
     * @param  ChangeUserPermissionsEvent  $event
     * @return void
     */
    public function handle(ChangeUserPermissionsEvent $event)
    {

        $event->user->refreshPermissions($event->permissions);
    }
}
