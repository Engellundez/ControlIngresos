<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Type extends Model
{
	use HasFactory, SoftDeletes;

	protected $fillable = [
		'name',
		'description'
	];

	const EARNINGS = 1;	// INGRESOS
	const EXPENSES = 2;	// GASTOS
	const SYSTEM = 3;	// SISTEMA
	const LOSSES = 4;	// PERDIDA
	const FORMATS_PAYMENTS = 5;	// PAGOS

	const TYPES_FOR_USERS = [
		self::EARNINGS,
		self::EXPENSES,
		self::LOSSES
	];

	public function scopeTypesForUsers(Builder $query)
	{
		$query->where('user_can_use', 1)->orderby('name');
	}
}
