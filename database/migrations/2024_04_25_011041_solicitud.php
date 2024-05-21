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
            $table->unsignedInteger('capacidadsolicitud')->nullable();
            $table->date('fechasolicitud')->nullable();
            $table->time('horainicialsolicitud')->nullable();
            $table->time('horafinalsolicitud')->nullable();
            $table->string('motivosolicitud', 1000)->nullable();
            $table->boolean('aceptada')->nullable();
            $table->boolean('especial')->default(0);


            $table->foreign('idadministrador')
                ->references('idadministrador')
                ->on('administrador')
                ->onDelete('NO ACTION')
                ->onUpdate('NO ACTION');

        });
    }
    public function down()
    {
        Schema::dropIfExists('solicitud');
    }
}
