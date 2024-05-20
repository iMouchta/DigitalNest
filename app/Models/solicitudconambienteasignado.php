<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class solicitudconambienteasignado extends Model
{
    use HasFactory;

    protected $table = 'solicitudconambienteasignado';

    protected $fillable = ['idsolicitud', 'idambiente'];
}
