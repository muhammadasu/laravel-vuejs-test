<?php

namespace App\Services;

use App\Repositories\PropertyRepository;
use Exception;
use Image;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PropertyService
{
    protected $repository;

    public function __construct()
    {
        $this->repository = new PropertyRepository();
    }

    /**
     * Function to fetch Property list
     * @param $request
     */

    public function getAll($request)
    {
        Log::info('PropertyService | getAll', $request->all());

        $data = $this->repository->getAll($request);
        if(!$data) {
            throw new Exception('Something Went Wrong in Fetching Properties.', 500);
        }

        return $data;
    }

    /**
     * Function to show Property
     * @param $request
     */

    public function show($id)
    {
        Log::info('PropertyService | show', ['id' => $id]);

        $where = ['id' => $id];
        $data = $this->repository->fetch($where);
        if(!$data) {
            throw new Exception('Something Went Wrong in Fetching Property.', 500);
        }

        return $data;
    }

    /**
     * Function to store Property details
     * @param $request
     */

    public function store($request)
    {
        Log::info('PropertyService | store', $request->all());
        
        $params = $this->propertyRequest($request);
        
        if($request->hasFile('image')){
            $image = $this->storeImage($request->file('image'));
            
            $params['image'] = '/storage/images/'.$image['image'];
            $params['thumbnail'] = '/storage/images/thumbnail/'.$image['thumbnail'];

            $smallthumbnailpath = public_path('storage/images/thumbnail/'.$image['thumbnail']);
            $this->createThumbnail($smallthumbnailpath, 100, 100);
        }

        $data = $this->repository->create($params);
        if(!$data) {
            throw new Exception('Something went wrong with storing property', 500);
        }

        return $data;
    }

    /**
     * Function to update Property details
     * @param $request
     */

    public function update($request)
    {
        Log::info('PropertyService | update', $request->all());
        $params = $this->propertyRequest($request);
        unset($params['uuid']);

        if($request->hasFile('image')){
            $this->deleteImage($request->id);
            $image = $this->storeImage($request->file('image'));
            
            $params['image'] = '/storage/images/'.$image['image'];
            $params['thumbnail'] = '/storage/images/thumbnail/'.$image['thumbnail'];

            $smallthumbnailpath = public_path('storage/images/thumbnail/'.$image['thumbnail']);
            $this->createThumbnail($smallthumbnailpath, 100, 100);
        }

        $where = ['id' => $request->id];
        $data = $this->repository->update($where, $params);
        if(!$data) {
            throw new Exception('Something went wrong with storing property', 500);
        }

        return $data;
    }

    /**
     * Update Or Create Through API
     */
    public function updateOrCreate($where, $request) {
        Log::info('PropertyService | updateOrCreate', ['where' => $where, 'request' => $request]);

        return $this->repository->updateOrCreate($where, $request);
    }

    /**
     * Delete Image From Storage
     */
    public function deleteImage($id) {
        $porperty = $this->show($id);
        if(!empty($porperty)) {
            $image = public_path($porperty->image);
            $thumbnail = public_path($porperty->thumbnail);

            if(file_exists($image)){
                @unlink($image);    
            }

            if(file_exists($thumbnail)){
                @unlink($thumbnail);    
            }
        }

        return true;
    }

    /**
     * Function to destroy Article details
     * @param $id
     * @return bool
     */
    public function destroy($id)
    {
        Log::info('PropertyService | destroy', ['id' => $id]);
        
        $where = ['id' => $id];
        $this->deleteImage($id);
        return $this->repository->destroy($where);
    }

    /**
     * Store Image in storage
     */
    public function storeImage($image) {

        $filenamewithextension = $image->getClientOriginalName();
        $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
        $extension = $image->getClientOriginalExtension();
        $filenametostore = $filename.'_'.time().'.'.$extension;
        $smallthumbnail = $filename.'_small_'.time().'.'.$extension;

        $image->storeAs('public/images', $filenametostore);
        $image->storeAs('public/images/thumbnail', $smallthumbnail);

        return ['image' => $filenametostore, 'thumbnail' => $smallthumbnail];
    }

    /**
     * Create a thumbnail of specified size
     *
     * @param string $path path of thumbnail
     * @param int $width
     * @param int $height
     */
    public function createThumbnail($path, $width, $height)
    {
        $img = Image::make($path)->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->save($path);
    }

    public function propertyRequest($request) {
        return  [
            'uuid'          => Str::random(30),
            'county'        => $request->county,
            'country'       => $request->country,
            'town'          => $request->town,
            'postcode'      => $request->postcode,
            'description'   => $request->description,
            'address'       => $request->address,
            'bedrooms'      => $request->bedrooms,
            'bathrooms'     => $request->bathrooms,
            'price'         => $request->price,
            'property_type' => $request->property_type,
            'type'          => $request->type,
            'source'        => $request->source,
        ];
    }
}
