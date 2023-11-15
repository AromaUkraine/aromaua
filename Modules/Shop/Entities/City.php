<?php

namespace Modules\Shop\Entities;

use App\Scopes\OrderScope;
use App\Traits\Sortable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model implements TranslatableContract
{
    // Трейт для "мягкого удаления"
    use SoftDeletes;

    // Трейт для автоматического перевода
    use Translatable;

    // Трейт для сортировки
    use Sortable;


    // Трейт для автоматическое кеширование
//     use Cachable;


    protected $fillable = [ 'order', 'active'];


    public  $translatedAttributes = [ 'name', 'publish'];


    public $timestamps = false;


    protected $dates = ['deleted_at'];


    public function getTranslationModelName(): string
    {
        return CityTranslation::class;
    }


    public function shops()
    {
        return $this->hasMany(Shop::class);
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
