<?php

namespace App\Events;

use App\Models\Page;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DestroyPageEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Page
     */
    public $page;

    public $permissions = [];

    /**
     * Create a new event instance.
     *
     * @param Page $page
     */
    public function __construct(Page $page)
    {
        $this->page = $page;
    }

}
