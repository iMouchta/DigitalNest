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
        'idmateria',
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
        return $this->belongsToMany(Ambiente::class, 'solicitudconambienteasignado', 'idsolicitud', 'idambiente');
    }
     public function usuarios()
    {
        return $this->belongsToMany(Usuario::class, 'usuarioconsolicitud', 'idsolicitud', 'idusuario');
    }
    public function respuestas()
    {
        return $this->hasMany(RespuestaSolicitud::class, 'idsolicitud', 'idsolicitud');
    }
    public function materia()
    {
        return $this->belongsTo(Materia::class, 'idmateria', 'idmateria');
    }
}