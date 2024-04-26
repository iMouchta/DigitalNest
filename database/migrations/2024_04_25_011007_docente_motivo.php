<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DocenteMotivo extends Migration
{
    public function up()
    {
        Schema::create('docente_motivo', function (Blueprint $table) {
            $table->id('iddocentemotivo');
            $table->unsignedBigInteger('idmotivo');
            $table->unsignedBigInteger('iddocente');
            $table->timestamps();

            $table->foreign('idmotivo')->references('idmotivo')->on('motivo');
            $table->foreign('iddocente')->references('iddocente')->on('docente');
        });
    }

    public function down()
    {
        Schema::dropIfExists('docente_motivo');
    }
}
