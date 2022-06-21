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
		DB::table('users')->insert([
			'name' => 'Engellundez',
			'email' => 'angel.lundez@hotmail.com',
			'password' => '$2y$10$nqFdcyjv1qy.FBak8EB1gua2Xe.JkZcwdki/xIKx2T.ivvcvDriFi',
			'created_at' => '2022-06-21 02:42:14.497',
			'updated_at' => '2022-06-21 02:42:14.497',
		]);
		DB::table('ingresos')->insert([
			'user_id' => '1',
			'proviene' => 'Trabajo',
			'cantidad' => 5603.19,
			'fecha_ingresos' => '2022-06-20',
			'created_at' => '2022-06-21 02:42:14.497',
			'updated_at' => '2022-06-21 02:42:14.497',
		]);
    }
}
