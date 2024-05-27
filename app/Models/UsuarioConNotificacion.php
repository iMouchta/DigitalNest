<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class UsuarioConNotificacion extends Pivot
{
    protected $table = 'usuarioconnotificacion';

    protected $fillable = [
        'idnotificacion',
        'idusuario',
    ];
}