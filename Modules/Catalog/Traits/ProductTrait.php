<?php


namespace Modules\Catalog\Traits;

use Modules\Catalog\Entities\Product;

/**
 * Трейт связи категории с товарами
 * Trait ProductTrait
 * @package Modules\Catalog\Traits
 */
trait ProductTrait
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
