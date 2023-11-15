<?php

namespace Modules\Synchronize\Service;

class FeatureCollectionService
{

     /**
     * Создает коллекцию характеристик и их значений из сериализованных json-данных
     *
     * @param array $data
     * @return \Illuminate\Support\Collection
     */
    public function make($data)
    {
        $collection = collect();

        if (isset($data['features'])) {

            $collection = collect($data['features'])->sortBy('parent');
        }

        return $collection;
    }


}
