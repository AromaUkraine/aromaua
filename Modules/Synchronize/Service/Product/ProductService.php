<?php

namespace Modules\Synchronize\Service\Product;


use App\Events\DestroyEntityEvent;
use Modules\Catalog\Entities\Feature;
use Modules\Catalog\Entities\FeatureValue;
use Modules\Catalog\Entities\Product;
use Modules\Catalog\Entities\ProductCategory;
use Modules\Synchronize\Traits\DatabaseLogTrait;
use Modules\Synchronize\Service\ClearDataService;
use Modules\Catalog\Events\FeatureModifyChangeParentProductEvent;
use Modules\Synchronize\Contracts\Product\Product as ProductContract;

class ProductService implements ProductContract
{
    use DatabaseLogTrait;

    public function save(array $item, object $event)
    {

        // если отсутствует код 1С категории или он пуст
        if (!isset($item['code_1c']) || !$item['code_1c']) {
            $this->logToDb("Отсутствует код 1С категории или он пуст " , $item);
            return;
        }

        // пока нет множественной связи с категориями, берем просто первую из массива
        if (is_array($item['code_1c'])) {
            $item['code_1c'] = $item['code_1c'][0];
        }
        // если не найдена категория товара
        if (!$product_category = $this->getProductCategoryByCode1C($item['code_1c'])) {
            $this->logToDb("Номенклатура с кодом " . $item['code'] . " не сохранена. Категория с code_1c : " . $item['code_1c'] . " не найдена .");
            return;
        }

        if (!$product = $this->createOrUpdateProduct($item, $product_category, $event)) {
            $this->logToDb("Товар не был создан " , $item);
            return;
        }

        $this->createOrUpdateProductPage($item, $product, $event);

        if (isset($item['features'])) {
            $this->updateProductFeatureValues($product, $item);
        }
    }


    public function delete($item)
    {
        if($product_category = $this->getProductCategoryByCode1C($item['code_1c'])){

            if($product = $this->getProductQuery($item['vendor_codegrup'])->withTrashed()->first()){

                if($product->children->count()){
                    $parent_before_id = $product->id;
                    $parent_new_id = $product->children->first()->id;
                    event(new FeatureModifyChangeParentProductEvent($parent_before_id, $parent_new_id));
                }

                // событие удаления записи, по параметру softDelete, удаления если есть связанной страницы и связанных компонентов
                event(new DestroyEntityEvent($product));
            }
        }
    }


    /**
     * Создание, обновление страницы товара
     *
     * @param array $item
     * @param object $product
     * @param object $event
     * @return void
     */
    protected function createOrUpdateProductPage($item, $product, $event)
    {

        try {

            // собираем данные для таблицы pages
            $page_data = $this->prepareDefaultPageData();

            // собираем данные для таблицы page_translations
            $translate_data = $this->makePageTranslateData($item, $product, $event);

            if ($translate_data) {
                $page_data = array_merge($page_data, $translate_data);
            }

            if (!$product->page) {
                $product->page()->create($page_data);
            } else {
                $product->page->update($page_data);
            }
        } catch (\Exception $e) {
            $this->logToDb("Страница товара не была создана или обновлена" ,$item);
        }
    }


    /**
     * Подготавливает дефолтные значения для таблицы pages
     *
     * @return array
     */
    protected function prepareDefaultPageData()
    {
        return array_merge(['active' => true], config('catalog.routes.product.web.index', []));
    }


    protected function makePageTranslateData($item, $product, $event)
    {
        $data = null;

        foreach ($item['lang'] as $locale) {

            // создаем данные для страницы !только если у товара есть название
            if (isset($locale['val']['name']) && !empty($locale['val']['name'])) {

                $lang = $event->setUkranianValidCode($locale['lang']);

                $data[$lang] = [
                    'name' => $locale['val']['name'],
                    // названия товара часто совпадают а урл должен быть уникальным, потому было принято решение добавлять в урл id товара
                    'slug' => \Transliterate::slugify($locale['val']['name'] . ' ' . $product->id),
                    'description' => $locale['val']['description'] ?? '',
                    'text' => $locale['val']['text'] ?? '',
                    'publish' => $locale['val']['publish'] ?? true
                ];
            }
        }

        if (count($data) !== 0) {
            // добалвяет копию первого попавшегося перевода как перевода для остальных языков, если перевода на языке не нашлось.
            // $data = $event->addTranslationsIfNotExist($data);
        }

        return $data;
    }



