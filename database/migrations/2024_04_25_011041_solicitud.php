<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Solicitud extends Migration
{
    public function up()
    {
        Schema::create('solicitud', function (Blueprint $table) {
            $table->id('idsolicitud');
            $table->unsignedBigInteger('idmateria');
            $table->unsignedBigInteger('idadministrador')->nullable();
            $table->string('ambientesolicitud', 250)->nullable();
            $table->boolean('especial')->nullable();
            $table->unsignedInteger('capacidadsolicitud')->nullable();
            $table->date('fechasolicitud')->nullable();
            $table->time('horainicialsolicitud')->nullable();
            $table->time('horafinalsolicitud')->nullable();
            $table->date('bitacorafechasolicitud')->nullable();
            $table->string('motivosolicitud', 1000)->nullable();

            
            // Foreign key constraints
            $table->foreign('idadministrador')
                  ->references('idadministrador')
                  ->on('administrador')
                  ->onDelete('NO ACTION')
                  ->onUpdate('NO ACTION');

            $table->foreign('idmateria')
                  ->references('idmateria')
                  ->on('materia')
                  ->onDelete('NO ACTION')
                  ->onUpdate('NO ACTION');

        });
    }
    public function down()
    {
        Schema::dropIfExists('solicitud');
    }
}
