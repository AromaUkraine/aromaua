<?php

namespace Modules\Catalog\Entities;

use App\Scopes\OrderScope;
use App\Traits\Sortable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FeatureKind extends Model implements TranslatableContract
{
    // Трейт "мягкого удаления"
    use SoftDeletes;

    // Трейт автоматического перевода
    use Translatable;

    // Трейт сортировки
    use Sortable;

    // автоматическое кеширование
//    use Cachable;

    const IS_NUMBER = 'number';
    const IS_COLOR = 'color';
    const IS_BRAND = 'brand';
    const IS_COUNTRY = 'country';
    const IS_HIT = 'hit';

    protected $static_kinds = [ self::IS_NUMBER,  self::IS_COLOR, self::IS_BRAND, self::IS_COUNTRY, self::IS_HIT];

    protected $fillable = ['key','order','active'];

    public  $translatedAttributes = ['name','publish'];

    public $timestamps = false;

    protected $dates = ['deleted_at'];


    public function getTranslationModelName(): string
    {
        return FeatureKindTranslation::class;
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

    public function scopeActive($query)
    {
        return $query->where('active',true);
    }

    public function scopePublished($query)
    {
        return $query->whereTranslation('publish', true);
    }

    public function isNumber()
    {
        return ($this->key == self::IS_NUMBER);
    }

    public function feature_values()
    {
        return $this->hasMany(FeatureValue::class);
    }

    public function feature()
    {
        return $this->hasOne(Feature::class,'feature_kind_id');
    }
}
