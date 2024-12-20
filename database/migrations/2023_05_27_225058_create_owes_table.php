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
		Schema::create('owes', function (Blueprint $table) {
			$table->id();
			$table->foreignId('activity_id');
			$table->foreignId('debtor_id');
			$table->timestamps();

			$table->foreign('debtor_id')->references('id')->on('debtors');
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('owes');
	}
};
