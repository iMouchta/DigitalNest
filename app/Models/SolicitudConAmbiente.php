<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitudConAmbiente extends Model
{
    use HasFactory;

    protected $table = 'solicitudconambiente';
    public $timestamps = false;
    protected $fillable = [
        'idsolicitud', 
        'idambiente'
    ];
}
