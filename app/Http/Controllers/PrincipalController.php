<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\AccountMoney;
use App\Models\Activity;
use App\Models\Catalog;
use App\Models\Debt;
use App\Models\Debtor;
use App\Models\Type;
use App\Notifications\NextPayment;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PrincipalController extends Controller
{

	const COLORS = ['#2A9D2A', '#D4B000', '#00CCCC', '#CC8400', '#CC00CC', '#6FCC00', '#3656A1', '#CC117A', '#7D5FB6', '#D9D9B3', '#CC3700', '#00A5A0', '#1A9589', '#91CC24', '#CC7000', '#6DA8D1', '#CC4F3A', '#6B006B', '#3A6D92', '#B89C7A'];

	public function dashboard()
	{
		$icons = [Type::EARNINGS => 'fa-circle-up', Type::EXPENSES => 'fa-circle-down', Type::SYSTEM => 'fa-gears', Type::LOSSES => 'fa-heart-crack'];
		$colors = [Type::EARNINGS => 'text-emerald-500 dark:text-emerald-400', Type::EXPENSES => 'text-red-400 dark:text-red-400', Type::SYSTEM => 'text-sky-300 dark:text-sky-300', Type::LOSSES => 'text-red-400 dark:text-red-400'];
		$symbols = [Type::EARNINGS => '+', Type::EXPENSES => '-', Type::SYSTEM => '', Type::LOSSES => '-'];
		$expenses = Type::EXPENSES;
		$accountsIcons = ['fa-sack-dollar', 'fa-credit-card', 'fa-money-check-dollar'];
		$payment_methods = Catalog::PaymentMethods()->get();
		$type_activities = Type::TypesForUsers()->get();
		$activities = Catalog::ActivitiesForUser()->get();
		$id_account = Account::GetIdAccountInSession();
		$my_accounts = AccountMoney::AccountsOfMoney($id_account)->get();
		$my_accounts_debts = Debt::MyDebts($id_account)->get();
		$my_debtors = Debtor::MyDebtors($id_account)->get();
		return view('dashboard', compact('payment_methods', 'type_activities', 'activities', 'my_accounts', 'icons', 'colors', 'symbols', 'accountsIcons', 'expenses', 'my_accounts_debts', 'my_debtors'));
	}

	public function last_movements(Request $request)
	{
		$from_date = $request->from_date ? Carbon::parse($request->from_date) : null;
		$to_date = $request->from_date ? Carbon::parse($request->to_date) : null;
		$activities = $this->last_movements_data($from_date, $to_date);
		return response()->JSON($activities);
	}

	private function last_movements_data($from_date, $to_date)
	{
		return Activity::where('account_id', auth()->user()->userAccount->id)->when($from_date, function (Builder $query) use ($from_date, $to_date) {
			return $query->whereBetween('activity_date', [$from_date, $to_date]);
		})->orderByDesc('activity_date')->latest()->get();
	}

	public function last_movements_format(Request $request)
	{
		$from_date = Carbon::parse($request->from_date);
		$to_date = Carbon::parse($request->to_date);

		// Obtener todas las cuentas que tienen actividades antes o dentro del rango de fechas
		$allAccounts = $this->get_accounts_with_activity($from_date, $to_date);

		// Inicializar los datos agrupados por fecha
		$groupedData = [];

		foreach ($allAccounts as $account) {
			$accountName = $account->name;

			// Obtener la última actividad antes o igual a la fecha de inicio
			$lastActivity = $this->get_last_activity_before($account->id, $from_date);

			// Si no hay actividad previa, establece 0
			if (!$lastActivity) {
				$currentAmount = 0;
			} else {
				// Establecer el saldo inicial de la cuenta basado en la última actividad encontrada
				$currentAmount = $lastActivity->last_amount;
			}


			// Propagar el saldo hasta que se encuentre una nueva actividad
			for ($date = $from_date->copy(); $date <= $to_date; $date->addDay()) {
				$activity = $this->get_activity_by_account_and_date($account->id, $date);

				// Si hay actividad en esta fecha, actualizamos el saldo
				if ($activity) $currentAmount = $activity->last_amount;
				// Inicializar los datos para la fecha si no existen
				if (!isset($groupedData[$date->format('d-m-y')]))  $groupedData[$date->format('d-m-y')] = [];
				// Establecer el saldo actual en la fecha
				$groupedData[$date->format('d-m-y')][$accountName] = $currentAmount;
			}
		}

		// Crear las etiquetas y los datasets para el gráfico
		$labels_dates = array_keys($groupedData);
		$datasets = $this->create_datasets($groupedData);

		$data = (object) [
			'labels' => $labels_dates,
			'datasets' => $datasets,
		];

		return response()->json($data);
	}

	private function get_accounts_with_activity($from_date, $to_date)
	{
		// Consulta para obtener todas las cuentas que tienen actividad en el rango de fechas o antes
		return AccountMoney::whereHas('activities', function ($query) use ($from_date, $to_date) {
			$query->where('activity_date', '<=', $to_date);
		})->get();
	}

	private function get_last_activity_before($accountId, $from_date)
	{
		// Obtener la última actividad de la cuenta antes o igual a la fecha de inicio
		return Activity::where('account_money_id', $accountId)
			->where('activity_date', '<=', $from_date)
			->orderByDesc('activity_date')
			->orderByDesc('created_at')
			->first();
	}

	private function get_activity_by_account_and_date($accountId, $date)
	{
		// Obtener la actividad de la cuenta en una fecha específica
		return Activity::where('account_money_id', $accountId)
			->where('activity_date', $date)
			->latest('activity_date')
			->latest()
			->first();
	}

	private function create_datasets($groupedData)
	{
		// Generar los datasets para el gráfico
		$datasets = [];
		$colorIndex = 0;

		foreach ($groupedData as $date => $accountData) {
			foreach ($accountData as $accountName => $totalAmount) {
				if (!isset($datasets[$accountName])) {
					// Asignar un color para la cuenta
					$color = self::COLORS[$colorIndex % count(self::COLORS)];
					$colorIndex++;
					$datasets[$accountName] = [
						'label' => $accountName,
						'data' => [],
						'fill' => false,
						'borderColor' => $color,
						'tension' => 0.1,
					];
				}

				// Agregar el saldo a la fecha correspondiente
				$datasets[$accountName]['data'][] = $totalAmount;
			}
		}

		return array_values($datasets);
	}

	public function store_activity(Request $request)
	{
		DB::beginTransaction();
		try {
			$account = AccountMoney::findOrFail($request->account_money_id);
			if ($request->type_activity_id == Type::EARNINGS) {
				$new_amount = $account->amount + $request->amount;
			} else {
				$new_amount = $account->amount - $request->amount;
			}
			$account->amount = $new_amount;
			$account->save();

			if ($this->strToBool($account->is_credit)) {
				$credit_amount = $account->creditCard->limit_credit - $new_amount;
				$activity_amount = $this->invertSign($credit_amount);
			} else {
				$activity_amount = $new_amount;
			}

			$activity = new Activity();
			$activity->account_id = Account::GetIdAccountInSession();
			$activity->payment_method_id = $request->payment_method != 'null' && $request->payment_method != null ? $request->payment_method : null;
			$activity->activitable_type = $request->type_activity_id ?? null;
			$activity->activitable_id = $request->activity_id ?? null;
			$activity->description = $request->description != 'null' && $request->description != null ? $request->description : null;
			$activity->amount = $request->amount ?? null;
			$activity->last_amount = $activity_amount;
			$activity->activity_date = $request->date ?? null;
			$activity->account_money_id = $account->id ?? null;
			$activity->save();

			if ($activity->payment_method_id) {
				$debts = new Debt();
				$debts->account_id = Account::GetIdAccountInSession();
				$debts->is_credit_card = true;
				$debts->credit_card_id = $account->creditCard->id;
				$debts->name = $account->name;
				$debts->surname = substr($account->number, -4);
				$debts->second_surname = null;
				$debts->amount = $request->amount;
				$debts->amount_paid = 0;
				$debts->months_to_paid = (int) $activity->payment_method->description;
				$debts->next_payment = $this->setCutDateAndPaymentDeadlineToNow($account->creditCard->cut_off_date, $account->creditCard->payment_deadline)[1];
				$debts->description = $activity->description;
				$debts->save();
			}

			// $this->check_debts_and_debtors($activity, $request->account_to_credited, $request->debtor_account);

			$this->setNewGlobal();
			DB::commit();

			return response()->JSON(["response_type" => "alert", "response" => ["type" => "success", "message" => "La actividad se ha guardado correctamente"]]);
		} catch (\Throwable $th) {
			DB::rollBack();
			throw $th;
			return response()->JSON(["response_type" => "alert", "response" => ["type" => "error", "message" => "La actividad no se pudo guardar, ERROR:" . PHP_EOL . PHP_EOL . $th->getMessage()]]);
		}
	}

	public function check_debts_and_debtors(Activity $activity, $account_to_credited, $debtor_account)
	{
		// ACTUALIZAR LAS CUENTAS DE QUIEN ME DEBE Y DONDE DEBO RESPECTO MIS ACTIVIDADES Y CUENTAS
		if ($activity->activity_id == Catalog::DEBT) {
			$account_id = $account_to_credited;

			$debt = Debt::find($account_to_credited);
			$new_amount = $debt->amount - $activity->amount;
			if ($new_amount <= 0) {
				$debt->delete();
			} else {
				$debt->amount = $new_amount;
				$debt->months_to_paid = (int) $debt->months_to_paid - 1;
				$debt->next_payment = Carbon::parse($debt->next_payment)->addMonth();
				$debt->save();
			}
		}

		if ($activity->activity_id == Catalog::DEBT_PAYMENTS) {
			$account_id = $debtor_account;

			$debtor = Debtor::find($debtor_account);
			$new_amount = $debtor->amount - $activity->amount;
			if ($new_amount <= 0) {
				$debtor->delete();
			} else {
				$debtor->amount = $new_amount;
				$debtor->save();
			}
			$create_activity = true;
			$type = Type::EXPENSES;
			$activity = Catalog::DEBT;
		}
	}

	public function my_last_movements()
	{
		$icons = [Type::EARNINGS => 'fa-circle-up', Type::EXPENSES => 'fa-circle-down', Type::SYSTEM => 'fa-gears', Type::LOSSES => 'fa-heart-crack'];
		$colors = [Type::EARNINGS => 'text-emerald-500 dark:text-emerald-400', Type::EXPENSES => 'text-red-400 dark:text-red-400', Type::SYSTEM => 'text-sky-300 dark:text-sky-300', Type::LOSSES => 'text-red-400 dark:text-red-400'];
		$symbols = [Type::EARNINGS => '+', Type::EXPENSES => '-', Type::SYSTEM => '', Type::LOSSES => '-'];
		$accountsIcons = ['fa-sack-dollar', 'fa-credit-card', 'fa-money-check-dollar'];

		return view('my_last_movements', compact('icons', 'colors', 'symbols', 'accountsIcons'));
	}
}
