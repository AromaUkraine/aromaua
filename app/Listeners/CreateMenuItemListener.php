<?php

namespace App\Listeners;

use App\Events\CreateSectionEvent;
use App\Models\Menu;
use App\Services\MenuCmsService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateMenuItemListener
{

    public function handle( $event)
    {
        $data = app(MenuCmsService::class)->getByEvent($event);

        if(!$data)
            return;

        foreach ($data as $item) {
            $root = Menu::where('type',$item['type'])->first();
            unset($item['type']);

            $node = Menu::create($item);

            if($root) {
                $root->appendNode($node);
            }
        }
    }
}
