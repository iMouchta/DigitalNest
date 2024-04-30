<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class periodonodisponible extends Model
{
    use HasFactory;
    protected $table = 'periodonodisponible';

    protected $fillable = ['idambiente, fecha, hora'];

    // Relación con las materias
    public function ambiente()
    {
        return $this->belongsTo(ambiente::class, 'idambiente');
    }
    
}