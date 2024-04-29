<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Reserva extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reserva', function (Blueprint $table) {
            $table->id('idreserva');

            $table->unsignedBigInteger('idsolicitud')->nullable();
            $table->unsignedBigInteger('idambiente')->nullable();

            $table->timestamps();

            $table->foreign('idsolicitud')->references('idsolicitud')->on('solicitud');
            $table->foreign('idambiente')->references('idambiente')->on('ambiente');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reserva');
    }
}
