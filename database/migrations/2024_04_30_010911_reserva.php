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
            $table->unsignedBigInteger('idambiente');
            $table->unsignedBigInteger('idsolicitud');

            // Foreign key constraints
            $table->foreign('idsolicitud')
                  ->references('idsolicitud')
                  ->on('solicitud')
                  ->onDelete('NO ACTION')
                  ->onUpdate('NO ACTION');

            $table->foreign('idambiente')
                  ->references('idambiente')
                  ->on('ambiente')
                  ->onDelete('NO ACTION')
                  ->onUpdate('NO ACTION');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
