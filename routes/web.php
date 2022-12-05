<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\MapController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes(['register' => false]);

Route::middleware('auth:sanctum')->group(function(){
    Route::prefix('admin')->group(function () {
        Route::get('/site', 'OrganizationController@showAll')->name('site_administration')->middleware('siteAdmin');
        Route::get('/organization', 'OrganizationController@show')->name('org_administration')->middleware('orgAdmin');
    });

    Route::get('/profile', 'UserController@show')->name('profile');

    Route::get('/organization/create', 'OrganizationController@create')->middleware('siteAdmin');
    Route::get('/pilots/create', 'UserController@create')->middleware('orgAdmin');

    //API routes called from web forms needing web middleware group
    Route::prefix('api')->group(function(){
        Route::post('/organization', 'OrganizationController@store')->middleware('siteAdmin');
        Route::prefix('pilot')->group(function(){
            Route::post('/', 'AuthController@createUser')->middleware('orgAdmin');
            Route::delete('/{id}', 'UserController@destroy')->name('pilot.destroy')/*->middleware('orgAdmin')*/;
            Route::get('/edit/{id}', 'UserController@edit');
        });
    });

});

Route::get('/', 'MapController@index');
