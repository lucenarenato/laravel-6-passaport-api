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
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('/home', 'CustomerController@index')->name('home');

Route::group(['prefix'=>'admin', 'as'=>'admin.'],function(){
    Auth::routes();
    Route::get('logout', 'Auth\LoginController@logout')->name('logout');

    Route::get('/home', 'AdminController@index')->name('home');
    Route::get('/customer/{id}','AdminController@customer');

    Route::group(['prefix'=>'vehicle'], function (){
        Route::post('add','AdminController@add');
        Route::post('update','AdminController@update');
        Route::post('remove','AdminController@remove');
    });
});