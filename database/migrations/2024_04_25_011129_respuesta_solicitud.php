<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RespuestaSolicitud extends Migration
{
    public function up()
    {
        Schema::create('respuesta_solicitud', function (Blueprint $table) {
            $table->id('idrespuestasolicitud');
            $table->unsignedBigInteger('idsolicitud');
            $table->string('motivodenoreserva', 45)->nullable();
            $table->date('fecharevision')->nullable();
            $table->timestamps();

            // No necesitas definir una clave primaria compuesta aquí

            $table->foreign('idsolicitud')->references('idsolicitud')->on('solicitud');
        });
    }

    public function down()
    {
        Schema::dropIfExists('respuesta_solicitud');
    }
}
