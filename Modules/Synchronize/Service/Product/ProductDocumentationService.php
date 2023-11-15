<?php

namespace Modules\Synchronize\Service\Product;

use App\Events\DestroyEntityEvent;
use Modules\Catalog\Entities\Product;
use Modules\Synchronize\Traits\DatabaseLogTrait;
use Modules\Synchronize\Entities\ProductDocument;
use Modules\Synchronize\Contracts\Product\ProductDocumentation;


/**
 * Class ProductDocumentationService
 *
 * @package namespace Modules\Synchronize\Service\Product
 */
class ProductDocumentationService implements ProductDocumentation
{
    use DatabaseLogTrait;

    public function save(array $item, object $event)
    {
        // если запись существует
        if ($product = $event->findProduct($item['vendor_codegrup'])) :

            if (isset($item['column_content'])) :

                $dataDocuments = [];

                foreach ($item['column_content'] as $locale => $contents) {

                    $locale = $event->setUkranianValidCode($locale);

                    foreach ($contents as $content) {

                        // иесли нет column_number или он не определен
                        if (!isset($content['column_number']) || !$content['column_number']) :
                            $this->logToDb("Номер колонки к которой принадлежит документация не указан или не существует.", $content);
                            return;
                        endif;

                        $cnt = is_array($content['documentation']) ? count($content['documentation']) : 0;

                        if ($cnt) {
                            foreach ($content['documentation'] as $itemDoc) {

                                $number = (int) $itemDoc['number'];

                                if (isset($dataDocuments[$content['column_number']][$number])) {
                                    $dataDocuments[$content['column_number']][$number][$locale] = [
                                        'name' => $itemDoc['name'],
                                        'href' => $itemDoc['href'],
                                        'date' => $itemDoc['data'],
                                    ];
                                } else {
                                    $dataDocuments[$content['column_number']][$number] = [
                                        $locale => [
                                            'name' => $itemDoc['name'],
                                            'href' => $itemDoc['href'],
                                            'date' => $itemDoc['data'],
                                        ],
                                        'column_number' => $content['column_number'],
                                        'serial_number' => $number
                                    ];
                                    if (isset($itemDoc['delete'])) {
                                        $dataDocuments[$content['column_number']][$number]['delete'] = $itemDoc['delete'];
                                    }
                                }
                            }
                        }

                    }
                }

                $this->createOrUpdateProductDocument($product, $dataDocuments, $event);

            endif;

        endif;
    }

    private function createOrUpdateProductDocument(Product $product, $dataDocuments, $event)
    {
        try {

            foreach ($dataDocuments as $columnNumber => $documents) {

                foreach ($documents as $number => $dataDocument) {

                    $product_document = ProductDocument::where('column_number', $columnNumber)
                        ->where('product_id', $product->id)
                        ->where('serial_number', $number)
                        ->first();

                    if (isset($dataDocument['delete']) && $dataDocument['delete'] == 1) {
                        if ($product_document) {
                            event(new DestroyEntityEvent($product_document));
                        }
                    } else {

                        // publish??

                        if (!$product_document) :
                            $dataDocument['product_id'] = $product->id;
                            $product_document = ProductDocument::create($dataDocument);
                        else :
                            $product_document->update($dataDocument);
                        endif;
                    }
                }

            }

        } catch (\Exception $e) {
            $this->logToDb("Документация по продукту не создалась или не обновилась.", $dataDocuments);
        }
    }

    private function createOrUpdateProductDocumentOld(Product $product, string $locale, int $column_number, $documents, $event)
    {
        $column_number = (int)$column_number;

        try {

            foreach ($documents as $document) {

                $product_document = ProductDocument::where('column_number', $column_number)
                    ->where('product_id', $product->id)
                    ->whereTranslation('href', $document['href'], $locale)
                    ->whereTranslation('name', $document['name'], $locale)
                    ->first();

                if (isset($document['delete']) && $document['delete'] == 1) {
                    if ($product_document) {
                        event(new DestroyEntityEvent($product_document));
                    }
                } else {

                    $data = array_merge(
                        [
                            'product_id' => $product->id,
                            'column_number' => $column_number,
                            'serial_number' => (int) $document['number'],
                            'active' => $document['active'] ?? true
                        ],
                        [
                            $locale =>
                            [
                                'name' => $document['name'] ?? '',
                                'href' => $document['href'] ?? '',
                                'date' => $document['data'] ?? '', // программист назвал поле data
                                'publish' => $document['publish'] ?? true
                            ]
                        ]
                    );

                    if (!$product_document) :
                        $product_document = ProductDocument::create($data);
                    else :
                        $product_document->update($data);
                    endif;
                }
            }
        } catch (\Exception $e) {
            $this->logToDb("Документация по продукту не создалась или не обновидась.", $documents);
        }
    }


    /**
     *
     * Находим в разделе column_content - документы по ключу documentation
     * и формируем массив документов с учетом номера колонки и языка
     *
     * @param string $lang - язык колонки
     * @param array $content - содержание колонки
     * @param array $item - массив данных номенклатуры
     * @param object $event - объект
     * @return array|null
     */
    private function getDocuments(array $content,  array $item, object $event): ?array
    {
        $data = null;

        if (isset($content['documentation'])) :

            $cnt = is_array($content['documentation']) ? count($content['documentation']) : 0;

            if ($cnt) :

                foreach ($content['documentation'] as $document) {
                    $data[] = $document;
                }

            endif;

        endif;

        return $data;
    }
}
