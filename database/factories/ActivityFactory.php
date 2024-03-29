<?php

namespace Database\Factories;

use App\Models\Activity;
use App\Models\Catalog;
use App\Models\Type;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Activity>
 */
class ActivityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Activity::class;

    public function definition(): array
    {
        return [
            'wallet_id' => Wallet::all()->random()->id,
            'activitable_id' => Catalog::where('name', 'Bienvenida')->where('type_id', Type::SYSTEM)->first()->id,
            'activitable_type' => Type::SYSTEM,
            'activity_date' => now(),
            'description' => 'Bienvenido al Sistema de Control de Ingresos 😎'
        ];
    }
}
