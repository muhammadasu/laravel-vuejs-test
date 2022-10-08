<?php

namespace App\Http\Resources\PropertyType;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PropertyTypeCollection extends ResourceCollection
{

    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $collection = [
            'data'      => PropertyTypeResource::collection($this->collection),
        ];
        
        return $collection;
    }
}
