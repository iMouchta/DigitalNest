<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class solicitud extends Model
{
    use HasFactory;
    protected $table = 'solicitud';

    protected $fillable = ['idmateria', 'capacidadsolicitud', 'fechasolicitud', 'horainicialsolicitud', 'horafinalsolicitud', 'bitacorafechasolicitud', 'motivoespecial'];

    // Relación con las materias
    public function reservas()
    {
        return $this->hasMany(reserva::class, 'idsolicitud');
    }
    
}
