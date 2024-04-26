<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Motivo extends Migration
{
    public function up()
    {
        Schema::create('motivo', function (Blueprint $table) {
            $table->id('idmotivo');
            $table->unsignedBigInteger('idmateria');
            $table->string('motivosolicitud', 45)->nullable();
            $table->timestamps();

            $table->foreign('idmateria')->references('idmateria')->on('materia');
        });
    }

    public function down()
    {
        Schema::dropIfExists('motivo');
    }
}
