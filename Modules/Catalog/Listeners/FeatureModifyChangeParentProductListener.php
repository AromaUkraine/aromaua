<?php

namespace Modules\Catalog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Catalog\Entities\Product;

class FeatureModifyChangeParentProductListener
{


    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle(object $event)
    {
        // вначале находим все товары этой модификации
        $related = Product::withTrashed()->where('parent_product_id', $event->parent_before_id)->get();

        // находим новый основной товар
        $parent = $related->where('id', $event->parent_new_id)->first();
        $data = ['parent_product_id'=>$parent->id];
        $parent->update($data);


        $event->product = $parent;

        // все остальные будут наследниками
        $event->childes = $related->where('id', '!=', $event->parent_new_id);
    }
}
