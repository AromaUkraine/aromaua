<?php

namespace Modules\Synchronize\Contracts\Product;

interface ProductCollection
{
    /**
     * Undocumented function
     *
     * @param array $data
     * @return Illuminate\Support\Collection
     */
    public function make(array $data): object;
}
