<?php

namespace App\Events;

use App\Models\Section;


use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\Developer\Entities\Template;

class CreatePageEvent
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
     * @param $template_id
     * @param $data
     */
    public function __construct( $data )
    {

        $this->pageable = Template::findOrFail($data['template_id']);
        unset($data['_token']);
        unset($data['_method']);
        unset($data['enable']);
        unset($data['template_id']);

        $this->data = $data;
        $this->locales = app()->languages->all()->slug();
    }


}
