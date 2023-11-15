<?php

namespace Modules\Synchronize\Service\Product;


use Modules\Synchronize\Contracts\Product\ProductCollection;

class ProductCollectionService implements ProductCollection
{

    public function make(?array $data = null): object
    {
        if(is_array($data))
            return collect($data['nomenclatures']);

        return collect();
    }
}
