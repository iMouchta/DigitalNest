<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class HoraNoDisponible extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('horanodisponible', function (Blueprint $table) {
            $table->id('idhoranodisponible');
            $table->unsignedBigInteger('idambiente');
            $table->date('fecha')->nullable();
            $table->time('hora')->nullable();

            // Foreign key constraint
            $table->foreign('idambiente')
                  ->references('idambiente')
                  ->on('ambiente')
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
        Schema::dropIfExists('horanodisponible');
    }
}
