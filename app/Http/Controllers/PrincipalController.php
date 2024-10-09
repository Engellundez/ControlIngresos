<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\AccountMoney;
use App\Models\Activity;
use App\Models\Catalog;
use App\Models\Type;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PrincipalController extends Controller
{

	const COLORS = ['#2A9D2A','#D4B000','#00CCCC','#CC8400','#CC00CC','#6FCC00','#3656A1','#CC117A','#7D5FB6','#D9D9B3','#CC3700','#00A5A0','#1A9589','#91CC24','#CC7000','#6DA8D1','#CC4F3A','#6B006B','#3A6D92','#B89C7A'];

	public function dashboard()
	{
		$icons = [Type::EARNINGS => 'fa-circle-up', Type::EXPENSES => 'fa-circle-down', Type::SYSTEM => 'fa-gears'];
		$colors = [Type::EARNINGS => 'text-emerald-500 dark:text-emerald-400', Type::EXPENSES => 'text-red-400 dark:text-red-400', Type::SYSTEM => 'text-sky-300 dark:text-sky-300'];
		$symbols = [Type::EARNINGS => '+', Type::EXPENSES => '-', Type::SYSTEM => ''];
		$accountsIcons = ['fa-sack-dollar', 'fa-credit-card', 'fa-money-check-dollar'];
		$type_activities = Type::TypesForUsers()->get();
		$activities = Catalog::ActivitiesForUser()->get();
		$my_accounts = AccountMoney::AccountsOfMoney(Account::GetIdAccountInSession())->get();
		return view('dashboard', compact('type_activities', 'activities', 'my_accounts', 'icons', 'colors', 'symbols', 'accountsIcons'));
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
		$activities = $this->last_movements_data($from_date, $to_date)->reverse();

		$last_date = null;
		$groupedData = [];
		$allAccounts = []; // Array para almacenar todos los nombres de cuentas encontradas

		// Primero, recorremos las actividades y llenamos el $groupedData
		foreach ($activities as $activity) {
			$date = $activity->activity_date;
			$account = $activity->account_money_name;

			// Si es una nueva fecha, propagamos los saldos de todas las cuentas
			if ($last_date != $date && $last_date !== null) {
				foreach ($allAccounts as $acc) {
					if (!isset($groupedData[$date][$acc])) {
						$groupedData[$date][$acc] = isset($groupedData[$last_date][$acc]) ? $groupedData[$last_date][$acc] : 0;
					}
				}
			}
			// Inicializamos los valores para la cuenta si no existen
			if (!isset($groupedData[$date])) $groupedData[$date] = [];
			if (!isset($groupedData[$date][$account])) $groupedData[$date][$account] = 0;

			// Actualizamos el saldo basado en el tipo de actividad
			if ($activity->activitable_type == Type::SYSTEM) {
				$groupedData[$date][$account] = $activity->amount;
			} else if ($activity->activitable_type == Type::EARNINGS) {
				$groupedData[$date][$account] += $activity->amount;
			} else if ($activity->activitable_type == Type::EXPENSES || $activity->activitable_type == Type::LOSSES) {
				$groupedData[$date][$account] -= $activity->amount;
			}

			if (!in_array($account, $allAccounts)) $allAccounts[] = $account;
			$last_date = $date;
		}

		// Luego, recorremos el $groupedData y aseguramos que cada cuenta esté presente con el valor previo si no existía
		$previousValues = [];
		foreach ($groupedData as $date => &$accounts) {
			foreach ($allAccounts as $account) {
				if (!isset($accounts[$account])) {
					// Si la cuenta no existe en esta fecha, usamos el valor previo o 0 si es la primera aparición
					$accounts[$account] = isset($previousValues[$account]) ? $previousValues[$account] : 0.0;
				} else {
					// Actualizamos el valor previo
					$previousValues[$account] = $accounts[$account];
				}
			}
		}


		$labels_dates = array_keys($groupedData);
		$datasets = [];
		$colorIndex = 0;

		foreach ($groupedData as $date => $accountData) {
			foreach ($accountData as $accountName => $totalAmount) {
				if (!isset($datasets[$accountName])) {
					// Obtener el color correspondiente y avanzar al siguiente índice
					$color = self::COLORS[$colorIndex % count(self::COLORS)];
					$colorIndex++; // Incrementar el índice para el siguiente color
					$datasets[$accountName] = [
						'label' => $accountName,
						'data' => [],
						'fill' => false,
						'borderColor' => $color,
						'tension' => 0.1,
					];
				}

				// Agregar el monto para la fecha correspondiente
				$datasets[$accountName]['data'][] = $totalAmount;
			}
		}
		// Convertir $datasets en una lista numerada de objetos
		$datasets = array_values(array_map(function ($dataset) {
			return (object) $dataset;
		}, $datasets));

		// Paso 5: Crear el objeto $data con etiquetas y conjuntos de datos
		$data = (object) [
			'labels' => $labels_dates,
			'datasets' => $datasets,
		];

		return response()->json($data);
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

			$activity = new Activity();
			$activity->account_id = Account::GetIdAccountInSession();
			$activity->activitable_type = $request->type_activity_id ?? null;
			$activity->activitable_id = $request->activity_id ?? null;
			$activity->description = $request->description != 'null' && $request->description != null ? $request->description : null;
			$activity->amount = $request->amount ?? null;
			$activity->activity_date = $request->date ?? null;
			$activity->account_money_id = $account->id ?? null;
			$activity->save();

			$this->setNewGlobal();
			DB::commit();

			return response()->JSON(["response_type" => "alert", "response" => ["type" => "success", "message" => "La actividad se ha guardado correctamente"]]);
		} catch (\Throwable $th) {
			DB::rollBack();
			return response()->JSON(["response_type" => "alert", "response" => ["type" => "error", "message" => "La actividad no se pudo guardar, ERROR:" . PHP_EOL . PHP_EOL . $th->getMessage()]]);
		}
	}

	public function my_last_movements()
	{
		$icons = [Type::EARNINGS => 'fa-circle-up', Type::EXPENSES => 'fa-circle-down', Type::SYSTEM => 'fa-gears'];
		$colors = [Type::EARNINGS => 'text-emerald-500 dark:text-emerald-400', Type::EXPENSES => 'text-red-400 dark:text-red-400', Type::SYSTEM => 'text-sky-300 dark:text-sky-300'];
		$symbols = [Type::EARNINGS => '+', Type::EXPENSES => '-', Type::SYSTEM => ''];
		$accountsIcons = ['fa-sack-dollar', 'fa-credit-card', 'fa-money-check-dollar'];

		return view('my_last_movements', compact('icons', 'colors', 'symbols', 'accountsIcons'));
	}
}
