<?php

namespace App\Repositories;

use App\Models\Property;

class PropertyRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = new Property();
    }

    public function getAll($request, $orderBy = [])
    {
        if (empty($orderBy)) {
            $orderBy[0] = 'id';
            $orderBy[1] = 'desc';
        }
        
        $property = $this->model->query();
        
        if ($request->has('search') && $request->filled('search')) {
            $property->where('country', 'LIKE', '%' . $request->search . '%');
            $property->orWhere('town', 'LIKE', '%' . $request->search . '%');
            $property->orWhere('postcode', 'LIKE', '%' . $request->search . '%');
        }
        
        $property = $property->orderBy($orderBy[0], $orderBy[1])->paginate($request->has('limit') ? $request->limit : 30);
        
        return $property;
    }

    public function fetch($where)
    {
        return $this->model->where($where)->first();
    }
    
    public function create($request)
    {
        return $this->model->create($request);
    }

    public function update($where, $request)
    {
        $entity = $this->model->where($where)->first();
        if (!empty($entity)) {
            $entity->update($request);
            return $entity->refresh();
        }
    }

    public function updateOrCreate($where, $request) {
        return $this->model->updateOrCreate($where, $request);
    }
    
    public function destroy($where)
    {
        return $this->model->where($where)->delete();
    }
}
