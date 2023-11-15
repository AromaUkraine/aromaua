<?php


namespace Modules\Catalog\Traits;


use Illuminate\Http\Request;

trait FrontendFilterProductTrait
{
    public function makeFilter(Request $request, $entity_features = null)
    {
        if($entity_features) :
            $feature = [];
            if(isset($request->feature)):
                foreach ($request->feature as $key=>$values) {
                    foreach ($values as $value){
                        $feature[$key][] = $value;
                    }
                }
            endif;

            foreach ($entity_features as $entity_feature) {
                $feature[$entity_feature->feature_id][] = (int)$entity_feature->feature_value_id;
            }

            $request->request->add(['feature'=>$feature]);

            return $request->all();

        else:
            return $request->all();
        endif;
    }

    // сортировка
    public function scopeOrder($query, $filter)
    {

        if (isset($filter['price'])) :
            return $query->orderBy("price", $filter['price']);
        endif;

        return $query->orderBy("price", 'desc');
    }

    // фильтр по хар-кам
    public function scopeFilter($query, $filter)
    {
        if (isset($filter['feature'])) :

            foreach ($filter['feature'] as $feature_id => $feature_value_Ids) {

                $query->whereHas('entity_features', function ($q) use($feature_id, $feature_value_Ids)  {
                    $q->where('feature_id',$feature_id)
                        ->whereIn('feature_value_id', $feature_value_Ids);
                });
            }

        endif;

        return $query;
    }


    public function scopeNotInFilter($query, $filter)
    {
        if (isset($filter['feature'])) :

            foreach ($filter['feature'] as $feature_id => $feature_value_Ids) {

                $query->whereDoesntHave('entity_features', function ($q) use($feature_id, $feature_value_Ids)  {
                    $q->where('feature_id',$feature_id)
                        ->whereIn('feature_value_id', $feature_value_Ids);
                });
            }

        endif;

        return $query;
    }
}
