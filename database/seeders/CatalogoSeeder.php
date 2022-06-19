<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatalogoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('catalogos')->insert([
			'name' => 'Super-Admin',
			'descripcion' => 'Acceso total',
			'tipo_id' => 1,
		]);
        DB::table('catalogos')->insert([
			'name' => 'Administrador',
			'descripcion' => 'Acceso total',
			'tipo_id' => 1,
		]);
        DB::table('catalogos')->insert([
			'name' => 'Usuario',
			'descripcion' => 'Acceso total',
			'tipo_id' => 1,
		]);
    }
}
