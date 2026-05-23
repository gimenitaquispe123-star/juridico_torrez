<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoProceso extends Model
{
    use HasFactory;

    protected $table = 'tipos_procesos';

    protected $fillable = [
        'tipo_proceso',
        'descripcion',
        'registrado',
        'modificado',
        'usuario_reg',
        'usuario_mod',
    ];

    public $timestamps = false;

    protected $dates = [
        'registrado',
        'modificado',
    ];

    public function procesos()
{
    return $this->hasMany(Proceso::class, 'tipo_proceso', 'id');
}
}
