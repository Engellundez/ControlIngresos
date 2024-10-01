<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\AccountMoney;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Wallet>
 */
class AccountMoneyFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */

	protected $model = AccountMoney::class;

	public function definition(): array
	{
		return [
			'account_id' => Account::all()->random()->id,
			'name' => 'EFECTIVO',
			'amount' => 0.0,
			'number' => null,
			'is_card' => '0',
			'is_active' => '1',
			'is_credit' => '0',
		];
	}
}
