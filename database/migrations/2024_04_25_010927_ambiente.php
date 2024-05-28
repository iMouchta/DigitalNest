<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Ambiente extends Migration
{
    public function up()
    {
        Schema::create('ambiente', function (Blueprint $table) {
            $table->id('idambiente');
            $table->unsignedBigInteger('idedificio');
            $table->string('nombreambiente', 50)->nullable();
            $table->unsignedInteger('capacidadambiente')->nullable();
            $table->unsignedInteger('planta')->default(0);

            $table->foreign('idedificio')
                  ->references('idedificio')
                  ->on('edificio')
                  ->onDelete('NO ACTION')
                  ->onUpdate('NO ACTION');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ambiente');
    }
}
