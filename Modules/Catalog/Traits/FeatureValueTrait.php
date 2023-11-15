<?php


namespace Modules\Catalog\Traits;


trait FeatureValueTrait
{

    public function scopeValuesWithRelations( $query,  $key = null, $locale = null )
    {
        $locale = $locale ?? app()->getLocale();

        $query = self::select(
            'feature_value_translations.id as fvt_id', 'feature_value_translations.name as feature_value_name',
            'feature_values.*',
            'feature_kinds.active as feature_kind_active', 'feature_kind_translations.name as feature_kind_name', 'feature_kind_translations.publish as feature_kind_publish',
            'features.id as feature_id', 'features.active as feature_active', 'feature_translations.name as feature_name', 'feature_translations.publish as feature_publish'
        )
        ->join('feature_value_translations', function ($join)  {
            $join->on('feature_values.id','=','feature_value_translations.feature_value_id');
        })
        ->join('feature_kinds', function ($join){
            $join->on('feature_values.feature_kind_id','=','feature_kinds.id');
            $join->join('feature_kind_translations', function ($join){
                $join->on('feature_kinds.id','=','feature_kind_translations.feature_kind_id');
            });
        })
        ->join('features', function ($join){
            $join->on('features.feature_kind_id','=','feature_kinds.id');
            $join->join('feature_translations', function ($join){
                $join->on('features.id','=','feature_translations.feature_id');
            });
        })
        ->where('feature_values.active', true)
        ->where('feature_value_translations.publish', true)
        ->where('feature_value_translations.locale',$locale)
        ->where('feature_kinds.active', true)
        ->where('feature_kind_translations.publish', 1)
        ->where('feature_kind_translations.locale',$locale)
        ->where('features.active', true)
        ->where('feature_translations.publish', true)
        ->where('feature_translations.locale',$locale);

        if($key):
            $query->where('feature_kinds.key', $key);
        endif;

        return $query;
    }
}
