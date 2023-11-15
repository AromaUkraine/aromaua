<?php

namespace App\Events;

use App\Models\Menu;
use App\Models\Page;
use App\Services\PublishAttribute;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UpdateFrontendMenuItemEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Menu
     */
    public $menu;
    /**
     * @var Page
     */
    public $page;

    public $status;

    /**
     * Create a new event instance.
     *
     * @param Menu $menu
     * @param Page $page
     * @param $status
     */
    public function __construct(Menu $menu, Page $page, $status)
    {
        $this->menu = $menu;
        $this->page = $page;
        $this->status = $status;
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
