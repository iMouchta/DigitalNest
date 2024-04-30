<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class docente extends Model
{
    use HasFactory;
    protected $table = 'docente';

    protected $fillable = ['nombredocente', 'correoelectronico', 'numcelular'];

    // Relación con las materias
    public function materias()
    {
        return $this->hasMany(materia::class, 'iddocente');
    }
    
}