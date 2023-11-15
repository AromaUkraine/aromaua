<?php

namespace Modules\Catalog\Entities;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Currency extends Model implements TranslatableContract
{
    use Translatable;

    // Трейт "мягкого удаления"
    use SoftDeletes;

    // автоматическое кеширование
//    use Cachable;

    const BASE_CURRENCY_TYPE = 'base';
    const REMOTE_CURRENCY_TYPE = 'remote';
    const CURRENCY_DEFAULT = "EUR";


    protected $fillable = ['iso','symbol','html_code','unicode', 'active','type'];

    public $timestamps = false;

    protected $dates = ['deleted_at'];

    public $translatedAttributes = ['name', 'short_name'];

    public function getTranslationModelName(): string
    {
        return CurrencyTranslation::class;
    }

    public function price_types()
    {
        $this->hasMany(PriceType::class);
    }

    public function scopeActive($query)
    {
        return $query->where('active',true);
    }

    public function scopeBase($query)
    {
        return $query->where('type',self::BASE_CURRENCY_TYPE);
    }
}
