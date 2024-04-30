<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Solicitud extends Migration
{
    public function up()
    {
        Schema::create('solicitud', function (Blueprint $table) {
            $table->id('idsolicitud');

            $table->unsignedBigInteger('idadministrador')->nullable();
            $table->unsignedBigInteger('idmateria')->nullable();
            $table->integer('capacidadsolicitud')->nullable();
            $table->date('fechasolicitud')->nullable();
            $table->time('horainicialsolicitud')->nullable();
            $table->time('horafinalsolicitud')->nullable();
            $table->date('bitacorafechasolicitud')->nullable();
            $table->string('motivosolicitud', 1000)->nullable();
            $table->string('ambientesolicitud', 250)->nullable();
            $table->boolean('especial')->nullable();

            $table->foreign('idadministrador')->references('idadministrador')->on('administrador');
            $table->foreign('idmateria')->references('idmateria')->on('materia');
        });
    }

    public function down()
    {
        Schema::dropIfExists('solicitud');
    }
}
