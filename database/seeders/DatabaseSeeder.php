<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Account;
use App\Models\Activity;
use App\Models\Division;
use App\Models\Wallet;
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

		$five = Carbon::now()->subDays(5)->subMinutes(5);
		$teen = Carbon::now()->subDays(5)->subMinutes(10);
		$fifteen = Carbon::now()->subDays(6);

		Account::factory()
			->state([
				'user_id' => 1,
				'alias' => 'Engellundez',
				'total_count' => 0.0
			])
			->has(Wallet::factory()
				->state(['name' => 'EFECTIVO', 'is_card' => false, 'updated_at' => $fifteen, 'created_at' => $fifteen])
				->has(Activity::factory()->state(
					['account_id' => 1, 'created_at' => $teen, 'updated_at' => $teen, 'activity_date' => $teen],
				))
				->count(1))
			->has(Wallet::factory()
				->state(['name' => 'BBVA', 'is_card' => true, 'updated_at' => $fifteen, 'created_at' => $fifteen])
				->has(Activity::factory()->state(
					['account_id' => 1, 'created_at' => $teen, 'updated_at' => $teen, 'activity_date' => $teen],
				))
				->count(1))
			->has(Wallet::factory()
				->state(['name' => 'HSBC', 'is_card' => true, 'updated_at' => $fifteen, 'created_at' => $fifteen])
				->has(Activity::factory()->state(
					['account_id' => 1, 'created_at' => $five, 'updated_at' => $five, 'activity_date' => $five],
				))
				->count(1))
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
