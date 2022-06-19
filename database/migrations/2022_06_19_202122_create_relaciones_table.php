<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('role_usuarios', function (Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users');
			$table->foreign('rol_id')->references('id')->on('catalogos');
        });

		Schema::table('catalogos', function (Blueprint $table) {
			$table->foreign('tipo_id')->references('id')->on('tipos');
		});

		Schema::table('divisiones', function (Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users');
		});

		Schema::table('ingresos', function (Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users');
		});

		Schema::table('gastos', function (Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users');
			$table->foreign('tipo_gasto_id')->references('id')->on('catalogos');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('role_usuarios', function (Blueprint $table) {
			$table->dropForeign(['user_id']);
			$table->dropForeign(['rol_id']);
		});

		Schema::table('catalogos', function (Blueprint $table) {
			$table->dropForeign(['tipo_id']);
		});

		Schema::table('divisiones', function (Blueprint $table) {
			$table->dropForeign(['user_id']);
		});

		Schema::table('ingresos', function (Blueprint $table) {
			$table->dropForeign(['user_id']);
		});

		Schema::table('gastos', function (Blueprint $table) {
			$table->dropForeign(['user_id']);
			$table->dropForeign(['tipo_gasto_id']);
		});
    }
};
