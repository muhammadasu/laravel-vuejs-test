<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Property\storePropertyRequest;
use App\Http\Requests\Property\updatePropertyRequest;
use App\Http\Resources\Property\PropertyCollection;
use App\Http\Resources\Property\PropertyResource;
use App\Http\Resources\PropertyType\PropertyTypeCollection;
use App\Services\PropertyService;
use App\Services\PropertyTypeService;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function __construct()
    {
        $this->property_service = new PropertyService();
        $this->property_type_service = new PropertyTypeService();
    }

    public function index(Request $request)
    {
        $data = $this->property_service->getAll($request);

        return ApiResponse::successResponse('Fetch Properties Successfully.', new PropertyCollection($data));
    }

    public function store(storePropertyRequest $request) {
        $data = $this->property_service->store($request);

        return ApiResponse::successResponse('Add Property Successfully.', new PropertyResource($data));
    }

    public function show($id) {
        $data = $this->property_service->show($id);

        return ApiResponse::successResponse('Fetch Property Successfully.', new PropertyResource($data));
    }

    public function update(updatePropertyRequest $request, $id) {
        $request['id'] = $id;
        $data = $this->property_service->update($request);

        return ApiResponse::successResponse('Update Property Successfully.', new PropertyResource($data));
    }

    public function destroy($id) {
        $this->property_service->destroy($id);

        return ApiResponse::successResponse('Delete Property Successfully.');
    }

    public function getPropertyTypes(Request $request)
    {
        $data = $this->property_type_service->getAll($request);

        return ApiResponse::successResponse('Fetch Property Types Successfully.', new PropertyTypeCollection($data));
    }
}
