<?php

namespace Modules\Gallery\Events;

use Illuminate\Queue\SerializesModels;
use Modules\Gallery\Entities\Gallery;

class UpdateVideoGalleryEvent
{
    use SerializesModels;

    public $data;
    /**
     * @var Gallery
     */
    public $gallery;

    /**
     * Create a new event instance.
     *
     * @param $data
     * @param Gallery $gallery
     */
    public function __construct($data, Gallery $gallery)
    {
        //
        $this->data = $data;
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
