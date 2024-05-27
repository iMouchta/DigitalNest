<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReglaReservaDeAmbiente extends Model
{
    use HasFactory;

    protected $table = 'reglareservadeambiente';
    protected $primaryKey = 'idreglareservadeambiente';
    public $timestamps = false;

    protected $fillable = [
        'idambiente',
        'fechainicialdisponible',
        'fechafinaldisponible',
        'horainicialdisponible',
        'horafinaldisponible',
    ];

    public function ambiente()
    {
        return $this->belongsTo(Ambiente::class, 'idambiente', 'idambiente');
    }
}