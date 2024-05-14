<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ambiente extends Model
{
    use HasFactory;
    protected $table = 'ambiente';

    protected $primaryKey = 'idambiente';

    protected $fillable = ['idubicacion, nombreambiente, capacidadambiente'];

    // Relacion con los periodos no disponibles
    public function periodonodisponible()
    {
        return $this->hasMany(periodonodisponible::class, 'idambiente');
    }

    // Relacion con las reservas
    public function reserva()
    {
        return $this->belongsTo(reserva::class, 'idreserva');
    }
    
}
