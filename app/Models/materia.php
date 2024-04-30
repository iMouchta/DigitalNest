<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class materia extends Model
{
    use HasFactory;
    protected $table = 'materia';

    protected $fillable = ['iddocente', 'nombremateria', 'cuporeserva', 'grupo'];

    // Relación con las materias
    public function docente()
    {
        return $this->belongsTo(docente::class, 'iddocente');
    }
    
}