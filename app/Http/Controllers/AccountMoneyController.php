<?php

namespace App\Http\Controllers;

use App\Models\AccountMoney;
use App\Models\Activity;
use App\Models\Catalog;
use App\Models\CreditCard;
use App\Models\Debt;
use App\Models\Debtor;
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
		$accounts = AccountMoney::where('account_id', auth()->user()->userAccount->id)->with(['creditCard'])->get();
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
			$account->creditCard;
			unset($account->id);
			return $account;
		} catch (\Throwable $th) {
			return response()->JSON($th->getMessage(), 409);
		}
	}

	public function create_update(Request $request)
	{
		DB::beginTransaction();
		try {
			$principal_account_id = auth()->user()->userAccount->id;
			if ($request->id == 'null') {
				$account = new AccountMoney();
				$message = "La cuenta se ha registrado correctamente";
				$description = "Bienvenido al Sistema de Control de Ingresos 😎";
			} else {
				$id_account_money = Crypt::decrypt($request->id);
				$account = AccountMoney::findOrFail($id_account_money);
				$message = "La cuenta se ha editado correctamente";
				$description = "🛠👨🏼‍🏭✍🏼 Editando un poco 🛠👨🏼‍🏭✍🏼";
			}
			$account->account_id = $principal_account_id;
			$account->name = strtoupper($request->name);
			$account->amount = $request->amount;
			$account->number = $this->strToBool($request->is_card) ? $request->number : null;
			$account->is_active = $this->strToBool($request->is_active);
			$account->is_card = $this->strToBool($request->is_card);
			$account->is_credit = $this->strToBool($request->is_credit);
			$account->save();

			if ($this->strToBool($request->is_credit)) {
				CreditCard::updateOrCreate(['account_money_id' => $account->id], ['limit_credit' => $request->credit_limit, 'cut_off_date' => $request->credit_cutdate, 'payment_deadline' => $request->credit_deadline]);
				$account->creditCard;

				$amount_credit = $request->credit_limit - $request->amount;
				$amount_credit = $this->invertSign($amount_credit);
				$credit_card_id = $account->creditCard->id;

				if($amount_credit < 0){
					$debts = new Debt();
					$debts->account_id = $principal_account_id;
					$debts->is_credit_card = true;
					$debts->credit_card_id = $credit_card_id;
					$debts->name = $account->name;
					$debts->surname = substr($account->number, -4);
					$debts->amount = $this->invertSign($amount_credit);
					$debts->amount_paid = 0;
					$debts->months_to_paid = 0;
					$debts->next_payment = $request->credit_deadline;

					$debts->description = __('The credit card is automatically a debt');
					$debts->save();
				}else if ($amount_credit > 0){
					$debts = new Debtor();
					$debts->account_id = $principal_account_id;
					$debts->name = $account->name;
					$debts->surname = substr($account->number, -4);
					$debts->amount = $amount_credit;
					$debts->description = __('A card owes you money');
					$debts->save();
				}
			}

			$activity = new Activity();
			$activity->account_id = $principal_account_id;
			$activity->account_money_id = $account->id;
			$activity->activitable_id = $request->id == 'null' ? Catalog::WELCOME : Catalog::EDIT_ACCOUNT_MONEY;
			$activity->activitable_type = Type::SYSTEM;
			$activity->description = $description;
			$activity->activity_date = Carbon::now();
			if ($this->strToBool($request->is_credit)) {
				$activity->amount = $amount_credit;
				$activity->last_amount = $amount_credit;
			} else {
				$activity->amount = $request->amount;
				$activity->last_amount = $request->amount;
			}
			$activity->save();
			$this->setNewGlobal();

			DB::commit();
			return response()->JSON(["response_type" => "alert", "response" => ["type" => "success", "message" => $message]]);
		} catch (\Throwable $th) {
			DB::rollBack();
			return $th->getMessage();
		}
	}

	public function delete_account(Request $request)
	{
		DB::beginTransaction();
		try {
			$id_account = Crypt::decrypt($request->id);
			$account = AccountMoney::findOrFail($id_account);
			foreach ($account->activities as $activity) {
				$activity->delete();
			}
			if($this->strToBool($account->is_credit)){
				$account->creditCard->delete();
			}
			$account->delete();
			$this->setNewGlobal();
			DB::commit();
			return response()->JSON(["response_type" => "alert", "response" => ["type" => "success", "message" => 'La cuenta ha sido eliminada correctamente.']]);
		} catch (\Throwable $th) {
			DB::rollBack();
			return $th->getMessage();
		}
	}
}
