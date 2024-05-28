<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    use HasFactory;
    protected $table = 'solicitud';
    protected $primaryKey = 'idsolicitud';
    public $timestamps = false;

    protected $fillable = [
        'capacidadsolicitud',
        'fechasolicitud',
        'horainicialsolicitud',
        'horafinalsolicitud',
        'motivosolicitud',
        'aceptada',
        'especial',
    ];

    public function ambientes()
    {
        return $this->belongsToMany(Ambiente::class, 'solicitudconambiente', 'idsolicitud', 'idambiente');
    }
     public function usuarios()
    {
        return $this->belongsToMany(Usuario::class, 'usuarioconsolicitud', 'idsolicitud', 'idusuario');
    }
    public function respuestas()
    {
        return $this->hasMany(RespuestaSolicitud::class, 'idsolicitud', 'idsolicitud');
    }
}