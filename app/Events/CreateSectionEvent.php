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

class CreateSectionEvent
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
     * @param $data
     */
    public function __construct( $data )
    {

        unset($data['_token']);
        unset($data['_method']);
        unset($data['enable']);

        $this->data = $data;

        $this->locales = app()->languages->all()->slug();
    }

}
