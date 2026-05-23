<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    use HasFactory;

    protected $table = 'departamento';

    protected $fillable = [
        'departamento',
        'codigo',
        'registrado',
        'modificado',
        'usuario_reg',
        'usuario_mod',
    ];

   
    public $timestamps = false;
}
