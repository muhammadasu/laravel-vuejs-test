<?php

namespace App\Http\Resources\Property;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PropertyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'                    => $this->id,
            'county'                => $this->county,
            'country'               => $this->country,
            'town'                  => $this->town,
            'postcode'              => $this->postcode,
            'description'           => $this->description,
            'address'               => $this->address,
            'image'                 => $this->image,
            'thumbnail'             => $this->thumbnail,
            'latitude'              => $this->latitude,
            'longitude'             => $this->longitude,
            'bedrooms'              => $this->bedrooms,
            'bathrooms'             => $this->bathrooms,
            'price'                 => $this->price,
            'property_type'         => $this->property_type,
            'property_type_title'   => $this->property_type_title,
            'type'                  => $this->type,
            'source'                => $this->source,
        ];
    }
}
