<?php

namespace App\Events;

use App\Helpers\ArrayHelper;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CreateLanguageEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $language;

    /**
     * Create a new event instance.
     *
     * CreateLanguageEvent constructor.
     * @param string $language
     *
     */
    public function __construct(string $language)
    {
       $this->language = $language;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
