<?php

namespace Modules\Gallery\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Gallery\Entities\Gallery;
use Modules\Gallery\Service\VideoService;

class CreateVideoGalleryListener
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
        $data = app(VideoService::class)->setData($event);

        $event->entity->gallery()->create($data);

    }
}
