<?php

namespace Modules\Map\Events;

use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;

class UpdateGoogleMapEvent
{
    use SerializesModels;

    public $data;

    /**
     * Create a new event instance.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->data = $request->all();
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
