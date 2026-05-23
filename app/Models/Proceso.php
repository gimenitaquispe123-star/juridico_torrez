<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proceso extends Model
{
    use HasFactory;

    protected $table = 'procesos';

    protected $fillable = [
        'id_cliente',
        'id_abogado',
        'id_posicion', 
        'contrario',
        'proceso',
        'descripcion',
        'tipo_proceso',
        'estado_proceso',
        'involucrados',
        'fecha_inicio',
        'fecha_final',
        'usuario_reg',
        'usuario_mod',
        'estado',
        'id_expediente',
    ];

    public $timestamps = true; 

    protected $dates = [
        'fecha_inicio',
        'fecha_final',
        'created_at',
        'updated_at',
    ];

    public function cliente()
    {
        return $this->belongsTo(Persona::class, 'id_cliente');
    }

    public function abogado()
    {
        return $this->belongsTo(Persona::class, 'id_abogado');
    }

    public function posicion()
    {
        return $this->belongsTo(Posicion::class, 'id_posicion'); 
    }

    public function tipoProceso()
    {
        return $this->belongsTo(TipoProceso::class, 'tipo_proceso', 'id');
    }

    public function estadoProceso()
    {
        return $this->belongsTo(EstadoProceso::class, 'estado_proceso', 'id');
    }

    public function expediente()
    {
        return $this->belongsTo(Expediente::class, 'id_expediente');
    }

    public function documentos()
    {
        return $this->hasMany(Documento::class, 'proceso_id', 'id');
    }
    
}
