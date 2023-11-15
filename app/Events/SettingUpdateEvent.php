<?php

namespace App\Events;

use App\Models\Settings;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;

class SettingUpdateEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Request
     */
    public $request;
    /**
     * @var Settings
     */
    public $setting;

    /**
     * Create a new event instance.
     *
     * @param Request $request
     * @param Settings $setting
     */
    public function __construct(Request $request, Settings $setting)
    {

        $this->request = $request;
        $this->setting = $setting;
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
