<?php

use \App\Http\Controllers;
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

//Route::resource('blogs', BlogController::class);

Route::get('blogs', '\App\Http\Controllers\BlogController@index');
Route::get('blogs/create', '\App\Http\Controllers\BlogController@create');
Route::post('blogs/create', '\App\Http\Controllers\BlogController@store');
Route::get('blogs/show/{id}', '\App\Http\Controllers\BlogController@show')->name('blogs.show');
Route::get('blogs/edit/{id}', '\App\Http\Controllers\BlogController@edit')->name('blogs.edit');
Route::post('blogs/edit', '\App\Http\Controllers\BlogController@update');
Route::get('blogs/destroy', '\App\Http\Controllers\BlogController@destroy');
//Route::post('blogs/destroy', '\App\Http\Controllers\BlogController@destroy');
Route::get('blogs/validate', '\App\Http\Controllers\BlogController@validation');
//Route::post('blogs', '\App\Http\Controllers\BlogController@search');
Route::post('blogs/filter', '\App\Http\Controllers\BlogController@filter');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
