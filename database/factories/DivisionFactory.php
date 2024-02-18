<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\Division;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Division>
 */
class DivisionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Division::class;

    public function definition(): array
    {
        return [
			'alias' => $this->faker->userName(),
            'account_id' => Account::all()->random()->id,
            'percent' => 30,
        ];
    }
}
