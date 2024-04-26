<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PeriodoAcademicoDisponible extends Migration
{
    public function up()
    {
        Schema::create('periodo_academico_disponible', function (Blueprint $table) {
            $table->id('idperiodoacademicodisponible');
            $table->unsignedBigInteger('idambiente');
            $table->time('horadisponibleinicial')->nullable();
            $table->time('horadisponiblefinal')->nullable();
            $table->date('fechadisponible')->nullable();
            $table->boolean('estadisponible')->nullable();
            $table->timestamps();

            $table->foreign('idambiente')->references('idambiente')->on('ambiente');
        });
    }

    public function down()
    {
        Schema::dropIfExists('periodo_academico_disponible');
    }
}
