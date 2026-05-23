<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Expediente extends Model
{
    use HasFactory;

    protected $table = 'expedientes';

    public $timestamps = false;

    protected $fillable = [
        'id_cliente',
        'codigo_expediente',
        'nro_expediente',
        'demandante',
        'demandado',
        'materia',
        'contingencia',
        'respaldo',
        'registrado',
        'modificado',
        'usuario_reg',
        'usuario_mod',
        'estado',
        'observaciones',
        'estado_expediente',
    ];

 
    public function cliente()
    {
        return $this->belongsTo(Persona::class, 'id_cliente');
    }




    public function getEstadoTextoAttribute()
    {
        return $this->estado ? 'Activo' : 'Inactivo';
    }


    public function usuarioReg()
{
    return $this->belongsTo(Usuario::class, 'usuario_reg');
}

public function usuarioMod()
{
    return $this->belongsTo(Usuario::class, 'usuario_mod');
}

public function documentos()
{
    return $this->hasMany(Documento::class, 'expediente_id'); 
}



public function abogadoAsignado()
{
    return $this->hasOne(\App\Models\AbogadoExpediente::class, 'id_expediente', 'id')
                ->where('estado', 1);
}
}
