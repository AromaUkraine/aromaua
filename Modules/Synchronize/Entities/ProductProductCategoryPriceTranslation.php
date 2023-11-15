<?php

namespace Modules\Synchronize\Entities;

use App\Traits\JsonDataTrait;
use Illuminate\Database\Eloquent\Model;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;

class ProductProductCategoryPriceTranslation extends Model
{

    use Cachable;

    // трейт для манипуляции json полями
    use JsonDataTrait;

    public $timestamps = false;

    protected $fillable = ['column_name', 'text', 'price', 'currency', 'data'];
}
