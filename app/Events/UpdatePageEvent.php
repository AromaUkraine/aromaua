<?php

namespace App\Events;


use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\Developer\Entities\Template;

class UpdatePageEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $pageable;
    public $page;
    public $data;
    public $locales;

    /**
     * Create a new event instance.
     *
     * @param $data
     * @param $page
     */
    public function __construct( $data, $page)
    {

        $this->pageable = Template::findOrFail($data['template_id']);

        unset($data['_token']);
        unset($data['_method']);
        unset($data['enable']);
        unset($data['template_id']);

        $this->page = $page;
        $this->data = $data;
        $this->locales = app()->languages->all()->slug();
    }

}
