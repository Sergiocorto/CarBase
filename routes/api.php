<?php

use App\Http\Controllers\CarController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::post('/cars', [CarController::class, 'store']);
Route::get('/cars', [CarController::class, 'show']);
Route::get('/cars/export', [CarController::class, 'export']);
Route::patch('/cars/update/{id}', [CarController::class, 'update']);
Route::delete('/cars/delete/{id}', [CarController::class, 'delete']);
Route::get('/cars/upd', function()
{
    (new \App\Http\Services\CarDataUpdater())->updateCarData();
});
