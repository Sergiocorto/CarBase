<?php

namespace App\Http\Controllers;

use App\Models\CarModel;

class CarModelController extends Controller
{
    static public function checkAndStoreModel($modelName, $make_id)
    {
        $model = CarModel::where('name', $modelName)->first();

        if ($model) {
            $modelId = $model->id;
        } else {
            $newModel = new CarModel();
            $newModel->name = $modelName;
            $newModel->make_id = $make_id;
            $newModel->save();

            $modelId = $newModel->id;
        }
        return $modelId;
    }
}
