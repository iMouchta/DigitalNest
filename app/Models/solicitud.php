<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class solicitud extends Model
{
    use HasFactory;
    protected $table = 'solicitud';
    public $timestamps = false;


    protected $fillable = [
        'idmateria',
        'idadministrador',
        'idambiente',
        'especial',
        'capacidadsolicitud',
        'fechasolicitud',
        'horainicialsolicitud',
        'horafinalsolicitud',
        'aceptada',
        'motivosolicitud',
    ];

    public function ambiente()
    {
        return $this->belongsTo(Ambiente::class, 'idambiente');
    }

    public function reservas()
    {
        return $this->hasMany(reserva::class, 'idsolicitud');
    }
    
    public function materia()
    {
        return $this->belongsTo(Materia::class, 'idmateria');
    }

    public function administrador()
    {
        return $this->belongsTo(Administrador::class, 'idadministrador', 'idadministrador');
    }
}
