<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Posicion extends Model
{
    protected $table = 'posiciones';

    protected $fillable = [
        'nombre',
        'descripcion',
        'estado',
    ];
}
