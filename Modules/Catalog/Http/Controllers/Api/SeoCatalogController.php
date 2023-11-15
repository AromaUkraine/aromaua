<?php


namespace Modules\Catalog\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Services\ModelService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Modules\Catalog\Entities\EntityFeature;
use Modules\Catalog\Entities\Feature;
use Modules\Catalog\Entities\FeatureKind;
use Modules\Catalog\Entities\ProductCategory;
use Modules\Catalog\Entities\SeoCatalog;

class SeoCatalogController extends Controller
{

    public $features;


    public function features(Request $request)
    {
        $entity_id = $request->entity_id ?? null;
        $product_category_id = $request->product_category_id ?? null;

        if($entity_id) :

            if($product_category_id):

                $features = ProductCategory::with(['entity_features'=>function($query){
                    $query->with(['feature'=>function($query){
                        $query->with(['feature_kind'=>function($query){
                            //@todo пока числовые значения не используем !!!
                            $query->where('key','!=', FeatureKind::IS_NUMBER);

                            $query->with('feature_values');
                        }]);
                    }]);
                }])->where('id', $product_category_id)->first()->entity_features->map(function ($item){
                    return $item->feature;
                });

            else:
                // получаем все хар-ки исключая числовые
                $features = Feature::whereHas('feature_kind',function($query){
                    //@todo пока числовые значения не используем !!!
                    $query->where('key','!=', FeatureKind::IS_NUMBER);
                })->get();

            endif;

            return View::make("catalog::cms.components.seo_catalog.feature", compact('features'))->render();
           // dump([$request->all(), $features]);

        endif;

        /*$features = null;
        $entity_id = $request->entity_id ?? null;
        $product_category_id = $request->product_category_id ?? null;

        $seo_catalog = SeoCatalog::find($entity_id);

        // если к записи еще не привязана категория товара
        if(!$seo_catalog->product_category_id) :

            $category = ProductCategory::find($product_category_id);
            $features = $category->entity_features
                    ->map(function ($entity_feature) {
                return $entity_feature->feature;
            })->sortBy('order')->values()->all();

        else :

            $features = $seo_catalog->category->entity_features
                ->map(function ($entity_feature) {
                    return $entity_feature->feature;
                })->sortBy('order')->values()->all();
        endif;*/

//        dump($request->all());













        /*
        $features = null;
        $entity_id = $request->entity_id ?? null;
        $product_category_id = $request->product_category_id ?? null;

        $seo_catalog = SeoCatalog::find($entity_id);

        // если к записи еще не привязана категория товара
        if(!$seo_catalog->product_category_id) :

            $category = ProductCategory::find($product_category_id);
            $features = $category->entity_features
                    ->map(function ($entity_feature) {
                return $entity_feature->feature;
            })->sortBy('order')->values()->all();

        else :

            $features = $seo_catalog->category->entity_features
                ->map(function ($entity_feature) {
                    return $entity_feature->feature;
                })->sortBy('order')->values()->all();
        endif;




        /*
        $features = null;
        $except = null;

        $entity_id = $request->entity_id;
        $seo = SeoCatalog::find($entity_id);


        // берем хар-ки привязаной категории
        if($seo->product_category_id) :
            $features = $seo->category->entity_features
                ->map(function ($entity_feature) {
                    return $entity_feature->feature;
            })->sortBy('order')->values()->all();
        else:

            $query = Feature::whereHas('feature_kind',function($query){
                    //@todo пока числовые значения не используем !!!
                    $query->where('key','!=', FeatureKind::IS_NUMBER);
                });

            $features = $query->get();
        endif;*/



       // return View::make("catalog::cms.components.seo_catalog.feature", compact('features'))->render();
    }

    public function feature_values(Request $request)
    {

        $feature_values = null;
        $feature_id = null;

        if(isset($request->feature_id)):

            $feature_id = $request->feature_id;
            $feature = Feature::with(['feature_kind' => function($query){
                $query->with('feature_values');
            }])->find($request->feature_id);

            if($feature):
                $feature_values = $feature->feature_kind->feature_values;
            endif;

        endif;

        return View::make("catalog::cms.components.seo_catalog.feature_values", compact('feature_id','feature_values'))->render();
    }
}
