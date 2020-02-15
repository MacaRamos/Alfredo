<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreaTablaUsuario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Usuario', function (Blueprint $table) {
            $table->bigIncrements('Usu_codigo');
            $table->string('Usu_usuario',50);
            $table->string('password',100);
            $table->string('Usu_nombre',50);
            $table->string('Usu_apellido',50)->nullable();
            $table->timestamps();
            $table->charset = "utf8mb4";
            $table->collation = "utf8mb4_spanish_ci";
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Usuario');
    }
}
