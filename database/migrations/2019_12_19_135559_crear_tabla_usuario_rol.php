<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaUsuarioRol extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('UsuarioRol', function (Blueprint $table) {
            $table->unsignedInteger('Rol_codigo');
            $table->foreign('Rol_codigo','fk_usuariorol_rol')->references('Rol_codigo')->on('Rol');
            $table->bigIncrements('Usu_codigo');
            $table->foreign('Usu_codigo','fk_usuarioRol_usuario')->references('Usu_codigo')->on('Usuario');
            $table->boolean('URol_estado');
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
        Schema::dropIfExists('UsuarioRol');
    }
}
