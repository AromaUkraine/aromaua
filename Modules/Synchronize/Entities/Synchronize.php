<?php

namespace Modules\Synchronize\Entities;

use Modules\Catalog\Entities\Product;
use Illuminate\Database\Eloquent\Model;
use Modules\Catalog\Entities\PriceType;
use Astrotomic\Translatable\Translatable;
use Modules\Catalog\Entities\ProductCategory;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Modules\Synchronize\Observers\SynchronizeObserver;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class Synchronize extends Model implements TranslatableContract
{

    use Translatable;


    //use Cachable;

    protected $fillable = [
        'product_category_id',
        'product_id',
        'price_type_id',
        'value'
    ];

    public $translatedAttributes = ['name', 'metaphone_key'];


    // protected $dispatchesEvents = [
    //     'updating' => SynchronizeObserver::class,
    //     'updated'  => SynchronizeObserver::class,
    //     'creating' => SynchronizeObserver::class,
    //     'saved'    => SynchronizeObserver::class,
    // ];


    public function getTranslationModelName(): string
    {
        return SynchronizeTranslation::class;
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }


    public function category()
    {
        return $this->belongsTo(ProductCategory::class);
    }


    public function price_type()
    {
        return $this->belongsTo(PriceType::class);
    }


    public function currency()
    {
        return $this->price_type()->currency();
    }
}
