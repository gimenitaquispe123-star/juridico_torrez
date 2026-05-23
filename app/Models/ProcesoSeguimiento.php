<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcesoSeguimiento extends Model
{
    use HasFactory;

    protected $table = 'procesos_seguimiento';

    protected $fillable = [
        'id_proceso',
        'id_cliente',
        'fecha',
        'etapa',
        'accion',
        'observaciones',
        'dias_plazo',
         'fecha_vencimiento',
        'estado_plazo',
        'usuario_reg',
        'usuario_mod',
    ];

    public function proceso()
    {
        return $this->belongsTo(Proceso::class, 'id_proceso');
    }


    public function cliente()
    {
        return $this->belongsTo(Persona::class, 'id_cliente');
    }

    public function usuarioReg()
    {
        return $this->belongsTo(Usuario::class, 'usuario_reg');
    }

    public function usuarioMod()
    {
        return $this->belongsTo(Usuario::class, 'usuario_mod');
    }
}
