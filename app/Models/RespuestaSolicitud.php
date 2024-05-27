<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RespuestaSolicitud extends Model
{
    use HasFactory;

    protected $table = 'respuestasolicitud';
    protected $primaryKey = 'idrespuestasolicitud';
    public $timestamps = false;

    protected $fillable = [
        'idsolicitud',
        'motivodenoreserva',
        'fecharevision',
    ];

    public function solicitud()
    {
        return $this->belongsTo(Solicitud::class, 'idsolicitud', 'idsolicitud');
    }
}