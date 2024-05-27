<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Usuario extends Migration
{
    public function up()
    {
        Schema::create('usuario', function (Blueprint $table) {
            $table->id('idusuario');
            $table->string('nombreusuario', 20)->nullable();
            $table->string('correousuario', 45)->nullable();
            $table->boolean('administrador')->default(0);
        });
    }
    public function down()
    {
        Schema::dropIfExists('usuario');
    }
}
