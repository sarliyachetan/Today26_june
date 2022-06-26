<?php

use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => 'guest'], function(){
    Route::get('/index', 'App\Http\Controllers\Admin\GuestController@index')->name('index');
    Route::get('/login', 'App\Http\Controllers\Admin\GuestController@login')->name('login');
    Route::post('/login', 'App\Http\Controllers\Admin\GuestController@loginPost')->name('login.post');

});
Route::group([ 'middleware' => 'auth'], function(){
    Route::get('dashboard', 'App\Http\Controllers\Admin\AdminController@dashboard')->name('dashboard');
    Route::get('product', 'App\Http\Controllers\Admin\AdminController@product')->name('product');
    Route::post('productSave', 'App\Http\Controllers\Admin\AdminController@productSave')->name('productSave');
    Route::get('productEdit/{id}', 'App\Http\Controllers\Admin\AdminController@productEdit')->name('productEdit');
    Route::post('ProductDelete', 'App\Http\Controllers\Admin\AdminController@ProductDelete')->name('ProductDelete');
    
      //  Logout
      Route::get('logout', 'App\Http\Controllers\Admin\AdminController@logout')->name('logout');

});

