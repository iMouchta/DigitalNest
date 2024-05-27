<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Edificio extends Model
{
    use HasFactory;

    protected $table = 'edificio';

    protected $primaryKey = 'idedificio';

    public $timestamps = false;
    protected $fillable = [
        'nombreedificio'
    ];

    public function ambientes()
    {
        return $this->hasMany(Ambiente::class, 'idedificio');
    }
}
