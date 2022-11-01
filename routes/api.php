<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\GpsPointController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('/flights')->group(function () {
    Route::get('/', 'FlightController@getAll');
    Route::get('/{id}', 'FlightController@getById');
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/', 'FlightController@create');
        Route::delete('/{id}', 'FlightController@destroy');
    });
});


Route::prefix('/points')->group(function () {
    Route::get('/{id}', 'GpsPointController@getById');
    Route::get('/flight/{id}', 'GpsPointController@getAllFromFlight');
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/');
    });
});
