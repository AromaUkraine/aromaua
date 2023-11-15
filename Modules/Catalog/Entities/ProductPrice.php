<?php

namespace Modules\Catalog\Entities;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class ProductPrice extends Model
{
    // автоматическое кеширование
//    use Cachable;

    protected $fillable = ['product_id','price_type_id','value'];

    public function type()
    {
        return $this->belongsTo(PriceType::class,'price_type_id');
    }

}
