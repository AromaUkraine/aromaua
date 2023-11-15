<?php


namespace Modules\Catalog\Service;


class CheckModifyService
{
    public function isModify($product): bool
    {

        return $product->parent_product_id == $product->id;
    }
}
