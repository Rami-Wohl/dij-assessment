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

Route::get('/', 'MessageController@create');
Route::post('/', 'MessageController@store');

Route::get('/message/{id}', 'MessageController@show');
Route::post('/message/{id}', 'MessageController@showDecrypted');
Route::delete('/message/{id}', 'MessageController@destroy');


