<?php

namespace App\Models;

use App\Http\Resources\PropertyType\PropertyTypeResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{
    use SoftDeletes;

    protected $table = 'properties';

    protected $appends = ['property_type_title'];

    protected $guarded = [];

    public $timestamps = true;

    public function property_types() {
        return $this->hasOne(PropertyType::class, 'id', 'property_type');
    }

    public function getPropertyTypeTitleAttribute(){
        $data = !empty($this->property_types) ? $this->property_types->title : null;
        return $this->attributes['property_type_title'] = $data;
    }
}
