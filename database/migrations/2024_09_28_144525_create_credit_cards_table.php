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
		Schema::create('credit_cards', function (Blueprint $table) {
			$table->id();
			$table->foreignId('account_money_id');
			$table->float('limit_credit', 12,2)->default(0);
			$table->date('cut_off_date');
			$table->date('payment_deadline');
			$table->timestamps();
			$table->softDeletes();

			$table->foreign('account_money_id')->references('id')->on('accounts_of_money');
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('credit_cards');
	}
};
