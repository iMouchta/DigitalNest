<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Administrador extends Migration
{
    public function up()
    {
        Schema::create('administrador', function (Blueprint $table) {
            $table->id('idadministrador');
            $table->unsignedBigInteger('nombreadministrador')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('administrador');
    }
}