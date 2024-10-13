<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\AccountMoney;
use App\Models\Activity;
use App\Models\CreditCard;
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

		$now = Carbon::now()->subDays(6);

		Account::factory()
			->state([
				'user_id' => 1,
				'alias' => 'Engellundez',
				'total_count' => 0.0
			])
			->has(AccountMoney::factory()
				->state(['name' => 'EFECTIVO', 'is_card' => false, 'amount' => 16627, 'updated_at' => $now, 'created_at' => $now])
				->has(Activity::factory()->state(
					['account_id' => 1, 'created_at' => $now, 'updated_at' => $now, 'activity_date' => $now, 'amount' => 16627, 'last_amount' => 16627],
				))->count(1), 'accountsOfMoney')


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



			// ->has(AccountMoney::factory()
			// 	->state(['name' => 'BBVA', 'is_card' => true, 'number' => '4152314103336403', 'updated_at' => $now, 'created_at' => $now])
			// 	->has(Activity::factory()->state(
			// 		['created_at' => $now, 'updated_at' => $now, 'activity_date' => $now],
			// 	))
			// 	->count(1), 'accountsOfMoney')


			// ->has(AccountMoney::factory()
			// 	->state(['name' => 'BBVA NOMINA', 'amount' => 10234.56, 'number' => '4152313670056469', 'is_card' => true, 'is_credit' => 0, 'created_at' => $now, 'updated_at' => $now])
			// 	->has(Activity::factory()->state(
			// 		['amount' => 10234.56, 'last_amount' => 10234.56, 'activity_date' => $now, 'created_at' => $now, 'updated_at' => $now],
			// 	))
			// 	->count(1), 'accountsOfMoney')


			// ->has(AccountMoney::factory()
			// 	->state(['name' => 'BBVA CRÉDITO', 'amount' => 24809.09, 'number' => '4772913061254076', 'is_card' => true, 'is_credit' => 1, 'created_at' => $now, 'updated_at' => $now])
			// 	->has(CreditCard::factory()->state(
			// 		['limit_credit' => 24765, 'cut_off_date' => '2024-10-07', 'payment_deadline' => '2024-10-28']
			// 	))
			// 	->count(1)
			// 	->has(Activity::factory()->state(
			// 		['amount' => 44.09, 'last_amount' => 44.09, 'activity_date' => $now, 'created_at' => $now, 'updated_at' => $now],
			// 	))
			// 	->count(1), 'accountsOfMoney')


			// ->has(AccountMoney::factory()
			// 	->state(['name' => 'NU (AHORRO)', 'amount' => 14584.37, 'number' => '5101258626334008', 'is_card' => true, 'is_credit' => 0, 'created_at' => $now, 'updated_at' => $now])
			// 	->count(1)
			// 	->has(Activity::factory()->state(
			// 		['amount' => 14584.37, 'last_amount' => 14584.37, 'activity_date' => $now, 'created_at' => $now, 'updated_at' => $now],
			// 	))
			// 	->count(1), 'accountsOfMoney')


			// ->has(AccountMoney::factory()
			// 	->state(['name' => 'NU CRÉDITO', 'amount' => 7687.5, 'number' => '5267774934749273', 'is_card' => true, 'is_credit' => 1, 'created_at' => $now, 'updated_at' => $now])
			// 	->has(CreditCard::factory()->state(
			// 		['limit_credit' => 8000, 'cut_off_date' => '2024-10-17', 'payment_deadline' => '2024-10-27']
			// 	))
			// 	->count(1)
			// 	->has(Activity::factory()->state(
			// 		['amount' => -312.5, 'last_amount' => -312.5, 'activity_date' => $now, 'created_at' => $now, 'updated_at' => $now],
			// 	))
			// 	->count(1), 'accountsOfMoney')


			// ->has(AccountMoney::factory()
			// 	->state(['name' => 'HSBC ZERO UE', 'amount' => 1937.28, 'number' => '4524216008705684', 'is_card' => true, 'is_credit' => 1, 'created_at' => $now, 'updated_at' => $now])
			// 	->has(CreditCard::factory()->state(
			// 		['limit_credit' => 5300, 'cut_off_date' => '2024-09-12', 'payment_deadline' => '2024-10-02']
			// 	))
			// 	->count(1)
			// 	->has(Activity::factory()->state(
			// 		['amount' => -3362.72, 'last_amount' => -3362.72, 'activity_date' => $now, 'created_at' => $now, 'updated_at' => $now],
			// 	))
			// 	->count(1), 'accountsOfMoney')


			// ->has(AccountMoney::factory()
			// 	->state(['name' => 'HSBC ZERO 9k', 'amount' => 9000, 'number' => '4524216008705684', 'is_card' => true, 'is_credit' => 1, 'created_at' => $now, 'updated_at' => $now])
			// 	->has(CreditCard::factory()->state(
			// 		['limit_credit' => 9000, 'cut_off_date' => '2024-09-12', 'payment_deadline' => '2024-10-02']
			// 	))
			// 	->count(1)
			// 	->has(Activity::factory()->state(
			// 		['activity_date' => $now, 'created_at' => $now, 'updated_at' => $now],
			// 	))
			// 	->count(1), 'accountsOfMoney')


			// ->has(AccountMoney::factory()
			// 	->state(['name' => 'HSBC VIVA', 'amount' => 8592, 'number' => '5412788804265552', 'is_card' => true, 'is_credit' => 1, 'created_at' => $now, 'updated_at' => $now])
			// 	->has(CreditCard::factory()->state(
			// 		['limit_credit' => 9000, 'cut_off_date' => '2024-09-22', 'payment_deadline' => '2024-10-12']
			// 	))
			// 	->count(1)
			// 	->has(Activity::factory()->state(
			// 		['amount' => -408, 'last_amount' => -408, 'activity_date' => $now, 'created_at' => $now, 'updated_at' => $now],
			// 	))
			// 	->count(1), 'accountsOfMoney')
