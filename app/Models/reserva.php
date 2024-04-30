<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reserva extends Model
{
    use HasFactory;
    protected $table = 'reserva';

    protected $fillable = ['idsolicitud', 'idambiente'];

    // Relación con las solicitudes
    public function solicitud()
    {
        return $this->belongsTo(solicitud::class, 'idsolicitud');
    }

    // Relación con los ambientes

    public function ambiente()
    {
        return $this->belongsTo(solicitud::class, 'idambiente');
    }
    
}
