<?php

namespace Modules\Developer\Events;

use Illuminate\Queue\SerializesModels;

class CreateTemplateBySeoPageEvent
{
    use SerializesModels;

    public $page;
    public $locales;
    public $data;

    /**
     * Create a new event instance.
     *
     * @param $page - SeoCatalog
     * @param $data - request
     */
    public function __construct($page, $data)
    {
        $this->page = $page;
        $this->data = $data;
        $this->locales = app()->languages->all()->slug();
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
