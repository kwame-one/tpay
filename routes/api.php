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

Route::post('login', 'Api\Auth\AuthController@login');
Route::post('register', 'Api\Auth\AuthController@register');


Route::group(['middleware' => 'auth:api', 'user'], function() {

    Route::get('transactions', 'Api\ApiController@getTransactions');
    Route::put('change_password', 'Api\Auth\AuthController@changePassword');
    Route::put('update_details', 'Api\ApiController@updateUserDetails');


    //-----------------USER ROUTES------------------------------//

    Route::group(['prefix' => 'user'], function () {

        Route::put('wallet/setup', 'Api\ApiController@setupWallet');
        Route::put('wallet/activate', 'Api\ApiController@activateWallet');
        Route::put('wallet/deactivate', 'Api\ApiController@deactivateWallet');
        Route::get('wallet/balance', 'Api\ApiController@checkWalletBalance');

        Route::get('expenses', 'Api\ApiController@getExpenses');

    });


    //-----------------DRIVER ROUTES------------------------------//

    Route::group(['prefix' => 'driver'], function () {

        Route::post('save', 'Api\Auth\AuthController@saveDriverDetails');
        Route::post('accept_payment','Api\ApiController@acceptPayment');
        Route::get('balance', 'Api\ApiController@getDriverAccountBalance');
    });


});



