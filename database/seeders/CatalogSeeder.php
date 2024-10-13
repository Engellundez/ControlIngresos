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
		DB::table('catalogs')->insert([
			'type_id' => Type::SYSTEM,
			'name' => 'Edición de la cuenta',
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
		DB::table('catalogs')->insert([
			'type_id' => Type::EARNINGS,
			'name' => 'Traspaso a cuentas',
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
			'type_id' => Type::EXPENSES,
			'name' => 'Traspaso a cuentas',
		]);
		DB::table('catalogs')->insert([
			'type_id' => Type::EXPENSES,
			'name' => 'Adeudo',
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
			'type_id' => Type::FORMATS_PAYMENTS,
			'name' => 'De contado (En el siguiente corte)',
			'description' => '0',
		]);
		DB::table('catalogs')->insert([
			'type_id' => Type::FORMATS_PAYMENTS,
			'name' => 'Semanal (7 Días)',
			'description' => '.25',
		]);
		DB::table('catalogs')->insert([
			'type_id' => Type::FORMATS_PAYMENTS,
			'name' => 'Quincenal (2 Semanas)',
			'description' => '.5',
		]);
		DB::table('catalogs')->insert([
			'type_id' => Type::FORMATS_PAYMENTS,
			'name' => 'Mensual (4 Semanas)',
			'description' => '1',
		]);
		DB::table('catalogs')->insert([
			'type_id' => Type::FORMATS_PAYMENTS,
			'name' => 'Bimestral (2 Meses)',
			'description' => '2',
		]);
		DB::table('catalogs')->insert([
			'type_id' => Type::FORMATS_PAYMENTS,
			'name' => 'Trimestral (3 Meses)',
			'description' => '3',
		]);
		DB::table('catalogs')->insert([
			'type_id' => Type::FORMATS_PAYMENTS,
			'name' => 'Cuatrimestral (4 Meses)',
			'description' => '4',
		]);
		DB::table('catalogs')->insert([
			'type_id' => Type::FORMATS_PAYMENTS,
			'name' => 'Semestral (6 Meses)',
			'description' => '6',
		]);
		DB::table('catalogs')->insert([
			'type_id' => Type::FORMATS_PAYMENTS,
			'name' => 'Anual (12 Meses)',
			'description' => '12',
		]);
		DB::table('catalogs')->insert([
			'type_id' => Type::FORMATS_PAYMENTS,
			'name' => 'Quince Meses (15 Meses)',
			'description' => '15',
		]);
		DB::table('catalogs')->insert([
			'type_id' => Type::FORMATS_PAYMENTS,
			'name' => 'Dieciocho (18 Meses)',
			'description' => '18',
		]);
		DB::table('catalogs')->insert([
			'type_id' => Type::FORMATS_PAYMENTS,
			'name' => '2 años (24 Meses)',
			'description' => '24',
		]);
		DB::table('catalogs')->insert([
			'type_id' => Type::FORMATS_PAYMENTS,
			'name' => '3 años (36 Meses)',
			'description' => '36',
		]);
		DB::table('catalogs')->insert([
			'type_id' => Type::FORMATS_PAYMENTS,
			'name' => '4 años (48 Meses)',
			'description' => '48',
		]);
		DB::table('catalogs')->insert([
			'type_id' => Type::FORMATS_PAYMENTS,
			'name' => '5 años (60 Meses)',
			'description' => '60',
		]);
	}
}
