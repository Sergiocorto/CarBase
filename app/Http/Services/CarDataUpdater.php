<?php


namespace App\Http\Services;


use App\Models\CarModel;
use App\Models\Make;
use GuzzleHttp\Client;
use function PHPUnit\Framework\isEmpty;

class CarDataUpdater
{
    public function updateCarData()
    {
        $makes = $this->fetchMakeData();

        foreach ($makes as $make) {
            $makeInDb = Make::where('name', $make['Make_Name'])->get();
            if($makeInDb->isEmpty())
                Make::create([
                    'name' => $make['Make_Name'],
                ]);
            $carModels = $this->fetchModelData($make['Make_ID']);
            foreach ($carModels as $model) {
                $modelInDb = CarModel::where('name', $model['Model_Name'])->get();
                if($modelInDb->isEmpty())
                    CarModel::create([
                        'name' => $model['Model_Name'],
                    ]);
            }
        }
    }

    protected function fetchMakeData()
    {
        $client = new Client();
        $response = $client->get('https://vpic.nhtsa.dot.gov/api/vehicles/getallmakes?format=json');
        $response = json_decode($response->getBody(), true);
        $results = $response['Results'];
        return $results;
    }

    protected function fetchModelData($makeId)
    {
        $client = new Client();
        $response = $client->get("https://vpic.nhtsa.dot.gov/api/vehicles/getmodelsformakeid/$makeId?format=json");
        $response = json_decode($response->getBody(), true);
        $results = $response['Results'];
        return $results;
    }
}
