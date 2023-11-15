<?php

namespace Modules\Catalog\Entities;

use App\Models\Page;
use App\Traits\Sortable;
use App\Traits\PageTrait;
use App\Scopes\OrderScope;
use App\Traits\QueryTrait;
use App\Traits\JsonDataTrait;
use App\Traits\ExtendedNodeTrait;
use Modules\Banner\Traits\BannerTrait;
use Illuminate\Database\Eloquent\Model;
use Modules\Catalog\Traits\ProductTrait;
use Modules\Gallery\Traits\GalleryTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Catalog\Traits\EntityFeatureTrait;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;


class ProductCategory extends Model
{
    // Трейт "мягкого удаления"
    use SoftDeletes;

    // Трейт nested - дерево категории
    use ExtendedNodeTrait;

    // Трейт подключения к модели галлереи
    use GalleryTrait;

    // Трейт подключения к модели характеристик
    use EntityFeatureTrait;

    // Трейт подключения к модели баннера
    use BannerTrait;

    // Трейт связи со страницей
    use PageTrait;

    // Трейт связи с товарами
    use ProductTrait;


    use QueryTrait;

    // трейт для манипуляции json полями
    use JsonDataTrait;




    public $timestamps = false;

    protected $dates = ['deleted_at'];

    protected $fillable = ['parent_page_id', 'parent_id', 'order', 'code_1c', 'parent_code_1c', 'data'];


    // Автоматическое увеличение счетчика order
    protected static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->order = self::max('order') + 1;
        });
    }


    // Получение родителькой страницы (Каталог)
    public function getRootPage($category)
    {
        return $category->pageable->rootPage;
    }
}
