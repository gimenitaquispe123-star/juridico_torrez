<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoPlantilla extends Model
{
    use HasFactory;

    protected $table = 'tipos_plantilla'; 

    protected $primaryKey = 'id'; 

    public $timestamps = false; 

    protected $fillable = [
        'tipo_plantilla',
        'descripcion',
        'registrado',
        'modificado',
        'usuario_reg',
        'usuario_mod',
        'estado',
    ];

    protected $casts = [
        'registrado' => 'datetime',
        'modificado' => 'datetime',
        'estado' => 'boolean',
    ];
}
