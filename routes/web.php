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
		return view('auth.login');
	});


Route::group(['prefix' => 'admin'], function(){
	Auth::routes();
	Route::get('dashboard', 'HomeController@index');
	Route::get('logout', 'Auth\LoginController@logout');

	Route::group(['prefix' => 'agents'], function(){
		Route::get('/', 'UserController@index');

		Route::get('add', 'UserController@create');

		Route::get('add-balance', 'UserController@add_balance');

		Route::post('add-balance', 'UserController@balance');

		Route::post('validate', 'UserController@email_exists');

		Route::post('store', 'UserController@store');

		Route::get('edit/{id}', 'UserController@edit');

		Route::post('update', 'UserController@update');

		Route::get('delete/{id}', 'UserController@destroy');

	});

	Route::group(['prefix' => 'users'], function(){
		Route::get('/', 'UsersController@index');

		Route::get('add', 'UsersController@create');

		Route::post('validate', 'UsersController@email_exists');

		Route::post('store', 'UsersController@store');

		Route::get('edit/{id}', 'UsersController@edit');

		Route::post('update', 'UsersController@update');

		Route::get('delete/{id}', 'UsersController@destroy');

	});

	Route::group(['prefix' => 'products'], function(){
		Route::get('/', 'ProductController@index')->name('products_index');

		Route::get('/create', 'ProductController@create')->name('products_create');

		Route::post('/store', 'ProductController@store')->name('products_store');

		Route::get('edit/{id}', 'ProductController@edit')->name('products_edit');

		Route::post('update/{id}', 'ProductController@update')->name('products_update');

		Route::get('delete/{id}', 'ProductController@destroy')->name('products_delete');

	});

	Route::group(['prefix' => 'agent-sales'], function(){
		Route::get('/', 'AgentSalesController@index');

		Route::get('add', 'AgentSalesController@create');

		Route::post('store', 'AgentSalesController@store');

		Route::get('edit/{id}', 'AgentSalesController@edit');

		Route::post('update', 'AgentSalesController@update');

		Route::get('delete/{id}', 'AgentSalesController@destroy');

	});


});
