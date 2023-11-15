<?php

namespace Modules\Catalog\Entities;


use App\Traits\PageTrait;
use App\Traits\QueryTrait;
use App\Traits\JsonDataTrait;


use App\Helpers\CollectionHelper;
use Illuminate\Database\Eloquent\Model;

use Modules\Gallery\Traits\GalleryTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Catalog\Traits\EntityFeatureTrait;
use Modules\Catalog\Traits\FrontendGalleryTrait;
use Modules\Catalog\Traits\ProductCategoryTrait;
use Modules\Synchronize\Entities\ProductProductCategoryPrice;
use Modules\Synchronize\Traits\SynchronizeTrait;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Modules\Documentation\Traits\DocumentationTrait;
use Modules\Synchronize\Traits\ProductDocumentTrait;
use Modules\Catalog\Traits\FrontendFilterProductTrait;
use Modules\AdditionalPage\Traits\AdditionalEntitiesOnPageTrait;


class Product extends Model
{
    // Трейт "мягкого удаления"
    use SoftDeletes;

    // автоматическое кеширование
    // use Cachable;

    // Трейт подключения к модели характеристик
    use EntityFeatureTrait;

    // Трейт подключения к модели страницы
    use PageTrait;

    // Трейт связи с категорией
    use ProductCategoryTrait;

    // Трейт расширяет Eloquent запросы
    use QueryTrait;

    // Трейт подключения к модели галлереи
    use GalleryTrait;

    //
    use SynchronizeTrait;

    use ProductDocumentTrait;

    // трейт для манипуляции json полями
    use JsonDataTrait;



    protected $fillable = [
        'parent_product_id',
        'product_category_id',
        'vendor_code',
        'product_code',
        'group',
        'quantity_in_stock',
        'status',
        'order',
        'code_1c',
        'code',
        'data',
        'is_flavoring'
    ];

    public $timestamps = false;


    protected $dates = ['deleted_at'];


    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_product_id')
            ->where('parent_product_id', '!=', $this->id);
    }

    // все сзязанные с товаром товары включая самого себя
    public function related()
    {
        return $this->hasMany(self::class, 'parent_product_id')
            ->where('parent_product_id', $this->id);
    }

    // все сзязанные с товаром товары исключая самого себя
    public function children()
    {
        return $this->related()->where('id', '!=', $this->id);
    }

    public function product_category_prices()
    {
        return $this->hasMany(ProductProductCategoryPrice::class, 'product_id');
    }
}
