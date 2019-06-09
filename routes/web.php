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

		Route::get('detail/{id}', 'UserController@detail');

		Route::get('export/{id}', 'UserController@export');

		Route::get('agentexport/{id}', 'UserController@agentexport');

		Route::get('bankexport/{id}', 'UserController@bankexport');

		Route::post('settarget', 'UserController@target');

	});

	Route::group(['prefix' => 'users'], function(){
		Route::get('/', 'UsersController@index');

		Route::get('add', 'UsersController@create');

		Route::post('validate', 'UsersController@email_exists');

		Route::post('store', 'UsersController@store');

		Route::get('edit/{id}', 'UsersController@edit');

		Route::post('update', 'UsersController@update');

		Route::get('delete/{id}', 'UsersController@destroy');

		Route::get('agents/{id}', 'UsersController@agents');

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

		Route::post('store', 'AgentSalesController@store')->name('store');;

		Route::get('edit/{id}', 'AgentSalesController@edit');

		Route::post('update', 'AgentSalesController@update');

		Route::get('delete/{id}', 'AgentSalesController@destroy');

		Route::post('ajax', 'AgentSalesController@productGet')->name('get_product');

		Route::get('balance', 'AgentSalesController@getTotalBalance');

		Route::get('approve/{id}', 'AgentSalesController@approve');

		Route::get('reject/{id}', 'AgentSalesController@reject');
	});

	Route::group(['prefix' => 'settings'], function(){
		Route::get('/', 'SettingsController@index');

		Route::get('commission', 'SettingsController@commission');

		Route::post('commission', 'SettingsController@store');

		Route::get('edit/{id}', 'SettingsController@edit');

		Route::post('update', 'SettingsController@update');

		Route::get('delete/{id}', 'SettingsController@destroy');

		Route::get('system', 'SettingsController@system');

		Route::get('balance', 'SettingsController@view_balance');

		Route::get('edit_balance/{id}', 'SettingsController@edit_balance');

		Route::post('update_balance', 'SettingsController@update_balance');

		Route::get('delete_balance/{id}', 'SettingsController@delete_balance');

		Route::post('system', 'SettingsController@add_balance');
	});

	Route::group(['prefix' => 'reports'], function(){
		Route::get('sales-reports', 'ReportsController@sales');

		Route::get('sales-export', 'ReportsController@salesexport');

		Route::get('wallet-reports', 'ReportsController@wallet');

		Route::get('wallet-export', 'ReportsController@walletexport');

		Route::get('agent-reports', 'ReportsController@agents');

		Route::get('agent-export', 'ReportsController@agentexport');

	});

	Route::group(['prefix' => 'company'], function(){
		Route::get('/', 'CompanyController@index');

		Route::get('add', 'CompanyController@add');

		Route::post('store', 'CompanyController@add_company');

		Route::get('edit/{id}', 'CompanyController@edit');

		Route::post('update', 'CompanyController@update');

		Route::get('delete/{id}', 'CompanyController@destroy');

	});

	Route::group(['prefix' => 'api'], function(){
		Route::get('monthlysales', 'HomeController@getSalesByMonth');
		Route::get('yearlysales', 'HomeController@getSalesByYear');


	});


});
