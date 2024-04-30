<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    use HasFactory;

    protected $table = 'materia';
    protected $fillable = [
        'iddocente',
        'nombremateria',
        'cuporeserva',
        'grupo',
    ];

    public function docente()
    {
        return $this->belongsTo(Docente::class, 'iddocente');
    }

    public function solicitudes()
    {
        return $this->hasMany(Solicitud::class, 'idmateria');
    }
}
