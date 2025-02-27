<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaPermiso extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Permiso', function (Blueprint $table) {
            $table->integerIncrements('Per_codigo');
            $table->string('Per_nombre', 50);
            $table->string('Per_slug',50);
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
        Schema::dropIfExists('Permiso');
    }
}
