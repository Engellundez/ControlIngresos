<?php

namespace Database\Factories;

use App\Models\AccountMoney;
use App\Models\CreditCard;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CreditCard>
 */
class CreditCardFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */

	protected $model = CreditCard::class;

	public function definition(): array
	{
		return [
			'account_money_id' => AccountMoney::all()->random()->id,
			'cut_off_date' => now(),
			'payment_deadline' => now(),
		];
	}
}
