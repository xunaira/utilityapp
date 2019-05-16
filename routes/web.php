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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'users'], function(){
	Route::get('/', 'UsersController@index');
     
    Route::get('add', 'UsersController@add');

	Route::post('validate', 'UsersController@email_exists');

	Route::post('create', 'UsersController@create');

	Route::get('edit/{id}', 'UsersController@edit');

	Route::post('update', 'UsersController@update');

	Route::get('delete/{id}', 'UsersController@delete');

});
