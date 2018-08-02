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
    return redirect()->route('login');
});

Route::group(['prefix' => 'menus', 'as' => 'menus.', 'middleware' => ['auth']], function(){

    Route::get(   '/',              ['as' => 'index',   'uses' => 'Admin\MenuController@index']);
    Route::get(   '{menu}/show',    ['as' => 'show',    'uses' => 'Admin\MenuController@show']);
    Route::get(   'create/{id?}',   ['as' => 'create',  'uses' => 'Admin\MenuController@create']);
    Route::post(  'store/{id?}',    ['as' => 'store',   'uses' => 'Admin\MenuController@store']);
    Route::get(   '{menu}/edit',    ['as' => 'edit',    'uses' => 'Admin\MenuController@edit']);
    Route::put(   '{menu}/update',  ['as' => 'update',  'uses' => 'Admin\MenuController@update']);
    Route::delete('{menu}/destroy', ['as' => 'destroy', 'uses' => 'Admin\MenuController@destroy']);

    //Route::resource('menus','Admin\MenuController');

});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
