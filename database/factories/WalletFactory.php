<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Wallet>
 */
class WalletFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */

	protected $model = Wallet::class;

	public function definition(): array
	{
		return [
			'account_id' => Account::all()->random()->id,
			'name' => 'EFECTIVO',
			'is_card' => '0',
			'amount' => 0.0,
			'is_active' => '1',
		];
	}
}
