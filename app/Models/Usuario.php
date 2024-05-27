<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;
    protected $table = 'usuario';
    protected $primaryKey = 'idusuario';
    public $timestamps = false;
    protected $fillable = [
        'nombreusuario', 
        'correousuario', 
        'administrador',
    ];
    public function solicitudes()
    {
        return $this->belongsToMany(Solicitud::class, 'usuarioconsolicitud', 'idusuario', 'idsolicitud');
    }
    public function materias()
    {
        return $this->hasMany(Materia::class, 'idusuario');
    }
    public function notificaciones()
    {
        return $this->belongsToMany(Notificacion::class, 'usuarioconnotificacion', 'idusuario', 'idnotificacion');
    }

    
}
