<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ReglaReservaDeAmbiente extends Migration
{

    public function up()
    {
        Schema::create('reglareservadeambiente', function (Blueprint $table) {
            $table->id('idreglareservadeambiente');
            $table->unsignedBigInteger('idambiente')->nullable();
            $table->date('fechainicialdisponible')->nullable();
            $table->date('fechafinaldisponible')->nullable();
            $table->time('horainicialdisponible')->nullable();
            $table->time('horafinaldisponible')->nullable();

            $table->foreign('idambiente')
                ->references('idambiente')
                ->on('ambiente')
                ->onDelete('NO ACTION')
                ->onUpdate('NO ACTION');
        });
    }

    public function down()
    {
        Schema::dropIfExists('reglareservadeambiente');
    }
}
