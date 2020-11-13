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

Route::get('/home', function () {
    return view('welcome');
});
Route::post('/comercial/ajax', 'ComercialController@ajax')->name('ajax');
Route::post('/comercial/ajaxgraf', 'ComercialController@ajax')->name('ajaxgraf');
Route::post('/comercial/ajaxpie', 'ComercialController@pie')->name('ajaxpie');
Route::get('/', 'ComercialController@index')->name('comercial');
