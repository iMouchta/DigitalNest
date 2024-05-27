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
            $table->unsignedBigInteger('idmateria')->nullable();
            $table->string('nombremotivo', 255)->nullable();
            $table->boolean('registrado')->nullable();

            $table->foreign('idmateria')
                ->references('idmateria')
                ->on('materia')
                ->onDelete('NO ACTION')
                ->onUpdate('NO ACTION');
        });
    }
    public function down()
    {
        Schema::dropIfExists('motivo');
    }
}
