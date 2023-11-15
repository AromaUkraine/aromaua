<?php

namespace Modules\Catalog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Catalog\Entities\Product;

class FeatureModifyUpdateListener
{

    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle(object $event)
    {

        // все товары этой модификации исключая основной !!!
        $all_product_this_modify = Product::where('parent_product_id', $event->product->parent_product_id)
            ->where('id', '!=', $event->product->parent_product_id)->get();

        // находим основной
        $parent = Product::where('id', $event->product->parent_product_id)->first();

        // отвязываем их все от модификации
        $all_product_this_modify->map(function ($product) {
            $product->update(['parent_product_id' => $product->id]);
        });

        // переопределяем product на основной товар - что бы следущий SetParentForChildesListener наследников к нему
        $event->product = $parent;

    }
}
