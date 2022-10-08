<?php

namespace App\Repositories;

use App\Models\PropertyType;

class PropertyTypeRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = new PropertyType();
    }

    public function getAll($request)
    {
        return $this->model->get();
    }

    public function updateOrCreate($where, $request) {
        return $this->model->updateOrCreate($where, $request);
    }
}
