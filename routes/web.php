<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AccountMoneyController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DebtsController;
use App\Http\Controllers\PrincipalController;
use App\Http\Controllers\ProfileController;
use App\Models\Activity;
use App\Notifications\NextPayment;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
	return view('welcome');
});

Route::middleware('auth')->controller(PrincipalController::class)->group(function () {
	Route::get('/dashboard', 'dashboard')->name('dashboard');
	Route::get('/my-last-movements', 'my_last_movements')->name('my_last_movements');
	Route::post('/last-movements', 'last_movements')->name('movements');
	Route::post('/last-movements-format-grafic', 'last_movements_format')->name('movements_format');
	Route::post('/new-activity', 'store_activity')->name('store_activity');
});

Route::middleware('auth')->name('accounts.')->controller(AccountMoneyController::class)->group(function () {
	Route::get('/accounts', 'index')->name('index');
	Route::get('/my-accounts', 'my_accounts')->name('my_accounts');
	Route::post('/get-account', 'getAccount')->name('get_account');
	Route::post('/create-update-account', 'create_update')->name('cu_account');
	Route::delete('/delete-account', 'delete_account')->name('delete_account');
});

Route::middleware('auth')->name('profile.')->group(function () {
	Route::get('/profile', [ProfileController::class, 'edit'])->name('edit');
	Route::patch('/profile', [ProfileController::class, 'update'])->name('update');
	Route::delete('/profile', [ProfileController::class, 'destroy'])->name('destroy');
});

Route::middleware('auth')->name('debts.')->controller(DebtsController::class)->group(function () {
	Route::get('my-debts', 'index')->name('index');
});

Route::get('test', function () {});

require __DIR__ . '/auth.php';
