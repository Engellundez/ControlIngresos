<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingreso extends Model
{
	use HasFactory;
	protected $table		= 'Ingresos';
	protected $primaryKey 	= 'id';
	protected $fillable 	= [
		'user_id',
		'tipo_ingreso_id',
		'cantidad',
		'fecha_ingresos',
	];
	protected $hidden		= [
		'created_at',
		'updated_at',
	];
	protected $with			= [
		'usuario',
	];

	public function usuario(){
		return $this->belongsTo(User::class, 'user_id');
	}
}
