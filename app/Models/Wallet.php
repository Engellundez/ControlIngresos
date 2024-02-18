<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Wallet extends Model
{
	use HasFactory;

	protected $fillable = [
		'account_id',
		'name',
		'is_active'
	];

	// RELATIONS
	public function account(): BelongsTo
	{
		return $this->belongsTo(Account::class, 'id', 'account_id');
	}

	public function activities(): HasMany
	{
		return $this->hasMany(Activity::class, 'wallet_id', 'id')->latest();
	}

	// SCOPES
	public function scopeWallets(Builder $query, $id_account): void
	{
		$query->where([['account_id', '=', $id_account], ['is_active', '=', true]])->latest();
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
