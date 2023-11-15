<?php

namespace Modules\Synchronize\Service\Product;

use Modules\Catalog\Entities\Product;
use Modules\Catalog\Entities\ProductCategory;
use Modules\Synchronize\Entities\ProductProductCategoryPrice;
use Modules\Synchronize\Contracts\Product\ProductProductCategoryPrice as ProductProductCategoryPriceContract;

class ProductProductCategoryPriceService implements ProductProductCategoryPriceContract
{

    public function save($item, $event)
    {

        if (!isset($item['code_1c']) || !$item['code_1c'])
            return;
        // пока нет множественной связи с категориями, берем просто первую из массива
        if (is_array($item['code_1c'])) {
            $item['code_1c'] = $item['code_1c'][0];
        }

        $product = $event->findProduct($item['vendor_codegrup']);

        if (!$product)
            return;

        $this->createOrUpdateProductProductCategorePrice($product, $event, $item);
    }




    private function createOrUpdateProductProductCategorePrice($product, $event, $item)
    {

        $cnt_column_content = is_array($item['column_content']) ? count($item['column_content']) : 0;

        $cnt_price_list = is_array($item['price_list']) ? count($item['price_list']) : 0;

        if ($cnt_column_content) {
            $this->createOrUpdateByColumnContent($item, $product);
        } elseif ($cnt_price_list) {
            $this->createOrUpdateByPriceList($item, $product);
        }

    }


    private function createOrUpdateByColumnContent($item, $product)
    {
        $categories = [];
        foreach ($item['column_content'] as $lang => $columns) {

            foreach ($columns as $column) {

                if (empty($column['code_1c'])) {
                    $column['code_1c'] = $item['code_1c'];
                }
                if (!isset($categories[$column['code_1c']])) {
                    $categories[$column['code_1c']] = $this->getProductCategoryByCode1C($column['code_1c']);
                }

                $column['series'] = $column['series'] ?? $item['series'] ?? '';
                $record = $this->findRecord($product, $column['series'], $categories[$column['code_1c']], $column['column_number']);

                $data = $this->getData($item, $product, $categories[$column['code_1c']]);
                $data['column_number'] = $column['column_number'] ?? 0;
                $data['series'] = $column['series'];
                $data[$lang] = [];
                $data[$lang]['column_name'] = $this->getColumnNameInCategoryData($data['column_number'], $lang, $product, $categories[$column['code_1c']]);
                $data[$lang]['text'] = $column['text'];
                $data[$lang]['price'] = $column['price'];
                $data[$lang]['currency'] = $column['currency'];

                if (!$record) {
                    ProductProductCategoryPrice::create($data);
                } else {
                    $record->update($data);
                }
            }
        }
    }


    private function createOrUpdateByPriceList($item, $product)
    {
        $record = $this->findRecord($product, $item['series']);

        $data = $this->getData($item, $product);
        $data['price_list'] = $item['price_list'];

        if (!$record) {
            ProductProductCategoryPrice::create($data);
        } else {
            $record->update($data);
        }
    }

    /**
     * @param array $item
     *
     * @param Product $product
     * @param ProductCategory $category
     * @return array
     */
    private function getData(array $item,  Product $product, $category = null): array
    {
        if (!$category)
            $category = $product->category;
        return [
            'product_category_id' => $category->id,
            'product_id' => $product->id,
            'min' => $item['min'] ?? 0,
            'max' => $item['max'] ?? 0,
            'active' => $item['active'] ?? true,
        ];
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
     * @param int $column_number
     * @param string $lang
     * @param Product $product
     * @return string
     */
    private function getColumnNameInCategoryData(int $column_number, string $lang, Product $product, $category = null): string
    {
        $name = '';

        if (!$category)
            $category = $product->category;//ProductCategory::where('id', $product->product_category_id)->first();

        if($category) {

            if(isset($category->data['columns']) && $column_number){
                $name = collect($category->data['columns'])->where('serial_number', $column_number)->first()['name'] ?? '';
            }
        }

        return $name;
    }


    private function findRecord($product, $series, $category = null, $column_number = null)
    {
        if (!$category) {
            $category = $product->category;
        }
        $query = ProductProductCategoryPrice::where('product_category_id', $category->id)
            ->where('product_id', $product->id)
            ->where('series', $series);

        if ($column_number)
            $query->where('column_number', $column_number);

        return $query->first();
    }
}
