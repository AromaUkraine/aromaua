<?php

namespace Modules\Catalog\Entities;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductFeature extends Model
{
    // Трейт "мягкого удаления"
//    use SoftDeletes;

    public $timestamps = false;

    // автоматическое кеширование
//    use Cachable;

    protected $fillable = ['productable_type', 'productable_id', 'feature_id', 'feature_value_id', 'value'];

//    protected $dates = ['deleted_at'];

    public function productable()
    {
        return $this->morphTo();
    }

    public function feature()
    {
        return $this->belongsTo(Feature::class);
    }

    public function scopeByFeatureId($query, $feature_id)
    {
        return $query->where('feature_id', $feature_id);
    }

    public function scopeByFeatureValueId($query, $feature_id)
    {
        return $query->where('feature_value_id', $feature_id);
    }


    public function feature_values()
    {
        return $this->belongsTo(FeatureValue::class,'feature_value_id');
    }
}
