<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ambiente extends Model
{
    use HasFactory;

    protected $table = 'ambiente';
    protected $primaryKey = 'idambiente';
    protected $fillable = [
        'idubicacion', 
        'nombreambiente', 
        'capacidadambiente',
        'planta'
    ];

    public function ubicacion()
    {
        return $this->belongsTo(Ubicacion::class, 'idubicacion');
    }

    public function periodonodisponible()
    {
        return $this->hasMany(PeriodoNoDisponible::class, 'idambiente');
    }

    public function reserva()
    {
        return $this->belongsTo(Reserva::class, 'idreserva');
    }

    public function solicitudes()
    {
        return $this->belongsToMany(Solicitud::class, 'solicitudconambienteasignado', 'idambiente', 'idsolicitud');
    }
}