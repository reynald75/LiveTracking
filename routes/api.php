<?php

use App\Http\Controllers\UpdateController;
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
        Route::get('/active', 'FlightController@getActiveFlightPathsByOrgId');
    });

    Route::prefix('/pilots/display')->group(function () {
        Route::get('/bubbles', 'PilotInFlightController@showAllBubblesByOrgId');
        Route::get('/menu', 'PilotInFlightController@showAllMenuEntriesByOrgId');
    });
});

Route::prefix('updates')->group(function(){
    Route::get('/set', 'UpdateController@setUpdate');
    Route::get('/request', 'MessengerController@callFeeds');
});