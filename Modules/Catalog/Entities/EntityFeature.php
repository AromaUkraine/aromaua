<?php

namespace Modules\Catalog\Entities;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;



class EntityFeature extends Model
{

    // автоматическое кеширование
//    use Cachable;

    public $timestamps = false;

    protected $fillable = [
        'entityable_type',
        'entityable_id',
        'feature_id',
        'feature_kind_id',
        'feature_value_id',
        'value',
        'value_from',
        'value_to',
        'modify_feature',
        'modify_value'
    ];



    public function entityable()
    {
        return $this->morphTo();
    }

    public function feature()
    {
        return $this->belongsTo(Feature::class);
    }

    public function feature_kind()
    {
        return $this->belongsTo(FeatureKind::class);
    }

    public function feature_value()
    {
        return $this->belongsTo(FeatureValue::class)->where('feature_kind_id', $this->feature_kind_id);
    }


}
