<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DocenteSolicitud extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('docentesolicitud', function (Blueprint $table) {
            $table->unsignedBigInteger('iddocente');
            $table->unsignedBigInteger('idsolicitud');
            
            $table->foreign('iddocente')
                ->references('iddocente')
                ->on('docente')
                ->onDelete('NO ACTION')
                ->onUpdate('NO ACTION');

            $table->foreign('idsolicitud')
                ->references('idsolicitud')
                ->on('solicitud')
                ->onDelete('NO ACTION')
                ->onUpdate('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('docentesolicitud');
    }
}
