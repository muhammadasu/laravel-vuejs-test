<?php

namespace App\Http\Resources\PropertyType;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PropertyTypeResource extends JsonResource
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
            'value'        => $this->id,
            'text'         => $this->title
        ];
    }
}
