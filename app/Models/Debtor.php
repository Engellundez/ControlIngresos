<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Debtor extends Model
{
	use SoftDeletes;
	protected $table = 'debtors';
	protected $fillable = [
		'account_id',
		'name',
		'surname',
		'second_surname',
		'amount',
		'description'
	];

	// RELATIONS
	public function userAccount(): BelongsTo
	{
		return $this->belongsTo(Account::class, 'id', 'account_id');
	}

	public function scopeMyDebtors(Builder $query, $id_account) {
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
