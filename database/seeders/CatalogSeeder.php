<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatalogSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		// TIPOS CATÁLOGOS
		DB::table('types')->insert([
			'name' => 'Ingresos',
			'description' => 'Dinero obtenido por alguna labor o servicio u otro.',
			'user_can_use' => 1,
		]);
		DB::table('types')->insert([
			'name' => 'Gastos',
			'description' => 'Dinero que se usa para comprar cosas.',
			'user_can_use' => 1,
		]);
		DB::table('types')->insert([
			'name' => 'Sistema',
			'description' => 'El sistema ha realizado un movimiento, pero descuida no es relevante :3'
		]);
		DB::table('types')->insert([
			'name' => 'Perdidas',
			'description' => 'Dinero que ya no volviste a encontrar, o perdiste por distraído, o alguna mala inversion o préstamo.',
			'user_can_use' => 1,
		]);
		DB::table('types')->insert([
			'name' => 'Métodos de pago',
			'description' => 'La forma en que se pagan las deudas que tenemos guardadas en nuestra cuenta.'
		]);


		// SISTEMA
		DB::table('catalogs')->insert([
			'type_id' => Type::SYSTEM,
			'name' => 'Bienvenida',
			'description' => 'Bienvenida a tu wallet y su tipo de división que debe elegir.',
		]);


		// INGRESOS
		DB::table('catalogs')->insert([
			'type_id' => Type::EARNINGS,
			'name' => 'Trabajo',
			'description' => 'Actividad física o intelectual que las personas realizan para alcanzar un objetivo o satisfacer una necesidad, mediante la producción de bienes y/o servicios.'
		]);
		DB::table('catalogs')->insert([
			'type_id' => Type::EARNINGS,
			'name' => 'Donativo',
		]);
		DB::table('catalogs')->insert([
			'type_id' => Type::EARNINGS,
			'name' => 'Premio',
		]);
		DB::table('catalogs')->insert([
			'type_id' => Type::EARNINGS,
			'name' => 'Becas o Apoyo',
		]);
		DB::table('catalogs')->insert([
			'type_id' => Type::EARNINGS,
			'name' => 'Suerte',
		]);
		DB::table('catalogs')->insert([
			'type_id' => Type::EARNINGS,
			'name' => 'Ilícito',
		]);
		DB::table('catalogs')->insert([
			'type_id' => Type::EARNINGS,
			'name' => 'Regalo',
		]);
		DB::table('catalogs')->insert([
			'type_id' => Type::EARNINGS,
			'name' => 'Abonos de deuda',
		]);
		DB::table('catalogs')->insert([
			'type_id' => Type::EARNINGS,
			'name' => 'Venta de artículos',
		]);
		DB::table('catalogs')->insert([
			'type_id' => Type::EARNINGS,
			'name' => 'Préstamo(s)',
		]);


		// GASTOS
		DB::table('catalogs')->insert([
			'type_id' => Type::EXPENSES,
			'name' => 'Renta',
		]);
		DB::table('catalogs')->insert([
			'type_id' => Type::EXPENSES,
			'name' => 'Hipoteca',
		]);
		DB::table('catalogs')->insert([
			'type_id' => Type::EXPENSES,
			'name' => 'Suscripción a servicios',
			'description' => 'Aquí entra, Luz, Agua, Gasolina, Internet, Streaming, GYM, y todo con suscripción.',
		]);
		DB::table('catalogs')->insert([
			'type_id' => Type::EXPENSES,
			'name' => 'Comida fuera de casa',
			'description' => 'Comida corrida, comida chatarra o restaurantes.'
		]);
		DB::table('catalogs')->insert([
			'type_id' => Type::EXPENSES,
			'name' => 'Compra no vital.',
			'description' => 'Cigarros, Cafe, Galletas, Gusguerias, etc.',
		]);
		DB::table('catalogs')->insert([
			'type_id' => Type::EXPENSES,
			'name' => 'Compra vital.',
			'description' => 'Despensa, Super, etc.',
		]);
		DB::table('catalogs')->insert([
			'type_id' => Type::EXPENSES,
			'name' => 'Ropa, Calzado, Belleza, etc.',
		]);
		DB::table('catalogs')->insert([
			'type_id' => Type::EXPENSES,
			'name' => 'Entretenimiento/Salidas',
			'description' => 'Salidas con amigos, o solo al cine, a disfrutar de una peli, concierto, etc.'
		]);
		DB::table('catalogs')->insert([
			'type_id' => Type::EXPENSES,
			'name' => 'Droga(s)',
		]);
		DB::table('catalogs')->insert([
			'type_id' => Type::SYSTEM,
			'name' => 'Traspaso a cuentas',
		]);


		// Formas de perdida
		DB::table('catalogs')->insert([
			'type_id' => Type::LOSSES,
			'name' => 'Lavadora',
		]);
		DB::table('catalogs')->insert([
			'type_id' => Type::LOSSES,
			'name' => 'No recuerdo',
		]);
		DB::table('catalogs')->insert([
			'type_id' => Type::LOSSES,
			'name' => 'Mala suerte',
		]);


		//TIPOS DE PAGO
		DB::table('catalogs')->insert([
			'type_id' => Type::PAYMENTS,
			'name' => 'Diario (1 Día)',
		]);
		DB::table('catalogs')->insert([
			'type_id' => Type::PAYMENTS,
			'name' => 'Semanal (7 Días)',
		]);
		DB::table('catalogs')->insert([
			'type_id' => Type::PAYMENTS,
			'name' => 'Quincenal (2 Semanas)',
		]);
		DB::table('catalogs')->insert([
			'type_id' => Type::PAYMENTS,
			'name' => 'Mensual (4 Semanas)',
		]);
		DB::table('catalogs')->insert([
			'type_id' => Type::PAYMENTS,
			'name' => 'Bimestral (2 Meses)',
		]);
		DB::table('catalogs')->insert([
			'type_id' => Type::PAYMENTS,
			'name' => 'Trimestral (3 Meses)',
		]);
		DB::table('catalogs')->insert([
			'type_id' => Type::PAYMENTS,
			'name' => 'Cuatrimestral (4 Meses)',
		]);
		DB::table('catalogs')->insert([
			'type_id' => Type::PAYMENTS,
			'name' => 'Semestral (6 Meses)',
		]);
		DB::table('catalogs')->insert([
			'type_id' => Type::PAYMENTS,
			'name' => 'Anual (12 Meses)',
		]);
	}
}
