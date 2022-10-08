<?php

namespace App\Console\Commands;

use App\Services\PropertyService;
use App\Services\PropertyTypeService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class GetPropertyDetails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'property:fetch_details';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get Property Details Daily Basis';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->getApiData(1);
    }

    public function getApiData($page) {
        $response = Http::get('https://trial.craig.mtcserver15.com/api/properties?api_key=3NLTTNlXsi6rBWl7nYGluOdkl2htFHug&page[number]='.$page.'&page[size]=100');
        if($response->successful()) {
            $data = $response->json();
            if(!empty($data['data'])) {
                foreach ($data['data'] as $key => $value) {
                    $request = $this->propertyRequest($value);
                    $where = ['uuid' => $request['uuid'], 'source' => $request['source']]; 
                    $property_service = new PropertyService();
                    $property_service->updateOrCreate($where, $request);

                    $property_type_service = new PropertyTypeService();
                    $property_type_service->updateOrCreate(['title' => $value['property_type']['title']], ['title' => $value['property_type']['title'], 'description' => $value['property_type']['description']]);
                    $this->info("Property UUID ---" . $request['uuid']);
                    $this->newLine(1);
                }

                $this->getApiData($page + 1);
            }
        }

        $this->info("Property Updated Successfully.");
    }

    public function propertyRequest($request) {
        return  [
            'uuid'          => $request['uuid'],
            'county'        => $request['county'],
            'country'       => $request['country'],
            'town'          => $request['town'],
            'description'   => $request['description'],
            'address'       => $request['address'],
            'image'         => $request['image_full'],
            'thumbnail'     => $request['image_thumbnail'],
            'latitude'      => $request['latitude'],
            'longitude'     => $request['longitude'],
            'bedrooms'      => $request['num_bedrooms'],
            'bathrooms'     => $request['num_bathrooms'],
            'price'         => $request['price'],
            'property_type' => $request['property_type_id'],
            'type'          => $request['type'],
            'source'        => 'api',
        ];
    }
}
