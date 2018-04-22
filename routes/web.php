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
    return redirect('/products');
});
Route::get('/products', 'ProductController@index');
Route::group(['middleware' => 'auth'], function () {
    Route::resource('products', 'ProductController', ['except' => ['index']]);
    Route::get('stores/{store}/products/add', 'ProductStoreController@add');
    Route::get('stores/{store}/products', 'ProductStoreController@index');
    Route::post('stores/{store}/products', 'ProductStoreController@store');
    Route::resource('stores', 'StoreController');
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
