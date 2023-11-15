<?php


namespace Modules\Catalog\Traits;


use Modules\Catalog\Entities\EntityFeature;

trait EntityFeatureTrait
{
    // Связь с таблицей entity_features
    public function entity_features()
    {
        return $this->morphMany(EntityFeature::class, 'entityable');
    }

    // Возвращает Id включенной в категории модификации
    public function getModifyFeatureAttribute()
    {
        $modify_feature =  $this->entity_features->where('modify_feature', true)->first();
        if($modify_feature)
            return $modify_feature->feature_id;

        return null;
    }

    // Возвращает имя включенной в категории модификации ( $feature_id )
    public function getModifyFeatureNameAttribute()
    {
        $modify_feature = $this->entity_features->where('modify_feature', true)->first();
        if($modify_feature)
            return $modify_feature->feature->name;
    }

    // Возвращает Id включенной в товаре значения модификации ( $feature_value_id )
    public function getModifyValueAttribute()
    {
        $modify_value =  $this->entity_features->where('modify_value', true)->first();
        if($modify_value)
            return $modify_value->feature_value_id;

        return null;
    }


}
