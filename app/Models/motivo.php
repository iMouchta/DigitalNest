<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class motivo extends Model
{
    use HasFactory;

    protected $table = 'motivo';

    protected $primaryKey = 'idmotivo';

    protected $fillable = ['idmateria', 'nombremotivo', 'registrado'];

}
