<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Materia extends Migration
{
    public function up()
    {
        Schema::create('materia', function (Blueprint $table) {
            $table->id('idmateria');
            $table->unsignedBigInteger('iddocente');
            $table->string('nombremateria', 255)->nullable();
            $table->timestamps();

            $table->foreign('iddocente')->references('iddocente')->on('docente');
        });
    }

    public function down()
    {
        Schema::dropIfExists('materia');
    }
}
