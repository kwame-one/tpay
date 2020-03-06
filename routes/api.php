<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', 'Api\Auth\AuthController@login');
Route::post('register', 'Api\Auth\AuthController@register');


//-----------------USER ROUTES------------------------------//

Route::group(['prefix' => 'user', 'middleware' => 'auth:api'], function() {

    Route::post('wallet/activate', 'Api\ApiController@activateWallet');

});


//-----------------DRIVER ROUTES------------------------------//

Route::group(['prefix' => 'driver', 'middleware' => 'auth:api'], function() {

	Route::post('save', 'Api\Auth\AuthController@saveDriverDetails');
});