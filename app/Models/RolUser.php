<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RolUser extends Model
{
	use HasFactory, SoftDeletes;

	protected $connection = 'users_connection';
	protected $fillable = [
		'user_id',
		'rol_id',
	];
}
