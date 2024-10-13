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
        Schema::create('debts', function (Blueprint $table) {
			$table->id();
			$table->foreignId('account_id');
			$table->boolean('is_credit_card')->default(0);
			$table->foreignId('credit_card_id')->nullable();
			$table->string('name');
			$table->string('surname')->nullable();
			$table->string('second_surname')->nullable();
			$table->float('amount', 12, 0)->default(0);
			$table->float('amount_paid', 12, 0)->default(0);
			$table->integer('months_to_paid')->default(0);
			$table->date('next_payment')->nullable();
			$table->text('description')->nullable();
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
        Schema::dropIfExists('debts');
    }
};
