<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use NumberFormatter;

class Controller extends BaseController
{
	use AuthorizesRequests, ValidatesRequests;

	static public function invertSign($numero)
	{
		return -$numero;
	}

	static public function strToBool($string)
	{
		if (strtolower($string) === 'true' || $string === '1') {
			return true;
		} elseif (strtolower($string) === 'false' || $string === '0') {
			return false;
		}

		return null;
	}

	static public function formatCurrency($number)
	{
		if ($number === null) return null;

		return '$' . number_format($number, 2, '.', ',');
	}


	public function setNewGlobal()
	{
		$account = Account::GetAccountInSession();
		$account->total_count = 0;
		foreach ($account->accountsOfMoney as $account_money) {
			if ($this->strToBool($account_money->is_credit)) {
				$credit_amount = $account_money->creditCard->limit_credit - $account_money->amount;
				$amount = $this->invertSign($credit_amount);
			} else {
				$amount = $account_money->amount;
			}
			$account->total_count += $amount;
		}
		$account->save();
	}
}
