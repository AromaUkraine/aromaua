<?php

namespace Modules\Developer\Listeners;

use App\Models\Permission;
use App\Services\PermissionService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreatePermissionBySeoPageListener
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
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {

        $routes = collect($event->pageable->components)->map(function ($item){
            if(isset($item['data']['routes'])){
                return $item['data']['routes']['cms'];
            }
        })->filter(function ($item){
            return is_array($item);
        })->toArray();


        foreach ($routes as $route ) {
            foreach ($route as $item)
            {
                $perm = app(PermissionService::class)->setData($event, $item);
                if($perm) {

                    $permission = Permission::create($perm);
                    $event->permissions[] = $permission;
                    app(PermissionService::class)->assignment($permission);
                }
            }
        }
    }
}
