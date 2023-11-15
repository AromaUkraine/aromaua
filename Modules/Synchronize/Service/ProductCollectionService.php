<?php

namespace Modules\Synchronize\Service;

class ProductCollectionService
{
    /**
     * Создает коллескцию товаров товара из сериализованных json-данных
     *
     * @param array $data
     * @return \Illuminate\Support\Collection
     */
    /**
     * Создает коллескцию товаров товара из сериализованных json-данных
     *
     * @param array $data
     * @param boolean $test_count - включить тестовый подсчет кол-ва  номенклатур
     * @return \Illuminate\Support\Collection
     */
    public function make($data, $test_count = false )
    {
        $products_collection = collect();
        collect($data)->chunk(100)->each(function ($chunk) use (&$products_collection, $test_count) {
            $chunk->each(function ($item) use (&$products_collection, $test_count) {

                $item = $item['nomenclatures'];

                // // тестовый подсчет кол-ва цен в массиве $item['prise'] - должно быть 1 (наверное)
                // if($test_count)
                //     $this->testCountPrices($item);

                $products_collection->push($item);
            });
        });

        return $products_collection;
    }


    protected function testCountPrices($item)
    {
        $cnt = is_array($item['prise']) ? count($item['prise']) : 0;

        if ($cnt == 0 || $cnt > 1) {
            dump($item);
            dd();
        }
    }
}
