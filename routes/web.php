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


Auth::routes();

Route::get('/', function () {
    return redirect('/guests');
});


Route::get('/home', 'HomeController@index')->name('home');


Route::group(['middleware' => 'auth'], function () {
	Route::group(['prefix' => 'api'], function () {
		Route::get('/guest', 'GuestController@getGuests');
		Route::get('/trial-balance', 'TrialBalanceController@getTransactions');
		Route::post('/trial-balance', 'TrialBalanceController@addTransaction');

	});
	/* Guests */
	Route::group(['prefix' => 'guests'], function () {
		Route::get('/', 'GuestController@index');
		Route::post('/', 'GuestController@store');
		Route::get('/{id}', 'GuestController@edit');
		Route::put('/{id}', 'GuestController@update');
		Route::post('/{id}/delete', 'GuestController@destroy');
	});
	Route::post('/guest/check-out/{id}', 'GuestController@checkOut');

	/* Orders */
	Route::post('/orders', 'OrderController@store');
	Route::post('/orders/{id}/delete', 'OrderController@destroy');

	/* Charges */
	Route::post('/charges', 'ChargeController@store');
	Route::post('/charges/{id}/delete', 'ChargeController@destroy');
	
	/* Rooms */
	Route::group(['prefix' => 'room-types'], function () {
		Route::get('/', 'RoomTypeController@index');
		Route::post('/', 'RoomTypeController@store');
		Route::get('/{id}', 'RoomTypeController@show');
		Route::get('/{id}/edit', 'RoomTypeController@edit');
		Route::put('/{id}', 'RoomTypeController@update');
		Route::post('/{id}/delete', 'RoomTypeController@destroy');
		
		Route::post('/room-rates/add', 'RoomTypeController@addRoomRate');
		Route::get('/room-rates/{id}/edit/', 'RoomTypeController@editRoomRate');
		Route::put('/room-rates/{id}/update/', 'RoomTypeController@updateRoomRate');
	});

	/* Items */
	Route::group(['prefix' => 'items'], function () {
		Route::get('/', 'ItemController@index');
		Route::post('/', 'ItemController@store');
		Route::get('/{id}', 'ItemController@edit');
		Route::put('/{id}', 'ItemController@update');
		Route::post('/{id}/delete', 'ItemController@destroy');
	});
	/* Inventory */
	Route::group(['prefix' => 'inventories'], function(){
		Route::get('/', 'InventoryController@index');
		Route::post('/', 'InventoryController@store');
	});

	Route::get('/trial-balance', 'TrialBalanceController@index');
});
