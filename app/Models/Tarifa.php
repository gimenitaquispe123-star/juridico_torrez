<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use usuarios; 

class Tarifa extends Model
{
    protected $table = 'tarifas';

    protected $primaryKey = 'id_tarifa';

    protected $fillable = [
        'tipo_proceso_id',  
        'categoria',         
        'monto_min',
        'monto_max',
        'moneda',
        'vigencia_inicio',
        'vigencia_fin',
        'usuario_reg',
        'usuario_mod'
    ];

   
    public function tipoProceso(): BelongsTo
    {
        return $this->belongsTo(TipoProceso::class, 'tipo_proceso_id');
    }

    
    public function usuarioRegistro() {
    return $this->belongsTo(User::class, 'usuario_reg');
}

public function usuarioModificacion() {
    return $this->belongsTo(User::class, 'usuario_mod');
}

}

