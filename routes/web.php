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

Route::get('abel', function () {
    return view('products.abel');
});
Route::get('/', function () {
    return redirect('/products');
});
Route::get('/products', 'ProductController@index');
Route::group(['middleware' => 'auth'], function () {
    Route::resource('products', 'ProductController', ['except' => ['index']]);
    Route::get('stores/{store}/products/add', 'ProductStoreController@add');
    Route::post('stores/{store}/products/{product}/reduce', 'ProductStoreController@reduceStock');
    Route::post('stores/{store}/products/{product}/add', 'ProductStoreController@addStock');
    Route::get('stores/{store}/products', 'ProductStoreController@index');
    Route::post('stores/{store}/products', 'ProductStoreController@store');
    Route::resource('stores', 'StoreController');
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
