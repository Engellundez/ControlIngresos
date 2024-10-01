<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountMoney extends Model
{
	use HasFactory, SoftDeletes;

	protected $connection = 'sqlsrv';
	protected $table = 'accounts_of_money';
	protected $fillable = [
		'account_id',
		'name',
		'amount',
		'number',
		'is_active',
		'is_card',
		'is_credit',
	];

	// RELATIONS
	public function userAccount(): BelongsTo
	{
		return $this->belongsTo(Account::class, 'id', 'account_id');
	}

	public function activities(): HasMany
	{
		return $this->hasMany(Activity::class, 'account_money_id', 'id');
	}

	public function creditCard()
	{
		return $this->hasOne(CreditCard::class, 'account_money_id', 'id');
	}

	// SCOPES
	public function scopeAccountsOfMoney(Builder $query, $id_account)
	{
		$query->where([['account_id', '=', $id_account], ['is_active', '=', true]]);
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
