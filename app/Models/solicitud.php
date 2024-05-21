<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class solicitud extends Model
{
    use HasFactory;
    protected $table = 'solicitud';
    protected $primaryKey = 'idsolicitud';
    public $timestamps = false;
    protected $fillable = [
        'idadministrador',
        'capacidadsolicitud',
        'fechasolicitud',
        'horainicialsolicitud',
        'horafinalsolicitud',
        'motivosolicitud',
        'aceptada',
        'especial'
    ];

    public function ambientes()
    {
        return $this->belongsToMany(Ambiente::class, 'solicitudconambienteasignado', 'idsolicitud', 'idambiente');
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
