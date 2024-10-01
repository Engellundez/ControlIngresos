<?php

namespace App\Http\Controllers;

use App\Models\AccountMoney;
use App\Models\Activity;
use App\Models\Catalog;
use App\Models\CreditCard;
use App\Models\Type;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class AccountMoneyController extends Controller
{
	public function index()
	{
		return view('accounts.index');
	}

	public function my_accounts()
	{
		$accounts = AccountMoney::where('account_id', auth()->user()->userAccount->id)->get();
		$accounts->map(function ($item, $key) {
			$item->id_crypt = Crypt::encrypt($item->id);
			$item->account_id = Crypt::encrypt($item->account_id);
			if ($item->is_card) $item->number = substr($item->number, -4);
			unset($item->id);
		});
		return $accounts;
	}

	public function getAccount(Request $request)
	{
		try {
			$id_account_money = Crypt::decrypt($request->id);
			$account = AccountMoney::findOrFail($id_account_money);
			$account->id_crypt = $request->id;
			unset($account->id);
			$account->creditCard;
			return $account;
		} catch (\Throwable $th) {
			return response()->JSON($th->getMessage(), 409);
		}
	}

	public function create_update(Request $request)
	{
		DB::beginTransaction();
		try {
			if ($request->id == 'null') {
				$account = new AccountMoney();
			} else {
				$id_account_money = Crypt::decrypt($request->id);
				$account = AccountMoney::findOrFail($id_account_money);
			}
			$account->account_id = auth()->user()->userAccount->id;
			$account->name = strtoupper($request->name);
			$account->amount = $request->amount;
			$account->number = $request->is_card == 'false' ? null : $request->number;
			$account->is_active = $request->is_active;
			$account->is_card = $request->is_card;
			$account->is_credit = $request->is_credit;
			$account->save();

			if ($request->is_credit == "true") {
				CreditCard::updateOrCreate(['account_money_id' => $account->id], ['limit_credit' => $request->credit_limit, 'cut_off_date' => $request->credit_cutdate, 'payment_deadline' => $request->credit_deadline]);
				$account->creditCard;
			}

			$activity = new Activity();
			$activity->account_id = auth()->user()->userAccount->id;
			$activity->account_money_id = $account->id;
			$activity->activitable_id = $request->id == 'null' ? Catalog::WELCOME : Catalog::EDIT_ACCOUNT_MONEY;
			$activity->activitable_type = Type::SYSTEM;
			$activity->activity_date = Carbon::now();
			$activity->amount = $request->amount;
			$activity->save();

			DB::commit();
			return response()->JSON('success');
		} catch (\Throwable $th) {
			DB::rollBack();
			throw $th;
			return $th->getMessage();
		}
	}
}
