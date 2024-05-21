<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SolicitudConAmbienteAsignado extends Migration
{
    public function up()
    {
        Schema::create('solicitudconambienteasignado', function (Blueprint $table) {
            $table->unsignedBigInteger('idsolicitud');
            $table->unsignedBigInteger('idambiente');

            $table->foreign('idsolicitud')
                ->references('idsolicitud')
                ->on('solicitud')
                ->onDelete('NO ACTION')
                ->onUpdate('NO ACTION');
            
            $table->foreign('idambiente')
                ->references('idambiente')
                ->on('ambiente')
                ->onDelete('NO ACTION')
                ->onUpdate('NO ACTION');
        });
    }
    public function down()
    {
        Schema::dropIfExists('solicitudconambienteasignado');
    }
}
