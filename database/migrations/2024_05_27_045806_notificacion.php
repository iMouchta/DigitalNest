<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Notificacion extends Migration
{
    public function up()
    {
        Schema::create('notificacion', function (Blueprint $table) {
            $table->id('idnotificacion');
            $table->string('mensaje', 1000);
            $table->boolean('general')->default(0);
        });
    }

    public function down()
    {
        Schema::dropIfExists('notificacion');
    }
}
