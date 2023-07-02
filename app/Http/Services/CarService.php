<?php


namespace App\Http\Services;


use App\Exports\CarsExport;
use App\Http\Controllers\CarModelController;
use App\Http\Controllers\MakeController;
use App\Http\Controllers\OwnerController;
use App\Http\Resources\CarResource;
use App\Models\Car;
use Maatwebsite\Excel\Facades\Excel;

class CarService
{
 static public function carSave($data, $carData)
 {
     try {
         $owner_id = OwnerController::checkAndStoreOwner($data['name']);
         $make_id = MakeController::checkAndStoreMake($carData['make']);
         $model_id = CarModelController::checkAndStoreModel($carData['model'], $make_id);

         $car = new Car();
         $car->owner_id = $owner_id;
         $car->registration_number = $data['registration_number'];
         $car->color = $data['color'];
         $car->vin_code = $data['vin_code'];
         $car->make_id = $make_id;
         $car->car_model_id = $model_id;
         $car->model_year = $carData['model_year'];

         $car->save();
         return true;
     } catch (\Exception $e)
     {
         return $error = [
             'code' => $e->getCode(),
             'message' => $e->getMessage()
         ];
     }
 }

 static public function showCarList($request)
 {
     $query = CarService::generateQuery($request);

     $sortBy = $request->input('sort_by', 'id');
     $sortDirection = $request->input('sort_direction', 'asc');


     $cars = $query->orderBy($sortBy, $sortDirection)->paginate(1);

     $cars->appends([
         'make_id' => $makeId ?? null,
         'car_model_id' => $carModelId ?? null,
         'model_year' => $modelYear ?? null,
         'sort_by' => $sortBy,
         'sort_direction' => $sortDirection,
     ]);

     return CarResource::collection($cars);
 }

    static public function update($data, $id)
    {
        try {
            $owner_id = OwnerController::checkAndStoreOwner($data['owner']);
            $make_id = MakeController::checkAndStoreMake($data['make']);
            $model_id = CarModelController::checkAndStoreModel($data['car_model'], $make_id);

            $car = Car::findOrFail($id);
            $car->owner_id = $owner_id;
            $car->registration_number = $data['registration_number'];
            $car->color = $data['color'];
            $car->vin_code = $data['vin_code'];
            $car->make_id = $make_id;
            $car->car_model_id = $model_id;
            $car->model_year = $data['year'];

            $car->save();
            return true;
        } catch (\Exception $e)
        {
            return $error = [
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ];
        }
    }

    static public function carDelete($id)
    {
        try {
            $car = Car::findOrFail($id);

            $car->delete();
            return true;
        } catch (\Exception $e)
        {
            return $error = [
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ];
        }
    }

    static public function exporCarsList($request)
    {
        $query = CarService::generateQuery($request);

        $sortBy = $request->input('sort_by', 'id');
        $sortDirection = $request->input('sort_direction', 'asc');


        $cars = $query->orderBy($sortBy, $sortDirection)->paginate(1);

        $carsList = CarResource::collection($cars);

        return Excel::download(new CarsExport($carsList), 'cars.xls');
    }

    static private function generateQuery($request)
    {
        $query = Car::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('registration_number', 'like', "%$search%")
                    ->orWhere('vin_code', 'like', "%$search%")
                    ->orWhereHas('owner', function ($q) use ($search) {
                        $q->where('name', 'like', "%$search%");
                    });
            });
        }

        if ($request->has('make_id')) {
            $makeId = $request->input('make_id');
            $query->where('make_id', $makeId);
        }
        if ($request->has('car_model_id')) {
            $carModelId = $request->input('car_model_id');
            $query->where('car_model_id', $carModelId);
        }
        if ($request->has('model_year')) {
            $modelYear = $request->input('model_year');
            $query->where('model_year', $modelYear);
        }

        if ($request->has('sort')) {
            $sort = $request->input('sort');
            $direction = $request->input('direction', 'asc');
            $query->orderBy($sort, $direction);
        }
        return $query;
    }
}
