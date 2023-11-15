<?php

namespace Modules\Synchronize\Contracts\Product;

interface ProductProductCategoryPrice
{
    /**
     * Undocumented function
     *
     * @param array $data
     * @return Illuminate\Support\Collection
     */
    public function save(array $item, object $event);
}