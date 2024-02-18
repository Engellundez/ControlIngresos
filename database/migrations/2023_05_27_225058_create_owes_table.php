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
            $table->foreignId('debtor_id');
            $table->foreignId('activity_id');
            $table->float('amount',12,0)->default(0);
            $table->float('payment',12,0)->default(0);
            $table->date('payment_date');
            $table->timestamps();

            $table->foreign('debtor_id')->references('id')->on('debtors');
            $table->foreign('activity_id')->references('id')->on('activities');
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
