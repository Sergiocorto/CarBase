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

        foreach ($makes as $make)
        {
            $makeInDb = Make::where('name', $make['Make_Name'])->first();
            if(!$makeInDb)
            {
                $newMake = new Make();
                $newMake->name = $make['Make_Name'];
                $newMake->save();
                $makeId = $newMake->id;
            }
            else {
                $makeId = $makeInDb->id;
            }

            $carModels = $this->fetchModelData($make['Make_ID']);
    
            if(sizeof($carModels) > 0)
            {
                foreach ($carModels as $model)
                {
                    $modelInDb = CarModel::where('name', $model['Model_Name'])->first();
                    if (!$modelInDb){
                        $newModel = new CarModel();
                        $newModel->name = $model['Model_Name'];
                        $newModel->make_id = $makeId;
                        $newModel->save();
                    }
                }
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
