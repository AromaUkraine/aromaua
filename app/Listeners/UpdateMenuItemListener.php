<?php

namespace App\Listeners;

use App\Events\UpdateSectionEvent;
use App\Models\Menu;
use App\Services\MenuCmsService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateMenuItemListener
{

    public function handle($event)
    {
        $data = app(MenuCmsService::class)->getByEvent($event);

        foreach ($data as $item) {

            $menu = Menu::where('permission_id',$item['permission_id'])->first();

            if($menu) {
                $menu->update($item);
            }else{
                Menu::create($item);
            }
        }
    }
}
