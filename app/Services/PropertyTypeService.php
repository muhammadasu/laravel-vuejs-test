<?php

namespace App\Services;

use App\Repositories\PropertyTypeRepository;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PropertyTypeService
{
    protected $repository;

    public function __construct()
    {
        $this->repository = new PropertyTypeRepository();
    }

    /**
     * Function to fetch Property list
     * @param $request
     */

    public function getAll($request)
    {
        Log::info('PropertyTypeService | getAll', $request->all());

        $data = $this->repository->getAll($request);
        if(!$data) {
            throw new Exception('Something Went Wrong in Fetching Property Type.', 500);
        }

        return $data;
    }

    /**
     * Update Or Create Through API
     */
    public function updateOrCreate($where, $request) {
        Log::info('PropertyTypeService | updateOrCreate', ['where' => $where, 'request' => $request]);

        return $this->repository->updateOrCreate($where, $request);
    }
}
