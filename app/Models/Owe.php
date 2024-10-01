<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Owe extends Model
{
	use HasFactory;

	protected $fillable = [
		'debtor_id',
		'activity_id'
	];

	// RELATIONS
	public function debtor(): BelongsTo
	{
		return $this->belongsTo(Debtor::class, 'id', 'debtor_id');
	}

	public function activity(): BelongsTo
	{
		return $this->belongsTo(Activity::class, 'id', 'activity_id');
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
