<?php

namespace Modules\Information\Entities;

use App\Traits\Sortable;
use App\Scopes\OrderScope;
use App\Traits\QueryTrait;
use App\Traits\WidgetTrait;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class Information extends Model implements TranslatableContract
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

    // Трейт расширения запросов
    use QueryTrait;


    protected $fillable = [ 'parent_page_id', 'page_component_id', 'parent_information_id', 'type', 'icon', 'order', 'active'];


    public  $translatedAttributes = ['title', 'name', 'description', 'text', 'publish'];


    public $timestamps = false;


    protected $dates = ['deleted_at'];


    public function getTranslationModelName(): string
    {
        return InformationTranslation::class;
    }


    public function children(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Information::class,'parent_information_id','id');//->where('parent_information_id', $this->id);
    }


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

}
