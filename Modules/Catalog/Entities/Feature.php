<?php

namespace Modules\Catalog\Entities;

use App\Scopes\OrderScope;
use App\Traits\QueryTrait;
use App\Traits\Sortable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Feature extends Model implements TranslatableContract
{
    // Трейт "мягкого удаления"
    use SoftDeletes;

    // Трейт автоматического перевода
    use Translatable;

    // Трейт сортировки
    use Sortable;

    use QueryTrait;

    // автоматическое кеширование
    //use Cachable;

    protected $fillable = ['feature_kind_id', 'filter', 'preview', 'page', 'order', 'active', 'code_1c'];

    public  $translatedAttributes = ['name','publish'];

    public $timestamps = false;

    protected $dates = ['deleted_at'];


    public function getTranslationModelName(): string
    {
        return FeatureTranslation::class;
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

    public function scopeInFilter($query)
    {
        return $query->whereTranslation('filter', true);
    }

//    public function kind()
//    {
//        return $this->belongsTo(FeatureKind::class, 'feature_kind_id');
//    }

    public function feature_kind()
    {
        return $this->belongsTo(FeatureKind::class, 'feature_kind_id');
    }

}
