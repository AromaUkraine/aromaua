<?php

namespace Modules\Synchronize\Listeners\Api;

use Modules\Catalog\Entities\Product;
use Modules\Synchronize\Traits\DatabaseLogTrait;
use Modules\Synchronize\Service\ReadJsonFileService;
use Modules\Synchronize\Service\ProductCollectionService;
use Modules\Synchronize\Contracts\Product\ProductProductCategoryPrice;


class ProductProductCategoryPriceSynchronizeListener
{

    use DatabaseLogTrait;

    protected $file = 'nomenclatures.json';

    protected $file_path = '';

    public function handle($event )
    {

        // полный путь к файлу
        $this->file_path = $event->getPath($this->file);
        // json-данные из файла
        $data = app(ReadJsonFileService::class)->make($this->file_path);
        // создаем коллекцию товаров
        $collection = app()->productCollection->make($data);


        if ($collection->count()) {

            try {

                \DB::beginTransaction();

                $collection->chunk(10)->each(function ($chunk) use ($event) {

                    $chunk->each(function ($item) use ($event) {

                        app()->productCategoryPrice->save($item, $event);
                    });
                });

               \DB::commit();
            } catch (\Exception $e) {

                \DB::rollback();
                $this->logToDb($e->getMessage(), $e->getTrace());
            }
        }
    }
}
