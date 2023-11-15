<?php

namespace Modules\Developer\Listeners;

use App\Models\Menu;
use App\Services\MenuCmsService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateMenuItemBySeoPageListener
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
