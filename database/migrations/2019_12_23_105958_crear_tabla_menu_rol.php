<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaMenuRol extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('MenuRol', function (Blueprint $table) {
            $table->unsignedInteger('Rol_codigo');
            $table->foreign('Rol_codigo','fk_menuRol_rol')->references('Rol_codigo')->on('Rol');
            $table->unsignedInteger('men_id');
            $table->foreign('Men_id','fk_menuRol_permiso')->references('Men_id')->on('Menu');
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
        Schema::dropIfExists('MenuRol');
    }
}
