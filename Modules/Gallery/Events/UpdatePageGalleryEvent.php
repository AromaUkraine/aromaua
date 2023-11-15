<?php

namespace Modules\Gallery\Events;

use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;
use Modules\Gallery\Entities\Gallery;

class UpdatePageGalleryEvent
{
    use SerializesModels;

    /**
     * @var Request
     */
    public $request;
    /**
     * @var Gallery
     */
    public $gallery;

    /**
     * Create a new event instance.
     *
     * @param Request $request
     * @param Gallery $gallery
     */
    public function __construct(Request $request, Gallery $gallery)
    {
        $this->request = $request;
        $this->gallery = $gallery;
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
