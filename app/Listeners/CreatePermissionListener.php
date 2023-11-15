<?php

namespace App\Listeners;

use App\Models\Permission;
use App\Models\Role;
use App\Models\Template;
use App\Models\User;
use App\Services\PermissionService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreatePermissionListener
{

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
