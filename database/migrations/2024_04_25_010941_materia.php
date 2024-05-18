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
            $table->string('grupo', 20)->nullable();
            $table->integer('cuporeserva')->default(4);

            $table->foreign('iddocente')
                  ->references('iddocente')
                  ->on('docente')
                  ->onDelete('NO ACTION')
                  ->onUpdate('NO ACTION');
        });
    }

    public function down()
    {
        Schema::dropIfExists('materia');
    }
}
