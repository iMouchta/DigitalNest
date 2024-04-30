<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{
    use HasFactory;

    protected $table = 'docente'; // Nombre de la tabla en la base de datos

    protected $fillable = [
        'nombredocente',
        'correoelectronico',
        'numcelular',
        // Agrega más campos si es necesario
    ];

    // Relación con la tabla Materia
    public function materias()
    {
        return $this->hasMany(Materia::class, 'iddocente');
    }
}
