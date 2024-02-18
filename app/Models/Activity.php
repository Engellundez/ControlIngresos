<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Activity extends Model
{
	use HasFactory;

	protected $fillable = [
		'wallet_id',
		'activitable_id',
		'activitable_type',
		'amount',
		'activity_date',
		'description'
	];

	protected $appends = ['formatted_activity_date', 'motion'];
	// RELATIONS
	public function wallet(): BelongsTo
	{
		return $this->belongsTo(Wallet::class, 'id', 'wallet_id');
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

	// ATTRIBUTES
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
