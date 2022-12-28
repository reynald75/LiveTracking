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
    Route::get('/pilots/create/{org_id}', 'UserController@create')->middleware('orgAdmin');

    //API routes called from web forms needing web middleware group
    Route::prefix('api')->group(function(){
        Route::post('/organization', 'OrganizationController@store')->middleware('siteAdmin');
        Route::prefix('pilot')->group(function(){
            Route::get('/delete/{id}', 'UserController@confirmDestroy')->name('pilot.confirm_destroy')->middleware('orgAdmin');
            Route::get('/edit/{id}', 'UserController@edit')->name('pilot.edit');
            Route::delete('/{id}', 'UserController@destroy')->name('pilot.destroy')->middleware('orgAdmin');
            Route::patch('/{id}', 'UserController@update')->name('pilot.update');
            Route::post('/', 'UserController@store')->middleware('orgAdmin')->name('pilot.register');
        });
    });

});
Route::get('/', 'MapController@index')->name('map');
