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
            $table->unsignedBigInteger('idambiente');
            $table->integer('capacidadsolicitud')->nullable();
            $table->date('fechasolicitud')->nullable();
            $table->time('horainicialsolicitud')->nullable();
            $table->time('horafinalsolicitud')->nullable();
            $table->boolean('revisionestapendiente')->nullable();
            $table->boolean('solicitudfueaceptada')->nullable();
            $table->boolean('esurgente')->nullable();
            $table->date('bitacorafechasolicitud')->nullable();
            $table->timestamps();

            $table->foreign('idambiente')->references('idambiente')->on('ambiente');
        });
    }

    public function down()
    {
        Schema::dropIfExists('solicitud');
    }
}
