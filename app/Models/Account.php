<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
	use HasFactory, SoftDeletes;
	protected $connection = 'sqlsrv';
	protected $fillable = [
		'user_id',
		'alias',
		'total_count',
	];

	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class, 'id', 'user_id');
	}

	public function accountMoney(): HasMany
	{
		return $this->hasMany(AccountMoney::class, 'account_id', 'id');
	}

	public function division(): HasMany
	{
		return $this->hasMany(Division::class, 'account_id', 'id');
	}

	public function debtors(): HasMany
	{
		return $this->hasMany(Debtor::class, 'account_id', 'id');
	}

	public function activities(): HasMany
	{
		return $this->hasMany(Activity::class, 'account_id', 'id');
	}

	// SCOPES
	public function scopeGetAccountInSession(Builder $query) {
		return $query->where('user_id', Auth()->user()->id)->first();
	}

	public function scopeGetIdAccountInSession(Builder $query) {
		return $query->GetAccountInSession()->id;
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
