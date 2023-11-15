<?php

namespace Modules\Shop\Traits;

use Modules\Shop\Entities\EntityContact;

/**
 *
 */
trait ContactTrait
{

    public function contacts()
    {
        return $this->morphMany(EntityContact::class, 'contactable');
    }

    public function phones()
    {
        return $this->morphMany(EntityContact::class, 'contactable')
            ->where('type', EntityContact::TYPE_PHONE);
    }

    public function emails()
    {
        return $this->morphMany(EntityContact::class, 'contactable')
            ->where('type', EntityContact::TYPE_EMAIL);
    }

}
