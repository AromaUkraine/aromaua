<?php


namespace Modules\Synchronize\Traits;


use Modules\Catalog\Entities\PriceType;
use Modules\Synchronize\Entities\Synchronize;
use Modules\Synchronize\Entities\ProductProductCategoryPrice;

trait SynchronizeTrait
{
    // column product
    public function column()
    {
        return $this->hasOne(ProductProductCategoryPrice::class);
    }

    public function columns()
    {
        return $this->hasMany(ProductProductCategoryPrice::class);
    }
}
