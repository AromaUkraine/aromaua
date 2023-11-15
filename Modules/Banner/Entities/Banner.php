<?php

namespace Modules\Banner\Entities;


use App\Traits\Sortable;
use App\Scopes\OrderScope;
use App\Traits\QueryTrait;
use App\Traits\ThumbsTrait;
use App\Traits\WidgetTrait;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class Banner extends Model implements TranslatableContract
{
    // Трейт для "мягкого удаления"
    use SoftDeletes;

    // Трейт для автоматического перевода
    use Translatable;

    // Трейт для сортировки
    use Sortable;

    // Трейт для автоматическое кеширование
    use Cachable;

    // Трейт для виджета
    use WidgetTrait;

    // Трейт для миникартинок
    use ThumbsTrait;

    // Трейт расширения запросов
    use QueryTrait;




    public  $translatedAttributes = ['image', 'name', 'description', 'link', 'button_name', 'publish'];

    public $timestamps = false;

    protected $dates = ['deleted_at'];

    protected $fillable = ['parent_page_id', 'page_component_id', 'order', 'active', 'type'];


    public function getTranslationModelName(): string
    {
        return BannerTranslation::class;
    }


    public static function types(): \Illuminate\Support\Collection
    {
        return collect([
            ['value' => 'default', 'name' => 'cms.default']
        ]);
    }


    protected static function booted()
    {
        static::addGlobalScope(new OrderScope());
    }
}
