<?php

namespace Modules\Synchronize\Traits;

use Modules\Synchronize\Entities\ProductDocument;

trait ProductDocumentTrait
{


    /**
     *  Get all of the documents for the ProductDocumentTrait
     *
     * @return HasMany
     */
    public function documents()
    {
        return $this->hasMany(ProductDocument::class);
    }
}
