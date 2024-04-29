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
            $table->unsignedBigInteger('iddocentemotivo')->nullable();
            $table->integer('capacidadsolicitud')->nullable();
            $table->date('fechasolicitud')->nullable();
            $table->time('horainicialsolicitud')->nullable();
            $table->time('horafinalsolicitud')->nullable();
            $table->date('bitacorafechasolicitud')->nullable();
            $table->string('motivoespecial', 1000)->nullable();
            $table->timestamps();

            $table->foreign('idadministrador')->references('idadministrador')->on('administrador');
            $table->foreign('iddocentemotivo')->references('iddocentemotivo')->on('docente_motivo');
        });
    }

    public function down()
    {
        Schema::dropIfExists('solicitud');
    }
}
