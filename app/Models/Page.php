<?php

namespace App\Models;

use App\Helpers\ArrayHelper;


use App\Traits\JsonDataTrait;
use App\Traits\PageTrait;
use App\Traits\QueryTrait;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;

use Modules\Catalog\Traits\EntityFeatureTrait;
use Venturecraft\Revisionable\RevisionableTrait;


class Page extends Model implements TranslatableContract
{
    use Translatable,
        SoftDeletes;

    use JsonDataTrait;

    // Трейт подключения к модели страницы
    use PageTrait;

    //трейт связи харк-тик товара со страницей
    use EntityFeatureTrait;

    use QueryTrait;


    public $translatedAttributes = [
        'name',
        'slug',
        'text',
        'description',
        'h1',
        'title',
        'meta_description',
        'meta_keywords',
        'breadcrumbs',
        'anchor',
        'publish',
    ];

    public $timestamps = false;

    protected $dates = ['deleted_at'];

    protected $fillable = ['pageable_id', 'pageable_type', 'method','controller','action', 'data', 'active'];

    // configuration logger
    protected $historyLimit = 500; // устанавливает лимит записей этой модели
    protected $revisionCleanup = true; // перезаписывает старые записи после достижения лимита
    protected $revisionCreationsEnabled = true; // логирует создание записи


    /***
     * Возвращает связанную полиморфной связью запись
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function pageable()
    {
        return $this->morphTo();
    }

    /**
     * Возвращает все компоненты связаные со страницей
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function components()
    {
        return $this->hasMany(PageComponent::class);
    }

    /**
     * Возвращает все модули связаные со страницей
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function modules()
    {
        return $this->components()->where('type',PageComponent::TYPE_MODULE);
    }

    /**
     * Возвращает все виджеты связаные со страницей
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function widgets()
    {
        return $this->components()->where('type',PageComponent::TYPE_WIDGET);
    }


    /***
     * Проверка на то что искомый компонент по $alias активен
     * @param $alias
     * @return mixed
     */
    public function componentActive($alias)
    {
        return $this->components()
            ->where('alias',$alias)
            ->where('active', true)
            ->count();
    }

}
