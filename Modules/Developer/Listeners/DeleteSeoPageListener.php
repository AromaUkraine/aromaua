<?php

namespace Modules\Developer\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class DeleteSeoPageListener
{

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $data = $event->page->data;
        $class = $data['entityable_type'];
        $class::findOrFail($data['entityable_id'])->delete();
    }
}
