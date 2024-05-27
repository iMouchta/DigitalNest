<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeriodoReservaOcupado extends Model
{
    use HasFactory;
    protected $table = 'periodoreservaocupado';
    public $timestamps = false;
    protected $fillable = ['idambiente', 'fecha', 'hora'];
    public function ambiente()
    {
        return $this->belongsTo(Ambiente::class, 'idambiente');
    }
    
}