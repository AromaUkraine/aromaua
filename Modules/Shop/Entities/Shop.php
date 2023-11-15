<?php

namespace Modules\Shop\Entities;

use App\Traits\QueryTrait;
use App\Traits\Sortable;
use App\Scopes\OrderScope;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Modules\Map\Traits\MapTrait;
use Modules\Shop\Traits\ContactTrait;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;

class Shop extends Model implements TranslatableContract
{

    // Трейт для "мягкого удаления"
    use SoftDeletes;

    // Трейт для автоматического перевода
    use Translatable;

    // Трейт для автоматическое кеширование
    // use Cachable;

    // Трейт для сортировки
    use Sortable;

    // Трейт для катры
    use MapTrait;

     // Трейт для катры
     use ContactTrait;


     use QueryTrait;


    protected $fillable = [  'country_id', 'city_id', 'zipcode',  'order', 'default', 'active'];


    public  $translatedAttributes = [ 'name', 'address',  'info', 'schedule', 'publish'];


    public $timestamps = false;


    public function getTranslationModelName(): string
    {
        return ShopTranslation::class;
    }


    public function city(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
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
