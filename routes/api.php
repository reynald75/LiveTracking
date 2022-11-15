<?php

use App\Http\Middleware\VerifyOrganization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('organization')->group(function () {
    Route::prefix('/flights')->group(function () {
        Route::get('/{id}', 'FlightController@getById')->where('id', '[0-9]+');;
        Route::get('/active', 'FlightController@getActiveFlightPathsByOrgId');
        Route::middleware('auth:sanctum')->group(function () {
            Route::post('/', 'FlightController@create');
            Route::delete('/{id}', 'FlightController@destroy')->where('id', '[0-9]+');;
        });
    });


    Route::prefix('/points')->group(function () {
        Route::get('/', 'GpsPointController@getByAll');
        Route::get('/{id}', 'GpsPointController@getById')->where('id', '[0-9]+');;
        Route::get('/flight/{id}', 'GpsPointController@getAllFromFlight')->where('id', '[0-9]+');;
        Route::middleware('auth:sanctum')->group(function () {
            Route::post('/');
        });
    });

    Route::prefix('/pilots')->group(function () {
        Route::get('/', 'PilotInFlightController@getAll');
        Route::get('/display', 'PilotInFlightController@showAllByOrg');
    });
});
