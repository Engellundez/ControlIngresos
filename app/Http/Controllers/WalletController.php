<?php

namespace App\Http\Controllers;

use App\Models\Type;
use App\Models\Wallet;
use Illuminate\Http\Request;

class WalletController extends Controller
{
	function index()
	{
		$wallets = Wallet::with(['activities' => fn ($query) => $query->take(10)])->wallets(auth()->user()->id)->get();
		$icons = [Type::EARNINGS => 'fa-circle-up', Type::EXPENSES => 'fa-circle-down', Type::SYSTEM => 'fa-gears'];
		$colors = [Type::EARNINGS => 'text-emerald-500 dark:text-emerald-400', Type::EXPENSES => 'text-red-400 dark:text-red-400', Type::SYSTEM => 'text-sky-300 dark:text-sky-300'];
		$symbols = [Type::EARNINGS => '+', Type::EXPENSES => '-', Type::SYSTEM => ''];
		return view('wallet.index', compact('wallets', 'icons', 'colors', 'symbols'));
	}
}
