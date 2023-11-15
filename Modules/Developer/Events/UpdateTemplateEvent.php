<?php

namespace Modules\Developer\Events;


use Illuminate\Queue\SerializesModels;
use Modules\Developer\Entities\Template;

class UpdateTemplateEvent
{
    use SerializesModels;

    public $data;

    public $pageable;

    public $locales;

    public $permissions;

    /**
     * Create a new event instance.
     *
     * @param $data
     * @param Template $template
     */
    public function __construct( $data, Template $template )
    {
        $this->pageable = $template;
        $this->data = $data;
        $this->locales = app()->languages->all()->slug();
    }

}
