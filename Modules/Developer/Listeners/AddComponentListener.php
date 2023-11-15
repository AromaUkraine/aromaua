<?php

namespace Modules\Developer\Listeners;

use App\Models\Component;
use App\Models\PageComponent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AddComponentListener
{

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {

        $res = $event->pageable->data['components'][0];

        $data = [
            'name' => $res['name'],
            'alias' =>$res['alias'],
            'type' =>$res['type'],
            'description' =>$res['description'],
            'data' => $res['data']
        ];

        Component::create($data);
        $event->page->components()->create($data);
    }
}
