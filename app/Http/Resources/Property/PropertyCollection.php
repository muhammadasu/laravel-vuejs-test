<?php

namespace App\Http\Resources\Property;

use App\Traits\ResourcePaginationTrait;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PropertyCollection extends ResourceCollection
{
    use ResourcePaginationTrait;

    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $collection = [
            'data'      => PropertyResource::collection($this->collection),
        ];
        
        $pagination = $this->getPagination();
        return array_merge($collection, $pagination);
    }
}
