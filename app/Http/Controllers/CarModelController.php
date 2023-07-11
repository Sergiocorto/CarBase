<?php

namespace App\Http\Controllers;


use App\Models\CarModel;
use Illuminate\Support\Facades\Response;

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

    static public function exportCarModels()
    {
        $query = CarModel::query();

        $fileName = 'models.xls';

        $headers = [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="'.$fileName.'"',
        ];

        set_time_limit(300);

        return Response::stream(function () use ($query) {
            $handle = fopen('php://output', 'w');

            // Записываем заголовки в поток
            fputcsv($handle, ['ID', 'Model Name', 'make_id'], "\t");

            $query->chunk(100000, function ($models) use ($handle) {
                foreach ($models as $model) {
                    // Записываем данные каждой модели в поток
                    fputcsv($handle, [$model->id, $model->name], "\t");
                }
            });

            fclose($handle);
        }, 200, $headers);

        //return Excel::download(new ModelsExport($models), 'models.xls');


    }
}
