<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Division extends Model
{
	use HasFactory;

	protected $fillable = [
		'alias',
		'account_id',
		'percent',
		'actual_amount',
		'expected_amount'
	];

	public function account(): BelongsTo
	{
		return $this->belongsTo(Account::class, 'id', 'account_id');
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
