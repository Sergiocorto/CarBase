<?php

use App\Http\Controllers\CarController;
use App\Http\Controllers\MakeController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\CarModelController;

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

Route::get('/makes/{find}', [MakeController::class, 'autocomplete']);

Route::get('/models/export', [CarModelController::class, 'exportCarModels']);
