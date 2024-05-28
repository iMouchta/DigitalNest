<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    use HasFactory;

    protected $table = 'notificacion';
    protected $primaryKey = 'idnotificacion';
    public $timestamps = false;

    protected $fillable = [
        'mensaje',
        'general',
        'vista',
    ];

    public function usuarios()
    {
        return $this->belongsToMany(Usuario::class, 'usuarioconnotificacion', 'idnotificacion', 'idusuario');
    }
}