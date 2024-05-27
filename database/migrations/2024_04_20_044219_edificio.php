<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Edificio extends Migration
{
    public function up()
    {
        Schema::create('edificio', function (Blueprint $table) {
            $table->id('idedificio');
            $table->string('nombreedificio', 50)->nullable();
            $table->integer('numeropisos')->default(0);


        });
    }

    public function down()
    {
        Schema::dropIfExists('edificio');
    }
}