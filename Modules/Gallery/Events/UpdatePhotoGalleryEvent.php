<?php

namespace Modules\Gallery\Events;

use Illuminate\Queue\SerializesModels;
use Modules\Gallery\Entities\Gallery;

class UpdatePhotoGalleryEvent
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
     * @return void
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