    /**
     * Создание, обновление товаров
     *
     * @param array $item
     * @param object $product_category
     * @param object $event
     * @return object|null
     */
    protected function createOrUpdateProduct(array $item, object $product_category, object $event): ?object
    {
        try {

            // нужно перенести при необходимости в одельный listener - порядок выгрузки не позволяет с точностью
            // определить загружен $parent_product или еще нет. Потому только после синхронизации это возможно
            // $parent_product = $this->findParentProduct($item, $product_category);

            $product_data = $this->makeProductData($item, $product_category);

            if (!$product_data) {
                $this->logToDb("Товар не был создан ", $item);
                return null;
            }

            $product = $this->getProductQuery($item['vendor_codegrup'])->first();

            if (!$product) {
                $product = Product::create($product_data);
                //$this->setParentProductId($product, $parent_product);
            } else {
                $product->update($product_data);
                //$this->setParentProductId($product, $parent_product);
            }

            return $product;
        } catch (\Exception $e) {
            $this->logToDb("Товар не был создан или обновлен ", $item);
        }

        return null;
    }


    protected function makeProductData($item, $product_category)
    {

        if (!isset($item['vendor_code']) || empty($item['vendor_code']) || !$item['vendor_code']) {
            $this->logToDb("Продукт из данных json не имеет или пустое поле vendor_code.", $item);
            return;
        }

        if (!isset($item['vendor_codegrup']) || empty($item['vendor_codegrup']) || !$item['vendor_codegrup']) {
            $this->logToDb("Продукт из данных json не имеет или пустое поле vendor_codegrup.", $item);
            return;
        }

        if (!isset($item['product_code']) || empty($item['product_code']) || !$item['product_code']) {
            $this->logToDb("Товар из данных json не имеет поля product_code.", $item);
            return;
        }

        //не сохраняем в product: json-data информацию о документах (можно убрать это)
        // $item = $this->removedDocumentsFronJsonDataPoroduct($item);

        return [
            'product_category_id' => $product_category->id,
            'vendor_code' => trim($item['vendor_code']),
            'product_code' => $this->addProductCode($item['product_code']),
            'group' => trim($item['vendor_codegrup']),
            'quantity_in_stock' => isset($item['quantity_in_stock']) ? trim($item['quantity_in_stock']) : 0,
            'code_1c' => trim($item['code_1c']),
            'code' =>  trim($item['code']),
            'data' => app(ClearDataService::class)->make($item, [/*'column_content',*/'type_aroma']),
            'is_flavoring' => isset($item['is_flavoring']) ? trim($item['is_flavoring']) : 0
        ];
    }


    protected function addProductCode($product_code)
    {
        $result = '';
        if (is_array($product_code)) {
            foreach ($product_code as $code) {
                $result .= trim($code) . "|";
            }
            return rtrim($result, '|');
        } else {
            return $product_code;
        }
    }

    /**
     *  Поиск категори по коду в 1С
     *
     * @param string $code_1c
     * @return object|null
     */
    protected function getProductCategoryByCode1C($code_1c)
    {
        return ProductCategory::where('code_1c', $code_1c)->first();
    }

    /**
     * Поиск номенклатуры по артикулу
     *
     * @param string $group
     * @return ?object
     */
    protected function getProductQuery($group)
    {
        return Product::where('group', trim($group));
    }

    /**
     * Не сохраняем в product: json-data информацию о документах
     *
     * @param array $item
     * @return array
     */
    private function removedDocumentsFronJsonDataPoroduct(array $item) : array
    {
        if(isset($item['column_content']) ){

            foreach($item['column_content'] as $key=>$values){

                foreach($values as $index=>$value){
                    if(isset($value['documentation'])) {

                        unset($item['column_content'][$key][$index]['documentation']);
                    }
                }
            }
        }

        return $item;
    }

    /**
     * Создание, обновление характеристик товара
     *
     * @param array $item
     * @param object $product
     * @return object|null
     */
    private function updateProductFeatureValues($product, array $item)
    {
        foreach ($item['features'] as $feature) {
            if (count($feature['values'])) {
                $featureItem = Feature::where('code_1c', trim($feature['id']))->first();
                if (!$featureItem) {
                    $this->logToDb('Not found feature', $feature);
                    continue;
                }
                foreach ($feature['values'] as $value) {
                    $featureValue = FeatureValue::where('code_1c', trim($value))->first();
                    if (!$featureValue) {
                        $this->logToDb("Not found feature value '$value'", $feature);
                        continue;
                    }
                    $product->entity_features()->create([
                        'feature_kind_id' => $featureItem->feature_kind_id,
                        'feature_id' => (int)$featureItem->id,
                        'feature_value_id' => (int)$featureValue->id
                    ]);
                }
            }
        }
    }
}
