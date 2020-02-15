<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaPermisoRol extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('PermisoRol', function (Blueprint $table) {
            $table->unsignedInteger('Rol_codigo');
            $table->foreign('Rol_codigo','fk_permisoRol_rol')->references('Rol_codigo')->on('Rol');
            $table->unsignedInteger('Per_codigo');
            $table->foreign('Per_codigo','fk_permisoRol_permiso')->references('Per_codigo')->on('Permiso');
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
        Schema::dropIfExists('PermisoRol');
    }
}
