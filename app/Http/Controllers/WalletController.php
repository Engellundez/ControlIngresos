<?php

namespace App\Http\Controllers;

use App\Models\Type;
use App\Models\Wallet;
use Illuminate\Http\Request;

class WalletController extends Controller
{
	public function index()
	{
		return view('wallet.index');
	}

	public function my_wallets() {
		return Wallet::where('account_id', auth()->user()->account->id)->orderBy('created_at')->get();
	}
}
