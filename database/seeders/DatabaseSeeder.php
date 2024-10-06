<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\AccountMoney;
use App\Models\Activity;
use App\Models\Division;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

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

		$yesterday = Carbon::now()->subDay();

		Account::factory()
			->state([
				'user_id' => 1,
				'alias' => 'Engellundez',
				'total_count' => 0.0
			])
			->has(AccountMoney::factory()
				->state(['name' => 'EFECTIVO', 'is_card' => false, 'updated_at' => $yesterday, 'created_at' => $yesterday])
				->has(Activity::factory()->state(
					['account_id' => 1, 'created_at' => $yesterday, 'updated_at' => $yesterday, 'activity_date' => $yesterday],
				))
				->count(1), 'accountsOfMoney')
			->has(Division::factory()->count(6)->sequence(
				['percent' => 50, 'alias' => 'Básico', 'actual_amount' => 0.0, 'expected_amount' => 0.0],
				['percent' => 15, 'alias' => 'Ahorro', 'actual_amount' => 0.0, 'expected_amount' => 0.0],
				['percent' => 10, 'alias' => 'Fun & Games', 'actual_amount' => 0.0, 'expected_amount' => 0.0],
				['percent' => 10, 'alias' => 'Educación', 'actual_amount' => 0.0, 'expected_amount' => 0.0],
				['percent' => 10, 'alias' => 'Libertad Financiera', 'actual_amount' => 0.0, 'expected_amount' => 0.0],
				['percent' => 5, 'alias' => 'Mascotas', 'actual_amount' => 0.0, 'expected_amount' => 0.0],
			))
			->create();
	}
}
