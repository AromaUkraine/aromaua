<?php

namespace Modules\Synchronize\Listeners\Api;

use Exception;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Synchronize\Traits\DatabaseLogTrait;
use Modules\Synchronize\Entities\ProductDocument;
use Modules\Synchronize\Service\ReadJsonFileService;
use Modules\Synchronize\Service\ProductCollectionService;

class ProductDocumentSynchronizeListener
{

    use DatabaseLogTrait;

    protected $file = 'nomenclatures.json';

    protected $file_path = '';

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
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

                $collection->chunk(20)->each(function ($chunk) use ($event) {
                    $chunk->each(function ($item) use ($event) {
                        app()->productDocumentation->save($item, $event);
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