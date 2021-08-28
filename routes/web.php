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

//Route::get('/', function () {
//    return view('welcome');
//});


Route::get('blogs', '\App\Http\Controllers\BlogController@index');
Route::get('blogs/create', '\App\Http\Controllers\BlogController@create');
Route::post('blogs/create', '\App\Http\Controllers\BlogController@store');
Route::get('blogs/show', '\App\Http\Controllers\BlogController@show');
Route::get('blogs/edit', '\App\Http\Controllers\BlogController@edit');
Route::post('blogs/edit', '\App\Http\Controllers\BlogController@update');



