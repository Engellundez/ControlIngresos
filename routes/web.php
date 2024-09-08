<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\PrincipalController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WalletController;

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
	Route::post('/last-movements', 'last_movements')->name('movements');
	Route::post('/last-movements-format-grafic', 'last_movements_format')->name('movements_format');
	Route::post('/new-activity', 'store_activity')->name('store_activity');
});

Route::middleware('auth')->name('wallet.')->controller(WalletController::class)->group(function () {
	Route::get('/wallet', 'index')->name('index');
	Route::get('/my-wallets', 'my_wallets')->name('my_wallets');
});

Route::middleware('auth')->name('profile.')->group(function () {
	Route::get('/profile', [ProfileController::class, 'edit'])->name('edit');
	Route::patch('/profile', [ProfileController::class, 'update'])->name('update');
	Route::delete('/profile', [ProfileController::class, 'destroy'])->name('destroy');
});

Route::name('account.')->middleware(['auth'])->controller(AccountController::class)->group(function () {
	Route::get('/inicio', 'index')->name('index');
});

require __DIR__ . '/auth.php';
