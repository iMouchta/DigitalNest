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
            $table->unsignedBigInteger('idmateria')->nullable();
            $table->unsignedBigInteger('idadministrador')->nullable();
            $table->unsignedBigInteger('idambiente')->nullable();
            $table->boolean('especial')->nullable();
            $table->unsignedInteger('capacidadsolicitud')->nullable();
            $table->date('fechasolicitud')->nullable();
            $table->time('horainicialsolicitud')->nullable();
            $table->time('horafinalsolicitud')->nullable();
            $table->boolean('aceptada')->nullable();
            $table->string('motivosolicitud', 1000)->nullable();


            $table->foreign('idadministrador')
                ->references('idadministrador')
                ->on('administrador')
                ->onDelete('NO ACTION')
                ->onUpdate('NO ACTION');

            $table->foreign('idmateria')
                ->references('idmateria')
                ->on('materia')
                ->onDelete('NO ACTION')
                ->onUpdate('NO ACTION');

            $table->foreign('idambiente')
                ->references('idambiente')
                ->on('ambiente')
                ->onDelete('NO ACTION')
                ->onUpdate('NO ACTION');

        });
    }
    public function down()
    {
        Schema::dropIfExists('solicitud');
    }
}
