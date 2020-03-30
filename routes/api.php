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
Route::put('password/change', 'Api\Auth\AuthController@changePassword')->middleware('auth:api');


//-----------------USER ROUTES------------------------------//

Route::group(['prefix' => 'user', 'middleware' => 'auth:api', 'user'], function() {

    Route::put('wallet/setup', 'Api\ApiController@setupWallet');
    Route::put('wallet/activate', 'Api\ApiController@activateWallet');
    Route::put('wallet/deactivate', 'Api\ApiController@deactivateWallet');
    Route::get('wallet/balance', 'Api\ApiController@checkWalletBalance');
    

});


//-----------------DRIVER ROUTES------------------------------//

Route::group(['prefix' => 'driver', 'middleware' => 'auth:api', 'user'], function() {

    Route::post('save', 'Api\Auth\AuthController@saveDriverDetails');
    
    Route::put('password/change', 'Api\ApiController@changePassword');
});