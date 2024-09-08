<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activity extends Model
{
	use HasFactory, SoftDeletes;

	protected $connection = 'sqlsrv';
	protected $fillable = [
		'account_id',
		'activitable_id',
		'activitable_type',
		'description',
		'amount',
		'activity_date',
		'wallet_id',
	];

	protected $appends = ['formatted_activity_date', 'wallet_name', 'motion'];
	// RELATIONS
	public function wallet(): BelongsTo
	{
		return $this->belongsTo(Wallet::class, 'wallet_id', 'id');
	}

	public function motionRelation(): BelongsTo
	{
		return $this->belongsTo(Catalog::class, 'activitable_id', 'id');
	}
	// ATTRIBUTES
	public function getMotionAttribute()
	{
		return $this->motionRelation->name;
	}

	public function getWalletNameAttribute()
	{
		return $this->wallet->name ?? 'S/D';
	}

	public function getFormattedActivityDateAttribute()
	{
		return Carbon::parse($this->activity_date)->format('d-m-Y');
	}

	public function getFormattedCreatedAtAttribute()
	{
		return $this->created_at->format('H:i d-m-Y');
	}

	public function getFormattedUpdatedAtAttribute()
	{
		return $this->updated_at->format('H:i d-m-Y');
	}
}
