<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReciboPago extends Model
{
    use HasFactory;

    protected $table = 'recibos_pagos';

    protected $fillable = [
        'id_pago',
        'numero_recibo',
        'glosa_pago',
        'monto_pago',
        'estado',
        'tipo_pago',
    ];

    public function pago()
    {
        return $this->belongsTo(Pago::class, 'id_pago');
    }
}
