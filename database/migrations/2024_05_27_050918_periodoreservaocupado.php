<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PeriodoReservaOcupado extends Migration
{
    public function up()
    {
        Schema::create('periodoreservaocupado', function (Blueprint $table) {
            $table->id('idperiodonodisponible');
            $table->unsignedBigInteger('idambiente')->nullable();
            $table->date('fecha')->nullable();
            $table->time('hora')->nullable();

            $table->foreign('idambiente')
                ->references('idambiente')
                ->on('ambiente')
                ->onDelete('NO ACTION')
                ->onUpdate('NO ACTION');
        });
    }
    public function down()
    {
        Schema::dropIfExists('periodoreservaocupado');
    }
}
