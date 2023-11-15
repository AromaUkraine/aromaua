<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    protected $preserveKeys = true;

    public function __construct($resource)
    {
        $this->resource = $resource;
    }
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        return [
            'name' => $this->name,
            'description' => $this->description,
            'slug' => $this->slug,
            'product_code' => str_replace('|', "<br>", $this->product_code),
            'is_flavoring' => $this->is_flavoring ? 1 : 0,
            'type_aroma' => $this->setTypeAroma($this->data),
            'columns' => $this->setColumnsData($this->columns),
            'feature_values' => $this->setFeatureValuesData($this->entity_features)
        ];
    }


    private function setTypeAroma($data)
    {
        if(isset($data['type_aroma']))
            return __('web.'.$data['type_aroma']);

        return null;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Collection $columns
     * @return array
     */
    private function setColumnsData($columns): array
    {
        $columns_data = [];
        $columns->each(function($column, $index) use(&$columns_data){

            $columns_data[] = [
                "column_number" => $column->column_number,
                'price' => $column->translateOrDefault()->price ?? null,
                'currency' => $column->translateOrDefault()->currency ?? null,
                "series" => $column->series ? __('web.Series').' '.$column->series : '',
                "documents" => $this->countDocuments($column->column_number) ? __('web.product_documentation') : null,
                "text" => $column->text,
                "min" => $column->min,
                "max" => $column->max,
            ];
        });
        return $columns_data;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Collection $entity_features
     * @return array
     */
    private function setFeatureValuesData($entity_features): array
    {
        $data = [];
        $entity_features->each(function($item, $index) use(&$data){
            if (!isset($data[$item->feature_id])) {
                $data[$item->feature_id] = [];
            }
            if (!in_array($item->feature_value_id, $data[$item->feature_id])) {
                $data[$item->feature_id][] = $item->feature_value_id;
            }
        });
        return $data;
    }

    /**
     * Подсчитывает кол-во документов номенклатуры в определенной колонке
     *
     * @param int $column_number
     * @return int
     */
    private function countDocuments($column_number): int
    {
        $cnt = 0;

        if(!isset($this->resource->documents) || !$this->resource->documents->count())
            return $cnt;

        $this->resource->documents->where('column_number', $column_number)->each(function($item) use (&$cnt){
            if($item->name){
                ++$cnt;
            }
        });

        return $cnt;
    }
}
