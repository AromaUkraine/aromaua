<?php


namespace Modules\Catalog\Traits;

use Modules\Catalog\Entities\ProductCategory;

/**
 *  Трейт связи товара с категорией
 * Trait ProductCategoryTrait
 * @package Modules\Catalog\Traits
 */
trait ProductCategoryTrait
{

    // Связь с категорией
    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }
}
