<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class solicitud extends Model
{
    use HasFactory;
    protected $table = 'solicitud';

    protected $fillable = [
        'idambiente',
        'idmateria', 
        'capacidadsolicitud', 
        'fechasolicitud', 
        'horainicialsolicitud', 
        'horafinalsolicitud',
        'revisionestapendiente',
        'solicitudfueaceptada',
        'esurgente',
        'bitacorafechasolicitud'
    ];

    public function ambiente()
    {
        return $this->belongsTo(Ambiente::class, 'idambiente');
    }

    public function reservas()
    {
        return $this->hasMany(reserva::class, 'idsolicitud');
    }
    
}
