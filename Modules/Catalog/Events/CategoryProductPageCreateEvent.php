<?php

namespace Modules\Catalog\Events;

use Illuminate\Queue\SerializesModels;
use Modules\Catalog\Entities\ProductCategory;

class CategoryProductPageCreateEvent
{
    use SerializesModels;

    public $data;
    /**
     * @var ProductCategory
     */
    public $category;

    /**
     * Create a new event instance.
     *
     * @param $data
     * @param ProductCategory $category
     */
    public function __construct($data, ProductCategory $category)
    {
        $this->data = $data;
        $this->category = $category;
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
