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

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes(['register'=>true,'reset'=>false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/ingresos', 'IngresoController@index')->name('index');
Route::post('/ingresos', 'IngresoController@store')->name('ingreso');
Route::put('/actualizar', 'IngresoController@update')->name('actualizar');
Route::post('/eliminar', 'IngresoController@destroy')->name('eliminar');
// Route::resource('ingresos', IngresoController::class);
