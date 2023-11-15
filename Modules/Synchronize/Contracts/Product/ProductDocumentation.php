<?php

namespace Modules\Synchronize\Contracts\Product;

interface ProductDocumentation
{
    public function save(array $item, object $event);
}