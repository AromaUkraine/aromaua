<?php

namespace Modules\Catalog\Entities;


use App\Scopes\OrderScope;
use App\Traits\PageTrait;
use App\Traits\QueryTrait;
use App\Traits\Sortable;
use App\Traits\WidgetTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\AdditionalPage\Traits\AdditionalEntitiesOnMenuTrait;
use Modules\AdditionalPage\Traits\AdditionalEntitiesOnPageTrait;
use Modules\Banner\Traits\BannerTrait;
use Modules\Catalog\Traits\EntityFeatureTrait;
use Modules\Catalog\Traits\FrontendGalleryTrait;
use Modules\Catalog\Traits\ProductCategoryTrait;
use Modules\Gallery\Entities\Gallery;
use Modules\Gallery\Traits\GalleryTrait;


class SeoCatalog extends Model
{

    // Трейт "мягкого удаления"
    use SoftDeletes;


    // автоматическое кеширование
    // use Cachable;


    // Трейт подключения к модели галлереи
    use GalleryTrait;

    // Трейт подключения к модели характеристик
    use EntityFeatureTrait;

    // Трейт подключения к модели страницы
    use PageTrait;

    // Трейт подключения к модели баннера
    use BannerTrait;

    // Трейт связи с категорией
    use ProductCategoryTrait;


    // Трейт сортировки
    use Sortable;

    // Трейт с доп-запросами
    use QueryTrait;

    // Привязка галереи (фронтенд)
    use FrontendGalleryTrait;


    public $timestamps = false;

    protected $fillable = ['product_category_id', 'parent_page_id', 'is_brand', 'country_id', 'order'];


    protected static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->order = self::max('order') + 1;
        });
    }


    protected static function booted()
    {
        static::addGlobalScope(new OrderScope());
    }


    public function country()
    {
        return $this->belongsTo(FeatureValue::class);
    }

    public static function getPossibleEnumValues($column)
    {
        // Create an instance of the model to be able to get the table name
        $instance = new static;

        // Pulls column string from DB
        $enumStr = \DB::select(\DB::raw('SHOW COLUMNS FROM ' . $instance->getTable() . ' WHERE Field = "' . $column . '"'))[0]->Type;

        // Parse string
        preg_match_all("/'([^']+)'/", $enumStr, $matches);

        // Return matches
        return isset($matches[1]) ? $matches[1] : [];
    }
}
