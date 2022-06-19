<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipos')->insert([
			'name' => 'Roles',
			'descripcion' => 'Este es el tipo de todos los roles que habra en el sistema',
		]);
        DB::table('tipos')->insert([
			'name' => 'Gastos',
			'descripcion' => 'Este es el tipo de todos los roles que habra en el sistema',
		]);
    }
}
