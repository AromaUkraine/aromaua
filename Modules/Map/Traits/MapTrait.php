<?php


namespace Modules\Map\Traits;

use Modules\Map\Entities\EntityMap;

trait MapTrait
{
    public function map()
    {
        return $this->morphOne(EntityMap::class, 'mapable');
    }
}
