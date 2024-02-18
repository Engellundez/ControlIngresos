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
            $table->foreignId('pay_type_id');
            $table->foreignId('activity_id');
            $table->text('description')->nullable();
            $table->float('amount',12,0)->default(0);
            $table->float('payment',12,0)->default(0);
            $table->date('payment_date');
            $table->timestamps();

            $table->foreign('account_id')->references('id')->on('accounts');
            $table->foreign('pay_type_id')->references('id')->on('catalogs');
            $table->foreign('activity_id')->references('id')->on('activities');
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
