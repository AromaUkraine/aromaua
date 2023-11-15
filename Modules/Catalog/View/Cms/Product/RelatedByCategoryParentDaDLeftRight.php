<?php


namespace Modules\Catalog\View\Cms\Product;


use Illuminate\View\Component;
use Modules\Catalog\Entities\Product;

class RelatedByCategoryParentDaDLeftRight extends Component
{
    public $available;

    public $used;

    public $fixed;

    public function __construct($model)
    {
        $this->available = $this->getAvailable($model);
        $this->used = $this->getUsed($model);

        // фиксируем основной товар от удаления из группы
        if($model->parent){
            $this->fixed = ['id'=>$model->parent->id];
        }elseif($model->children){
            $this->fixed = ['id'=>$model->id];
        }
    }


    public function render()
    {
        return view('catalog::cms.components.product.related-by-category-parent-dad-left-right');
    }


    private function getAvailable( $model )
    {
        $items = Product::where('product_category_id', $model->category->id)
            ->with('page')
            ->where('id', '!=', $model->id)
            ->where('parent_product_id', '!=', $model->id)
            ->where('id', '!=', $model->id)
            ->where('parent_product_id', '!=', $model->parent_product_id)
            ->get();

        return $items->filter(function ($item){
            if($item && !$item->children->count() && $item->parent_product_id == $item->id)
                return $item;
        })->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->page->name,
            ];
        });
    }

    private function getUsed($model)
    {
        $items = Product::where('product_category_id', $model->category->id)
            ->with(['page'])
            ->where('parent_product_id', $model->id)
            ->where('id', '!=', $model->id)
            ->orWhere('parent_product_id', $model->parent_product_id)
            ->get();

        return $items->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->page->name,
            ];
        });
    }
}
