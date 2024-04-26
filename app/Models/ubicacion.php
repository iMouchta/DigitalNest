<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ubicacion extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombreubicacion'
    ];

    // Relación con los ambientes
    public function ambientes()
    {
        return $this->hasMany(Ambiente::class, 'idubicacion');
    }
}
