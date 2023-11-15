<?php

namespace App\Events;

use App\Http\Requests\SectionRequest;
use App\Models\Section;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UpdateSectionEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var array
     */
    public $data;
    /**
     * @var Section
     */
    public $pageable;

    public $locales;

    public $permissions;

    /**
     * Create a new event instance.
     *
     * @param SectionRequest $request
     * @param Section $section
     */
    public function __construct(SectionRequest $request, Section $section)
    {
        //
        $request->offsetUnset('_token');
        $request->offsetUnset('_method');
        $request->offsetUnset('enable');

        $this->data = $request->all();
        $this->pageable = $section;
        $this->locales = app()->languages->all()->slug();

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
