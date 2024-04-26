<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ambiente extends Model
{
    use HasFactory;

    protected $table = 'ambiente';

    protected $fillable = ['idubicacion', 'nombreambiente', 'capacidadambiente'];

    public function ubicacion()
    {
        return $this->belongsTo(Ubicacion::class, 'idubicacion');
    }
}
