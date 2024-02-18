<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Account extends Model
{
	use HasFactory;

	protected $fillable = [
		'user_id',
		'alias',
	];

	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class, 'id', 'user_id');
	}

	public function wallets(): HasMany
	{
		return $this->hasMany(Wallet::class, 'account_id', 'id');
	}

	public function division(): HasMany
	{
		return $this->hasMany(Division::class, 'account_id', 'id');
	}

	// ATTRIBUTES
	public function getFormattedCreatedAtAttribute()
	{
		return $this->created_at->format('H:i d-m-Y');
	}

	public function getFormattedUpdatedAtAttribute()
	{
		return $this->updated_at->format('H:i d-m-Y');
	}
}
