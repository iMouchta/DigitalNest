<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class periodonodisponible extends Model
{
    use HasFactory;
    protected $table = 'periodonodisponible';

    public $timestamps = false;
    protected $fillable = ['idambiente', 'fecha', 'hora'];

    public function ambiente()
    {
        return $this->belongsTo(ambiente::class, 'idambiente');
    }
    
}