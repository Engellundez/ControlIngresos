<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Account;
use App\Models\Activity;
use App\Models\Catalog;
use App\Models\Division;
use App\Models\Type;
use App\Models\User;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 */
	public function run(): void
	{
		$this->call([
			CatalogSeeder::class,
		]);

		User::factory()
			->has(Account::factory()
				->state([
					'alias' => 'Engellundez',
					'total_count' => 2395.00
				])
				->has(Wallet::factory()
					->state(['updated_at' => Carbon::now(), 'created_at' => Carbon::now()->subDays(5)])
					->has(Activity::factory()->count(5)->sequence(
						['created_at' => Carbon::now()->subDays(5), 'updated_at' => Carbon::now()->subDays(5), 'activity_date' => Carbon::now()->subDays(5)],
						['activitable_id' => Catalog::LUCK, 'activitable_type' => Type::EARNINGS, 'amount' => 200.00, 'description' => 'Encontrado en la calle', 'created_at' => Carbon::now()->subDays(5), 'updated_at' => Carbon::now()->subDays(5), 'activity_date' => Carbon::now()->subDays(5)],
						['activitable_id' => Catalog::VITAL_PURCHASE, 'activitable_type' => Type::EXPENSES, 'amount' => 100.00, 'description' => 'Cono de huevo', 'created_at' => Carbon::now()->subDays(3), 'updated_at' => Carbon::now()->subDays(3), 'activity_date' => Carbon::now()->subDays(3)],
						['activitable_id' => Catalog::VITAL_PURCHASE, 'activitable_type' => Type::EXPENSES, 'amount' => 50.00, 'description' => 'Filetes empanizados', 'created_at' => Carbon::now()->subDays(3), 'updated_at' => Carbon::now()->subDays(3), 'activity_date' => Carbon::now()->subDays(3)],
						['activitable_id' => Catalog::NON_VITAL_PURCHASE, 'activitable_type' => Type::EXPENSES, 'amount' => 5.00, 'description' => 'Cigarro', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'activity_date' => Carbon::now()],
					))
					->count(1))
				->has(Wallet::factory()
					->state(['name' => 'BBVA', 'is_card' => true, 'updated_at' => Carbon::now()->subDays(5), 'created_at' => Carbon::now()->subMonth()])
					->has(Activity::factory()->count(5)->sequence(
						['created_at' => Carbon::now()->subMonth(), 'updated_at' => Carbon::now()->subMonth(), 'activity_date' => Carbon::now()->subMonth()],
						['activitable_id' => Catalog::TRANSFER_TO_ACCOUNTS, 'activitable_type' => Type::SYSTEM, 'amount' => 5000.00, 'description' => 'Recepción de nomina', 'created_at' => Carbon::now()->subMonth(), 'updated_at' => Carbon::now()->subMonth(), 'activity_date' => Carbon::now()->subMonth()],
						['activitable_id' => Catalog::RENT, 'activitable_type' => Type::EXPENSES, 'amount' => 2500.00, 'description' => 'Renta', 'created_at' => Carbon::now()->subDays(15), 'updated_at' => Carbon::now()->subDays(15), 'activity_date' => Carbon::now()->subDays(15)],
						['activitable_id' => Catalog::BAD_LUCK, 'activitable_type' => Type::EXPENSES, 'amount' => 100.00, 'description' => 'Estafa', 'created_at' => Carbon::now()->subDays(10), 'updated_at' => Carbon::now()->subDays(10), 'activity_date' => Carbon::now()->subDays(10)],
						['activitable_id' => Catalog::BAD_LUCK, 'activitable_type' => Type::EXPENSES, 'amount' => 50.00, 'description' => 'Cargo por transferencia :(', 'created_at' => Carbon::now()->subDays(5), 'updated_at' => Carbon::now()->subDays(5), 'activity_date' => Carbon::now()->subDays(5)],
					))
					->count(1))
				->has(Wallet::factory()
					->state(['name' => 'HSBC', 'is_card' => true, 'updated_at' => Carbon::now()->subMonth(), 'created_at' => Carbon::now()->subMonth()])
					->has(Activity::factory()->count(3)->sequence(
						['created_at' => Carbon::now()->subMonth(), 'updated_at' => Carbon::now()->subMonth(), 'activity_date' => Carbon::now()->subMonth()],
						['activitable_id' => Catalog::JOB, 'activitable_type' => Type::EARNINGS, 'amount' => 5000.00, 'description' => 'Pago de nomina', 'created_at' => Carbon::now()->subMonth(), 'updated_at' => Carbon::now()->subMonth(), 'activity_date' => Carbon::now()->subMonth()],
						['activitable_id' => Catalog::TRANSFER_TO_ACCOUNTS, 'activitable_type' => Type::SYSTEM, 'amount' => 5000.00, 'description' => 'Envío de nomina', 'created_at' => Carbon::now()->subMonth(), 'updated_at' => Carbon::now()->subMonth(), 'activity_date' => Carbon::now()->subMonth()],
					))
					->count(1))
				->has(Division::factory()->count(6)->sequence(
					['percent' => 50, 'alias' => 'Básico', 'actual_amount' => 0.00, 'expected_amount' => -50.00],
					['percent' => 15, 'alias' => 'Ahorro', 'actual_amount' => 730.00, 'expected_amount' => 780.00],
					['percent' => 5, 'alias' => 'Donativo', 'actual_amount' => 260.00, 'expected_amount' => 260.00],
					['percent' => 10, 'alias' => 'Fun & Games', 'actual_amount' => 365.00, 'expected_amount' => 365.00],
					['percent' => 10, 'alias' => 'Educación', 'actual_amount' => 520.00, 'expected_amount' => 520.00],
					['percent' => 10, 'alias' => 'Libertad Financiera', 'actual_amount' => 520.00, 'expected_amount' => 520.00]
				))
				->count(1))
			->create([
				'name' => 'Angel David',
				'surname' => 'Escutia',
				'second_surname' => 'Lundez',
				'email' => 'angel.lundez@hotmail.com',
				'password' => Hash::make('Quesolulu23'),
			]);

		User::factory(5)
			->has(
				Account::factory()
					->has(Wallet::factory()
						->has(Activity::factory()->count(1))
						->count(1))
					->has(Division::factory()->count(2)->sequence(['percent' => 20], ['percent' => 80]))
					->count(1)
			)
			->create();
	}
}
