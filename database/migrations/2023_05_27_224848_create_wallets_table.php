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
		Schema::create('wallets', function (Blueprint $table) {
			$table->id();
			$table->foreignId('account_id');
			$table->string('name');
			$table->boolean('is_card')->default(0);
			$table->float('amount', 12, 0)->default(0);
			$table->boolean('is_active')->default(0);
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
		Schema::dropIfExists('wallets');
	}
};
