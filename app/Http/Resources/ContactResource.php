<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Shop\Entities\EntityContact;

class ContactResource extends JsonResource
{
    public function __construct($resource)
    {
        $this->resource = $resource;
    }

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'image_path' => asset('images/web/svg/symbol/sprite.svg'),
            'country_id' => $this->country_id,
            'name' => $this->name,
            'address' => $this->address,
            'info' => $this->info,
            'contacts' => $this->getContact(),
            'map' => $this->getMap(),
        ];
    }

    private function getContact()
    {

        return $this->resource->contacts->map(function ($item) {

            if ($item->type === EntityContact::TYPE_PHONE) {
                $clear_value = "tel:" . preg_replace('~\D~', '', $item->value);
            } elseif ($item->type === EntityContact::TYPE_EMAIL) {
                $clear_value = "mailto:" . $item->value;
            } else {
                if (substr($item->value, 0, 4) == 'http') {
                    $clear_value = $item->value;
                } else {
                    $clear_value = "https://" . $item->value;
                }
            }
            return [
                'id' => $item->id,
                'value' => $item->value,
                'clear_value' => $clear_value,
                'type' => $item->type,
                'description' => $item->description
            ];
        });
    }

    private function getMap()
    {

        if( $this->resource->map && $this->resource->map->lat && $this->resource->map->lng){

            return [
                'infoWindow' => false,
                'markers' => [
                    [
                        'lat' => $this->resource->map->lat,
                        'lng' => $this->resource->map->lng,
                    ],
                ],
            ];
        }
        return null;
    }
}
