<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductWithCategoryResource extends JsonResource
{
    protected $preserveKeys = true;

    private $series_with_type;

    public function __construct($resource, $series_with_type)
    {

        $this->resource = $resource;
        $this->series_with_type = $series_with_type;

    }

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
//        return [
//            'series' => $this->getSeriesWithType(),
//            'products'=> $this->makeGroup(),
//        ];

        $series = $this->getSeriesWithType();

        $products = $this->resource->map(function ($items) {

            return [
                'name' => $this->getName($items[0]),
                'description' => $this->getDescription($items[0]),
                'slug' => $this->getSlug($items[0]),
                'product_code' => $items[0]->product_code,
                'flavor_type' => $this->getFlavorType($items[0]),
                'modify_data' => $this->setPrices($items),
            ];
        });

        return [
            'products' => $products,
            'series' => $series,
        ];
    }


    private function makeGroup()
    {

        /*
        return $this->resource->map(function ($items){

             return $items->map(function ($item) {

                 return [
                     'name' => $this->getName($item),
                     'description' => $this->getDescription($item),
                     'slug' => $this->getSlug($item),
                     'product_code' => $item->product_code,
                     'price' => $this->getPrice($item),
                     'currency' => $this->getCurrency($item),
                     'series' => $this->getSeries($item),
                     'series_name' => $this->getSeriesName($item),
                     'series_key' => $this->getSeriesKey($this->getSeriesName($item)),
                     'flavor_type' => null,
                 ];
             });

         });
        */
    }

    private function setPrices($items)
    {
        return $items->map(function ($item) {
            return [
                'price' => $this->getPrice($item),
                'currency' => $this->getCurrency($item),
                'series' => $this->getSeries($item),
                'series_name' => $this->getSeriesName($item),
                'series_key' => $this->getSeriesKey($this->getSeriesName($item)),
            ];
        });
    }


    private function getPrice($item)
    {
        return $item->price->value ?? null;
    }

    private function getCurrency($item)
    {
        return $item->price->type->currency->iso ?? null;
    }

    private function getSeries($item)
    {
        return $item->price->type->key ?? null;
    }

    private function getSeriesName($item)
    {
        return $item->sync->name ?? null;
    }

    private function getSlug($item)
    {

        $lang = '/';
        if(app()->getLocale() !== config('app.fallback_locale'))
            $lang = '/'.app()->getLocale().'/';

        return $lang.$item->slug;
    }

    private function getName($item)
    {
        return $item->name;
    }

    private function getDescription($item)
    {
        return $item->description;
    }


    private function getSeriesWithType()
    {
        return $this->series_with_type->map(function ($item) {
            return [
                'series' => $item->key,
                'series_name' => \Str::lower($item->series_name),
                'series_key' => $this->getSeriesKey($item->series_name),
            ];
        });
    }

    private function getSeriesKey($series_name)
    {
        if (strlen($series_name)) {
            $name = \Transliterate::make($series_name);
            return metaphone($name);
        }

        return null;
    }

    private function getFlavorType($item)
    {
        // временное решение, пока не сделают нормально
        return $item->getJsonData('TypeAromate');
    }


}
