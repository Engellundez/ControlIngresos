<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CreditCard extends Model
{
	use HasFactory, SoftDeletes;

	protected $connection = 'sqlsrv';
	protected $fillable = [
		'account_money_id',
		'limit_credit',
		'cut_off_date',
		'payment_deadline',
	];

	// RELATIONS
	public function account_money(): BelongsTo
	{
		return $this->belongsTo(AccountMoney::class, 'account_money_id', 'id');
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
