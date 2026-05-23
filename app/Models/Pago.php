<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_pago';

    protected $fillable = [
        'id_cliente',
        'tarifa_id',
        'monto_total',
        'glosa_pago',
        'monto_pagado',
        'monto_pendiente',
        'fecha_pago',
        'estado',
        'usuario_registro',
        'usuario_modifico',
    ];

    protected $casts = [
        'monto_total' => 'decimal:2',
        'monto_pagado' => 'decimal:2',
        'monto_pendiente' => 'decimal:2',
        'fecha_pago' => 'date',
    ];

    // Relaciones
    public function cliente()
    {
        return $this->belongsTo(Persona::class, 'id_cliente', 'id');
    }

    public function tarifa()
    {
        return $this->belongsTo(Tarifa::class, 'tarifa_id', 'id_tarifa');
    }

    public function usuarioRegistro()
    {
        return $this->belongsTo(Usuario::class, 'usuario_registro', 'id');
    }

    public function usuarioModifico()
    {
        return $this->belongsTo(Usuario::class, 'usuario_modifico', 'id');
    }

    public function getFechaPagoFormattedAttribute()
    {
        return $this->fecha_pago
            ? $this->fecha_pago->format('d/m/Y')
            : null;
    }
}