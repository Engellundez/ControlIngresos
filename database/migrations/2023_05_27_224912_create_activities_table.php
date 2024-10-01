<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::create('activities', function (Blueprint $table) {
			$table->id();
			$table->foreignId('account_id');
			$table->morphs('activitable');
			$table->text('description')->nullable();
			$table->float('amount', 12, 0)->default(0);
			$table->date('activity_date');
			$table->foreignId('account_money_id');
			$table->timestamps();
			$table->softDeletes();

			$table->foreign('account_id')->references('id')->on('accounts');
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('activities');
	}
};
