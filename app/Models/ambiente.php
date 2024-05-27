<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ambiente extends Model
{
    use HasFactory;

    protected $table = 'ambiente';
    protected $primaryKey = 'idambiente';
    public $timestamps = false;

    protected $fillable = [
        'idedificio',
        'nombreambiente',
        'capacidadambiente',
        'planta',
    ];
    public function edificio()
    {
        return $this->belongsTo(Edificio::class, 'idedificio', 'idedificio');
    }
    public function solicitudes()
    {
        return $this->belongsToMany(Solicitud::class, 'solicitudconambienteasignado', 'idambiente', 'idsolicitud');
    }    
    public function periodoreservaocupado()
    {
        return $this->hasMany(PeriodoReservaOcupado::class, 'idambiente');
    }
    public function reglasReserva()
    {
        return $this->hasMany(ReglaReservaDeAmbiente::class, 'idambiente', 'idambiente');
    }
}