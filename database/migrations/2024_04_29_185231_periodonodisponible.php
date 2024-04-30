<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Periodonodisponible extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('periodonodisponible', function (Blueprint $table) {
            $table->id('idperiodonodisponible');

            $table->unsignedBigInteger('idambiente')->nullable();
            $table->date('fecha')->nullable();
            $table->time('hora')->nullable();

            $table->timestamps();

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
        Schema::dropIfExists('periodonodisponible');
    }
}
