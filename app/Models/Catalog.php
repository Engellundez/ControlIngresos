<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Catalog extends Model
{
	use SoftDeletes;

	protected $connection = 'sqlsrv';
	protected $fillable = [
		'type_id',
		'name',
		'description'
	];

	// SYSTEM
	const WELCOME = 1;
	const EDIT_ACCOUNT_MONEY = 2;

	// const TRANSFER_TO_ACCOUNTS = 22;	// TRASPASO DE CUENTAS
	// EARNINGS - INGRESOS
	const JOB = 3;	// TRABAJO
	const DONATION = 4;	// DONACIÓN
	const PRIZE = 5;	// PREMIO
	const SUPPORT = 6;	// APOYO
	const LUCK = 7;	// SUERTE
	const ILLICIT = 8;	// ILEGAL
	const GIFT = 9;	// PREMIO
	const DEBT_PAYMENTS = 10;	// ABONO DE DEUDA
	const SELL_OF_ARTICLES = 11;	// VENTA DE ARTICULOS
	const LOANS = 12;	// PRESTAMOS
	const TRANSFER_TO_ACCOUNTS_EARNINGS = 13;	// TRASPASO DE CUENTAS INGRESOS
	// EXPENSES - GASTOS
	const RENT = 14;	// RENTA
	const MORTGAGE = 15;	// HIPOTECA
	const SUBSCRIPTION_TO_SERVICES = 16; //SUSCRIPCIÓN A SERVICIOS
	const FOOD_AWAY_FROM_HOME = 17;	// COMIDA FUERA DE CASA
	const NON_VITAL_PURCHASE = 18;	// COMPRA NO VITAL
	const VITAL_PURCHASE = 19;	// COMPRA VITAL
	const CLOTHING_FOOTWEAR_BEAUTY_ETC = 20;	// ROPA, CALZADO, BELLEZA ETC
	const ENTERTAINMENT = 21;	// ENTRETENIMIENTO
	const DRUGS = 22;	// DROGAS
	const TRANSFER_TO_ACCOUNTS_EXPENSES = 23;	// TRASPASO DE CUENTAS INGRESOS
	const DEBT = 24;	// ADEUDO
	const WASHING_MACHINE = 25;	// LAVADORA
	const NON_REMEMBER = 26;	// NO RECUERDO
	const BAD_LUCK = 27;	// MALA SUERTE

	public function type(): BelongsTo
	{
		return $this->belongsTo(Type::class, 'type_id', 'id');
	}

	public function scopeActivitiesForUser(Builder $query) {
		$available_types = Type::TYPES_FOR_USERS;
		$query->whereIntegerInRaw('type_id', $available_types)->orderBy('name');
	}

	public function scopePaymentMethods(Builder $query) {
		$query->where('type_id', Type::FORMATS_PAYMENTS);
	}
}
