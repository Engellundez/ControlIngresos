<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
	use HasFactory;

	protected $connection = 'users_connection';
	protected $fillable = [
		'name',
		'description',
	];
}
