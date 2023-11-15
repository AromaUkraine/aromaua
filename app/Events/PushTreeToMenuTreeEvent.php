<?php

namespace App\Events;

use App\Models\Menu;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Kalnoy\Nestedset\Collection;

class PushTreeToMenuTreeEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Menu
     */
    public $root;
    /**
     * @var Collection
     */
    public $tree;
    /**
     * @var array
     */
    public $data;


    /**
     * Create a new event instance.
     *
     * @param Menu $root
     * @param Collection $tree
     * @param array $data
     */
    public function __construct(Menu $root, Collection $tree, $data = [])
    {
        $this->root = $root;
        $this->tree = $tree;
        $this->data = $data;
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
