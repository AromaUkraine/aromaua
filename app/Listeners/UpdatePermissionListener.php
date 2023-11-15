<?php

namespace App\Listeners;

use App\Events\UpdateSectionEvent;
use App\Helpers\ArrayHelper;
use App\Models\Permission;
use App\Models\Template;
use App\Services\PermissionService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdatePermissionListener
{

    public function handle( $event )
    {

        $routes = collect($event->pageable->components)->map(function ($item){
            if(isset($item['data']['routes'])){
                return $item['data']['routes']['cms'];
            }
        })->filter(function ($item){
            return is_array($item);
        })->toArray();

        /*** находим существующие доступы ***/
        $permissions = Permission::withCondition($event->origin_pageable_id, $event->page->id)
            ->get();

        foreach ($routes as $route ) {
            foreach ($route as $item)
            {
                foreach ($permissions as $permission) {

                    if($item['action'] === $permission->action)
                    {
                        $perm = app(PermissionService::class)->setData($event, $item);
                        $permission->update($perm);
                        $event->permissions[] = $permission;

                    }

                }
            }
        }
    }

}
