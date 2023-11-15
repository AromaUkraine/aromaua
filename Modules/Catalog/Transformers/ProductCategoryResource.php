<?php

namespace Modules\Catalog\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductCategoryResource extends JsonResource
{

    public function __construct($resource)
    {
        static::$wrap = null;
        $this->resource = $resource;
    }
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'text' => $this->page->name . " ",
            'icon' => 'far fa-file',
            'state' => [
                'opened' => 1,
                'disabled' => 0, //(!$this->parent_id) ? 1 : 0,
                'selected' => 0,
            ],
            'children' => ProductCategoryResource::collection($this->children),
            'button_controls' => [
                'data-edit' => route('catalog.product_category.edit', $this->id),
            ],
            'li_attr' => ['class' => (!$this->parent_id) ? 'root' : ''],
            'a_attr' => [
                //                'data-edit'=>route('catalog.product_category.edit',$this->id),
            ]
        ];
    }
}
