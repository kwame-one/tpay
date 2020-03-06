<?php

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

Route::get('/', function () {
    // return view('welcome');
    return redirect('/home');
});

Auth::routes(['register' => false]);

Route::group(['middleware' => ['auth', 'admin']], function() {
	Route::get('/home', 'HomeController@index')->name('home');

	
	Route::group(['prefix' => 'wallets'], function() {
		Route::get('all', 'WalletController@index')->name('wallet.all');
		Route::get('generate', 'WalletController@showGenerateWalletForm')->name('wallet.generate');
		Route::post('generate', 'WalletController@generateWallets')->name('wallet.store');
		Route::delete('delete', 'WalletController@delete')->name('wallet.delete');
	});

	Route::get('user-wallets/all', 'WalletController@userWallets')->name('user.wallets');


	Route::get('payments', 'PaymentController@getPayments');
	Route::get('transactions', 'PaymentController@getTransactions');

	Route::get('drivers', 'UserController@getDrivers');
	Route::get('users', 'UserController@getNormalUsers');

	Route::get('admins', 'AdminController@index');
	Route::get('admin/add', 'AdminController@showNewAdminForm');
	Route::post('admin/add', 'AdminController@store')->name('admin.store');
	Route::get('account', 'AdminController@account');
	Route::put('change-password', 'AdminController@changePassword')->name('admin.pw');
});
