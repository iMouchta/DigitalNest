<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RespuestaSolicitud extends Migration
{
    public function up()
    {
        Schema::create('respuestasolicitud', function (Blueprint $table) {
            $table->id('idrespuestasolicitud');
            $table->unsignedBigInteger('idsolicitud');
            $table->string('motivodenoreserva', 100)->nullable();
            $table->date('fecharevision')->nullable();

            
            $table->foreign('idsolicitud')
                  ->references('idsolicitud')
                  ->on('solicitud')
                  ->onDelete('NO ACTION')
                  ->onUpdate('NO ACTION');
        });
    }

    public function down()
    {
        Schema::dropIfExists('respuestasolicitud');
    }
}
