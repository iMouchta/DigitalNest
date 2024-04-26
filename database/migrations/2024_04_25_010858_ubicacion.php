<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Ubicacion extends Migration
{
    public function up()
    {
        Schema::create('ubicacion', function (Blueprint $table) {
            $table->id('idubicacion');
            $table->string('nombreubicacion', 45)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ubicacion');
    }
}