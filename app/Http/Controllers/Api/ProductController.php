<?php


namespace App\Http\Controllers\Api;


use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Modules\Catalog\Entities\Feature;
use Modules\Catalog\Entities\FeatureValue;
use Modules\Catalog\Entities\Product;
use App\Http\Resources\ProductResource;
use function Aws\map;

class ProductController  extends Controller
{

    public function index(Request $request)
    {
        if ($request->has('feature_values')) {
            $feature_values = [];
            foreach ($request->feature_values as $featureId => $values) {
                if ($featureId && $values) {
                    foreach ($values as $value) {
                        $feature_values[$featureId][] = $value['id'];
                    }
                }
            }
        } else {
            $feature_values = false;
        }
        if ($request->has('page')) {
            $page = $request->page;
        } else {
            $page = 1;
        }
        if ($request->has('category_id')) {
            return $this->getData($request->category_id, $feature_values, $request->search, $page);
        }

        return null;
    }

    public function features(Request $request)
    {
        $category_id = $request->category_id;

        $values = FeatureValue::query()
            ->select([
                'feature_values.id', 'feature_value_translations.name',
                'features.id as f_id', 'feature_translations.name as f_name'
            ])
            ->withTranslation()
            ->join('feature_value_translations', function ($join) {
                $join->on('feature_value_translations.feature_value_id', '=', 'feature_values.id');
                $join->where('feature_value_translations.locale', app()->getLocale());
            })
            ->join('entity_features', 'entity_features.feature_value_id', '=', 'feature_values.id')
            ->join('features', 'entity_features.feature_id', '=', 'features.id')
            ->join('feature_translations', function ($join) {
                $join->on('feature_translations.feature_id', '=', 'features.id');
                $join->where('feature_translations.locale', app()->getLocale());
            })
            ->join('products', function ($join) {
                $join->on('entity_features.entityable_id', '=', 'products.id');
                $join->where('entity_features.entityable_type', Product::class);
            })
            ->join('product_product_category_prices', function ($join) use ($category_id) {
                $join->on('product_product_category_prices.product_id', '=', 'products.id');

                if ($category_id) {
                    $join->where('product_product_category_prices.product_category_id', $category_id);
                }

            })
            ->groupBy('feature_values.id')
            ->get();

        $result = [];
        foreach ($values->toArray() as $item) {
            if (!isset($result[$item['f_id']])) {
                $result[$item['f_id']] = [
                    'id' => $item['f_id'],
                    'name' => $item['f_name']
                ];
            }
            if (!isset($result[ $item['f_id'] ]['values'][ $item['id'] ])) {
                $result[ $item['f_id'] ]['values'][ $item['id'] ] = [
                    'id' => $item['id'],
                    'name' => $item['name']
                ];
            }
        }

        return response()->json(['data' => $result]);
    }

    public function demo($category_id = 36)
    {
        // dump(app()->getLocale());
        $products = Product::where('product_category_id', $category_id)
            ->joinPage()
            ->with(['columns' => function ($query) use ($category_id) {
                $query->where('product_product_category_prices.product_category_id', $category_id);
            }])
            ->with(['documents'=>function($query){
                $query->withTranslation();
            }])
            ->get();

        return ProductResource::collection($products);
    }

    protected function getData($category_id, $feature_values, $search = null, $pageNumber = 1)
    {
        $products = Product::joinPage()
            ->join('product_product_category_prices', function ($join) use ($category_id) {
                $join->on('product_product_category_prices.product_id', '=', 'products.id')
                    ->where('product_product_category_prices.product_category_id', $category_id)
                    ->groupBy('product_product_category_prices.product_id');
            })
            ->with(['columns' => function ($query) use ($category_id) {
                $query->where('product_product_category_prices.product_category_id', $category_id);
            }])
            ->with(['documents' => function($query){
                $query->withTranslation();
            }]);
        if ($search) {
            $products->where('product_code', 'like', "%$search%")
                    ->orWhere('page_translations.name', 'like', "%$search%");
        }
        if ($feature_values) {
            foreach ($feature_values as $featureId => $values) {
                $products->whereHas('entity_features', function ($q) use($featureId, $values)  {
                    $q->where('entity_features.feature_id',$featureId)
                        ->whereIn('entity_features.feature_value_id', $values);
                });
            }
        }

        $limit = 20;
        $totalCount = $products->count();
        if ($totalCount % $limit == 0) {
            $totalPages = $totalCount / $limit;
        } else {
            $totalPages = floor($totalCount / $limit) + 1;
        }

        $offset = ($pageNumber - 1) * $limit;
        $products = $products->groupBy('products.id')
            ->orderBy('page_translations.name', 'asc')
            ->offset($offset)->limit($limit)
            ->get();

        $products = $products->map(function ($item, $key) {
            return (new ProductResource($item))->toArray($item);
        });

        return response()->json(['data' => [
            'products' => $products->toArray(),
            'totalPages' => $totalPages,
            'page' => $pageNumber
        ]]);
    }
}
