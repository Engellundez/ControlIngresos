<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Activity;
use App\Models\Catalog;
use App\Models\Type;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PrincipalController extends Controller
{

	const COLORS = ['#8A2BE2', '#5F9EA0', '#006400', '#8B0000', '#4B0082', '#7FFFD4', '#8FBC8F', '#FF4500', '#EE82EE', '#48D1CC', '#008000', '#FA8072'];

	public function dashboard()
	{
		$icons = [Type::EARNINGS => 'fa-circle-up', Type::EXPENSES => 'fa-circle-down', Type::SYSTEM => 'fa-gears'];
		$colors = [Type::EARNINGS => 'text-emerald-500 dark:text-emerald-400', Type::EXPENSES => 'text-red-400 dark:text-red-400', Type::SYSTEM => 'text-sky-300 dark:text-sky-300'];
		$symbols = [Type::EARNINGS => '+', Type::EXPENSES => '-', Type::SYSTEM => ''];
		$walletsIcons = ['fa-sack-dollar', 'fa-credit-card'];
		$type_activities = Type::TypesForUsers()->get();
		$activities = Catalog::ActivitiesForUser()->get();
		$my_wallets = Wallet::Wallets(Account::GetIdAccountInSession())->get();
		return view('dashboard', compact('type_activities', 'activities', 'my_wallets', 'icons', 'colors', 'symbols', 'walletsIcons'));
	}

	public function last_movements(Request $request)
	{
		$from_date = Carbon::parse($request->from_date);
		$to_date = Carbon::parse($request->to_date);
		$activities = $this->last_movements_data($from_date, $to_date);
		return response()->JSON($activities);
	}

	private function last_movements_data($from_date, $to_date)
	{
		$activities = Activity::where('account_id', auth()->user()->account->id)->whereBetween('activity_date', [$from_date, $to_date])->orderByDesc('activity_date')->latest()->get();
		return $activities;
	}

	public function last_movements_format(Request $request)
	{
		$from_date = Carbon::parse($request->from_date);
		$to_date = Carbon::parse($request->to_date);
		$activities = $this->last_movements_data($from_date, $to_date);

		$groupedData = [];
		$allWallets = []; // Array para almacenar todos los nombres de wallets encontrados

		// Primero, recorremos las actividades y llenamos el $groupedData
		foreach ($activities as $activity) {
			$date = $activity->activity_date;
			$wallet = $activity->wallet_name;

			if (!isset($groupedData[$date])) $groupedData[$date] = [];
			if (!isset($groupedData[$date][$wallet])) $groupedData[$date][$wallet] = 0;
			if (!isset($groupedData[$date]['total'])) $groupedData[$date]['total'] = 0;

			// Actualizamos la cantidad para la wallet específica y el total
			$groupedData[$date][$wallet] += $activity->amount;
			$groupedData[$date]['total'] += $activity->amount;

			// Añadimos la wallet al array de todas las wallets si no está ya presente
			if (!in_array($wallet, $allWallets)) $allWallets[] = $wallet;
		}

		// Ordenar las fechas de forma ascendente
		uksort($groupedData, function ($a, $b) {
			$dateA = Carbon::parse($a);
			$dateB = Carbon::parse($b);
			return $dateA <=> $dateB; // Comparar fechas de forma ascendente
		});

		// Luego, recorremos el $groupedData y aseguramos que cada wallet esté presente con el valor previo si no existía
		$previousValues = [];
		foreach ($groupedData as $date => &$wallets) {
			foreach ($allWallets as $wallet) {
				if (!isset($wallets[$wallet])) {
					// Si la wallet no existe en esta fecha, usamos el valor previo o 0 si es la primera aparición
					$wallets[$wallet] = isset($previousValues[$wallet]) ? $previousValues[$wallet] : 0.0;
				} else {
					// Actualizamos el valor previo
					$previousValues[$wallet] = $wallets[$wallet];
				}
			}
		}


		$labels_dates = array_keys($groupedData);
		$datasets = [];
		$colorIndex = 0;

		foreach ($groupedData as $date => $walletData) {
			foreach ($walletData as $walletName => $totalAmount) {
				if (!isset($datasets[$walletName])) {
					// Obtener el color correspondiente y avanzar al siguiente índice
					$color = self::COLORS[$colorIndex % count(self::COLORS)];
					$colorIndex++; // Incrementar el índice para el siguiente color
					$datasets[$walletName] = [
						'label' => $walletName,
						'data' => [],
						'fill' => false,
						'borderColor' => $color,
						'tension' => 0.1,
					];
				}

				// Agregar el monto para la fecha correspondiente
				$datasets[$walletName]['data'][] = $totalAmount;
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
			$activity = new Activity();
			$activity->account_id = Account::GetIdAccountInSession();
			$activity->activitable_type = $request->type_activity_id ?? null;
			$activity->activitable_id = $request->activity_id ?? null;
			$activity->description = $request->description ?? null;
			$activity->amount = $request->amount ?? null;
			$activity->activity_date = $request->date ?? null;
			$activity->wallet_id = $request->wallet_id ?? null;
			$activity->save();
			DB::commit();

			return response()->JSON(["response_type" => "alert", "response" => ["type" => "success", "message" => "La actividad se ha guardado correctamente"]]);
		} catch (\Throwable $th) {
			DB::rollBack();
			return response()->JSON(["response_type" => "alert", "response" => ["type" => "error", "message" => "La actividad no se pudo guardar, ERROR:" . PHP_EOL . PHP_EOL . $th->getMessage()]]);
		}
	}
}
