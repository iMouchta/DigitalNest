<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SolicitudEspecial extends Migration
{
    public function up()
    {
        Schema::create('solicitud_especial', function (Blueprint $table) {
            $table->id('idsolicitudespecial');
            $table->unsignedBigInteger('idsolicitud');
            $table->unsignedBigInteger('idadministrador');
            $table->unsignedBigInteger('iddocentemotivo');
            $table->string('motivosolicitudespecial', 45)->nullable();
            $table->timestamps();

            // Hay que revisar eso de la llave compuesta

            $table->foreign('idsolicitud')->references('idsolicitud')->on('solicitud');
            $table->foreign('idadministrador')->references('idadministrador')->on('administrador');
            $table->foreign('iddocentemotivo')->references('iddocentemotivo')->on('docente_motivo');
        });
    }

    public function down()
    {
        Schema::dropIfExists('solicitud_especial');
    }
}
