<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Persona;
use App\Models\Expediente;
use App\Models\User; 

class ExpedienteDigitalizado extends Model
{
    use HasFactory;

    protected $table = 'expedientes_digitalizados';

    protected $fillable = [
        'id_cliente',
        'id_expediente',
        'nro_expediente',
        'tipo_expediente',
        'texto_expediente',
        'url_documento',
        'estado',
        'usuario_reg',
        'usuario_mod',
    ];

    
    public function cliente() {
        return $this->belongsTo(Persona::class, 'id_cliente');
    }

    public function expediente() {
        return $this->belongsTo(Expediente::class, 'id_expediente');
    }

   public function usuarioRegistro() {
    return $this->belongsTo(Usuario::class, 'usuario_reg', 'id');
}

public function usuarioModificacion() {
    return $this->belongsTo(Usuario::class, 'usuario_mod', 'id');
}
    
}
