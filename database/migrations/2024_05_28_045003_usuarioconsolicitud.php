<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UsuarioConSolicitud extends Migration
{
    public function up()
    {
        Schema::create('usuarioconsolicitud', function (Blueprint $table) {
            $table->unsignedBigInteger('idsolicitud');
            $table->unsignedBigInteger('idusuario');

            $table->foreign('idsolicitud')
                ->references('idsolicitud')
                ->on('solicitud')
                ->onDelete('NO ACTION')
                ->onUpdate('NO ACTION');
            
            $table->foreign('idusuario')
                ->references('idusuario')
                ->on('usuario')
                ->onDelete('NO ACTION')
                ->onUpdate('NO ACTION');
        });
    }
    public function down()
    {
        Schema::dropIfExists('usuarioconsolicitud');
    }
}
