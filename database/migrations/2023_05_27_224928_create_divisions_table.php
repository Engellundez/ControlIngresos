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
		Schema::create('divisions', function (Blueprint $table) {
			$table->id();
			$table->string('alias');
			$table->foreignId('account_id');
			$table->integer('percent');
			$table->float('actual_amount', 12, 0)->default(0);
			$table->float('expected_amount', 12, 0)->default(0);
			$table->timestamps();

			$table->foreign('account_id')->references('id')->on('accounts');
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('divisions');
	}
};
