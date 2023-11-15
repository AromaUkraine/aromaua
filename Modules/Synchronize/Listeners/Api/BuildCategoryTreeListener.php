<?php

namespace Modules\Synchronize\Listeners\Api;

use Exception;
use Modules\Catalog\Entities\ProductCategory;

class BuildCategoryTreeListener
{

    protected $rootIds;

    public function handle($event)
    {

        $model = new ProductCategory();

        $event->product_categories->each(function ($product_category) use ($model) {

            if ($product_category->parent_code_1c != 0) {
                $this->saveAsChild($product_category, $model);
            }
        });
    }

    /**
     * Добавление вложенных категории если категория отсутствует у родительской категории
     *
     * @param object $product_category
     * @param object $model
     * @return void
     */
    protected function saveAsChild($product_category, $model)
    {
        $parent = $this->findParent($product_category->parent_code_1c);
        $childs = $model->getChildren($parent);

        if (!$childs->contains('id', $product_category->id)) {
            $parent->appendNode($product_category);
        }
    }




    /**
     * Поиск в коллекции родительской категории
     *
     * @param object $event
     * @param string $parent_code_1c
     * @return object
     */
    protected function findParent($parent_code_1c)
    {
        return ProductCategory::where('code_1c', $parent_code_1c)->first();
    }
}
