<?php

namespace Modules\Synchronize\Service;

class CategoryCollectionService
{

     /**
     * Создает коллекцию категорий товара из сериализованных json-данных
     *
     * @param array $data
     * @return \Illuminate\Support\Collection
     */
    public function make($data)
    {
        $collection = collect();

        // программист присылает категории обернутые ключом categories в массиве
        if (isset($data['categories'])) {

            $collection = collect($data['categories'])->sortBy('parent');
        }

        return $collection;
    }


}
