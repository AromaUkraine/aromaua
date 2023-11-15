<?php

namespace Modules\Synchronize\Events;

use Illuminate\Queue\SerializesModels;
use Modules\Developer\Entities\Template;

class SynchronizeImportEvent
{
    use SerializesModels;

    public $template;

    /**
     * @var bool
     */
    public $withCountNomenclature;
    /**
     * @var array
     */
    public $types;

    /**
     * Create a new event instance.
     *
     * @param Template $template
     */
    public function __construct(Template $template)
    {
        $this->template = $template;

        /*** только отдельные серии  ***/
        $this->withCountNomenclature = false;
        $this->types = [];//['CFS','CFB'];
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
