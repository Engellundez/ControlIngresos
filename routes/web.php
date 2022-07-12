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

Auth::routes(['register'=>true,'reset'=>false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/', 'IngresoController@index')->middleware('auth')->name('index');
Route::get('/ajax', 'IngresoController@ajax')->middleware('auth')->name('ajax');
Route::post('/ingresos', 'IngresoController@store')->middleware('auth')->name('ingreso');
Route::put('/actualizar', 'IngresoController@update')->middleware('auth')->name('actualizar');
Route::post('/eliminar', 'IngresoController@destroy')->middleware('auth')->name('eliminar');
// Route::resource('ingresos', IngresoController::class);
