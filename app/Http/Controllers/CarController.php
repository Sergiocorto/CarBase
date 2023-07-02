<?php

namespace App\Http\Controllers;

use App\Http\Requests\CarStoreRequest;
use App\Http\Requests\CarUpdateRequest;
use App\Http\Services\CarService;
use App\Http\Services\VinCodeDecoder;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function store(CarStoreRequest $request)
    {
        $data = $request->validated();
        $carData = VinCodeDecoder::vinCodeDecode($data['vin_code']);

        $result = CarService::carSave($data, $carData);

        if(isset($result['code'])) return response()->json(['message' => $result['message']], 500);

        return response()->json(['message' => 'Car save successful'], 201);

    }

    public function show(Request $request)
    {
        return CarService::showCarList($request);
    }

    public function update(CarUpdateRequest $request, $id)
    {
        $data = $request->validated();

        $result = CarService::update($data, $id);

        if(isset($result['code'])) return response()->json(['message' => $result['message']], 500);

        return response()->json(['message' => 'Car update successful'], 201);
    }

    public function delete($id)
    {
        $result = CarService::carDelete($id);

        if(isset($result['code'])) return response()->json(['message' => $result['message']], 500);

        return response()->json(['message' => 'Car delete successful'], 201);
    }

    public function export(Request $request)
    {
        return CarService::exporCarsList($request);
    }
}
