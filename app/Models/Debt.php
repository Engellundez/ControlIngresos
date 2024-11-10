<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Debt extends Model
{
	use SoftDeletes;

	protected $table = 'debts';
	protected $fillable = [
		'account_id',
		'is_credit_card',
		'credit_card_id',
		'name',
		'surname',
		'second_surname',
		'amount',
		'amount_paid',
		'months_to_paid',
		'next_payment',
		'description'
	];

	// RELATIONS
	public function userAccount(): BelongsTo
	{
		return $this->belongsTo(Account::class, 'id', 'account_id');
	}

	public function scopeMyDebts(Builder $query, $id_account) {
		return $query->where([['account_id', '=', $id_account]]);
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
