<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    use HasFactory;

    protected $table = 'materia';
    protected $primaryKey = 'idmateria';
    public $timestamps = false;
    protected $fillable = [
        'idusuario',
        'nombremateria',
        'cuporeserva',
        'grupo',
    ];
    public function usuarios()
    {
        return $this->belongsTo(Usuario::class, 'idusuario', 'idusuario');
    }
    public function motivos()
    {
        return $this->hasMany(Motivo::class, 'idmateria', 'idmateria');
    }
}