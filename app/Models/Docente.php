<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{
    use HasFactory;

    protected $table = 'docente';

    protected $fillable = [
        'nombredocente',
        'correoelectronico',
        'numcelular',
    ];

    public function materias()
    {
        return $this->hasMany(Materia::class, 'iddocente');
    }
}
