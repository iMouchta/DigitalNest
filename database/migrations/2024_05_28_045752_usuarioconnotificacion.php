<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UsuarioConNotificacion extends Migration
{
    public function up()
    {
        Schema::create('usuarioconnotificacion', function (Blueprint $table) {
            $table->unsignedBigInteger('idnotificacion');
            $table->unsignedBigInteger('idusuario');

            $table->foreign('idnotificacion')
                ->references('idnotificacion')
                ->on('notificacion')
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
        Schema::dropIfExists('usuarioconnotificacion');
    }
}
