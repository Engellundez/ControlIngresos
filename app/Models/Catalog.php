<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Catalog extends Model
{
	use HasFactory, SoftDeletes;

	protected $connection = 'sqlsrv';
	protected $fillable = [
		'type_id',
		'name',
		'description'
	];

	// SYSTEM
	const WELCOME = 1;

	const TRANSFER_TO_ACCOUNTS = 22;	// TRASPASO DE CUENTAS
	// EARNINGS - INGRESOS
	const JOB = 2;	// TRABAJO
	const DONATION = 3;	// DONACIÓN
	const PRIZE = 4;	// PREMIO
	const SUPPORT = 5;	// APOYO
	const LUCK = 6;	// SUERTE
	const ILLICIT = 7;	// ILEGAL
	const GIFT = 8;	// PREMIO
	const DEBT_PAYMENTS = 9;	// ABONO DE DEUDA
	const SELL_OF_ARTICLES = 10;	// VENTA DE ARTICULOS
	const LOANS = 11;	// PRESTAMOS
	// EXPENSES - GASTOS
	const RENT = 12;	// RENTA
	const MORTGAGE = 13;	// HIPOTECA
	const SUBSCRIPTION_TO_SERVICES = 14; //SUSCRIPCIÓN A SERVICIOS
	const FOOD_AWAY_FROM_HOME = 15;	// COMIDA FUERA DE CASA
	const NON_VITAL_PURCHASE = 16;	// COMPRA NO VITAL
	const VITAL_PURCHASE = 17;	// COMPRA VITAL
	const CLOTHING_FOOTWEAR_BEAUTY_ETC = 18;	// ROPA, CALZADO, BELLEZA ETC
	const ENTERTAINMENT = 19;	// ENTRETENIMIENTO
	const DRUGS = 20;	// DROGAS
	const BAD_LUCK = 21;	// MALA SUERTE

	public function type(): BelongsTo
	{
		return $this->belongsTo(Type::class, 'type_id', 'id');
	}

	public function scopeActivitiesForUser(Builder $query) {
		$available_types = Type::TYPES_FOR_USERS;
		$query->whereIntegerInRaw('type_id', $available_types)->orderBy('name');
	}
}
