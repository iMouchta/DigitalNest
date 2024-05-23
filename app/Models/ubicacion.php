<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ubicacion extends Model
{
    use HasFactory;

    protected $table = 'ubicacion';

    protected $primaryKey = 'idubicacion';

    public $timestamps = false;
    protected $fillable = [
        'nombreubicacion'
    ];

    public function ambientes()
    {
        return $this->hasMany(Ambiente::class, 'idubicacion');
    }
}
