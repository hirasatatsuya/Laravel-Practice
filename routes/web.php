<?php

use \App\Http\Controllers\BlogController;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index']);

Route::resource('/blogs', BlogController::class);



//Route::get('blogs', [BlogController::class, 'index']);
//Route::get('blogs/create', '\App\Http\Controllers\BlogController@create');
//Route::post('blogs/store', '\App\Http\Controllers\BlogController@store');
//Route::get('blogs/show', '\App\Http\Controllers\BlogController@show')->name('blogs.show');
//Route::get('blogs/edit', '\App\Http\Controllers\BlogController@edit')->name('blogs.edit');
//Route::post('blogs/update', '\App\Http\Controllers\BlogController@update')->name('blogs.update');
//Route::get('blogs/destroy', '\App\Http\Controllers\BlogController@destroy');
////Route::post('blogs/destroy', '\App\Http\Controllers\BlogController@destroy');
//Route::get('blogs/validate', '\App\Http\Controllers\BlogController@validation');
//Route::post('blogs', '\App\Http\Controllers\BlogController@search');
//Route::post('blogs/search', '\App\Http\Controllers\BlogController@search')->name('blogs.search');


