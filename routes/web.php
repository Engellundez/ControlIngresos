<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
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

Route::get('/dashboard', function () {
	return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->name('wallet.')->group(function () {
	Route::get('/wallet', [WalletController::class, 'index'])->name('index');
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
