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
		DB::table('catalogos')->insert([
			'name' => 'Trabajo',
			'descripcion' => 'Dinero Recibido por parte del empleo',
			'tipo_id' => 2,
		]);
		DB::table('catalogos')->insert([
			'name' => 'Inversion',
			'descripcion' => 'Como todo un empresario',
			'tipo_id' => 2,
		]);
		DB::table('catalogos')->insert([
			'name' => 'Fideicomiso',
			'descripcion' => 'Mira mamá sin manos',
			'tipo_id' => 2,
		]);
		DB::table('catalogos')->insert([
			'name' => 'Regalo',
			'descripcion' => 'Donación anonima de un colega',
			'tipo_id' => 2,
		]);
		DB::table('catalogos')->insert([
			'name' => 'Suerte',
			'descripcion' => 'Eres un chic@ con suerte y lo encontraste',
			'tipo_id' => 2,
		]);
		DB::table('catalogos')->insert([
			'name' => 'Primera Necesidad',
			'descripcion' => 'Gastos de primera necesidad',
			'tipo_id' => 3,
		]);
		DB::table('catalogos')->insert([
			'name' => 'Transporte',
			'descripcion' => 'Gastos en movilidad',
			'tipo_id' => 3,
		]);
		DB::table('catalogos')->insert([
			'name' => 'Botanas',
			'descripcion' => 'Gastos en botana, golocinas, chucherias, etc.',
			'tipo_id' => 3,
		]);
		DB::table('catalogos')->insert([
			'name' => 'Educación',
			'descripcion' => 'Gastos hechos en educación',
			'tipo_id' => 3,
		]);
		DB::table('catalogos')->insert([
			'name' => 'Diversión',
			'descripcion' => 'Gastos hechos alguna actividad divertida',
			'tipo_id' => 3,
		]);
		DB::table('catalogos')->insert([
			'name' => 'Donativo',
			'descripcion' => 'Dinero donado a alguna beneficiencia o persona que lo requiriera',
			'tipo_id' => 3,
		]);
		DB::table('catalogos')->insert([
			'name' => 'Alucinogenos',
			'descripcion' => '¿Qué estas haciendo al gastar en esto?',
			'tipo_id' => 3,
		]);
		DB::table('catalogos')->insert([
			'name' => 'Alucinogenos',
			'descripcion' => '¿Qué estas haciendo al gastar en esto?',
			'tipo_id' => 3,
		]);
		DB::table('users')->insert([
			'name' => 'Engellundez',
			'email' => 'angel.lundez@hotmail.com',
			'password' => '$2y$10$nqFdcyjv1qy.FBak8EB1gua2Xe.JkZcwdki/xIKx2T.ivvcvDriFi',
			'created_at' => '2022-06-21 02:42:14.497',
			'updated_at' => '2022-06-21 02:42:14.497',
		]);
	}
}
