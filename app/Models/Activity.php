<?php

namespace App\Models;

use App\Http\Controllers\Controller;
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
		'account_money_id',
	];

	protected $appends = ['formatted_activity_date', 'account_money_name', 'motion'];
	// RELATIONS
	public function account_money(): BelongsTo
	{
		return $this->belongsTo(AccountMoney::class, 'account_money_id', 'id');
	}

	public function motion_relation(): BelongsTo
	{
		return $this->belongsTo(Catalog::class, 'activitable_id', 'id');
	}
	// ATTRIBUTES
	public function getMotionAttribute()
	{
		return $this->motion_relation->name;
	}

	public function getAccountMoneyNameAttribute()
	{
		if (Controller::strToBool($this->account_money?->is_card)) {
			return $this->account_money->name . ' ' . substr($this->account_money->number, -4);
		}

		return $this->account_money->name ?? 'S/D';
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
