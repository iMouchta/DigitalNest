<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SolicitudDocente extends Migration
{
    public function up()
    {
        Schema::create('solicitud_docente', function (Blueprint $table) {
            $table->id('idsolicituddocente');
            $table->unsignedBigInteger('idsolicitud');
            $table->unsignedBigInteger('iddocentemotivo');
            $table->timestamps();

            $table->foreign('idsolicitud')->references('idsolicitud')->on('solicitud');
            $table->foreign('iddocentemotivo')->references('iddocentemotivo')->on('docente_motivo');
        });
    }

    public function down()
    {
        Schema::dropIfExists('solicitud_docente');
    }
}