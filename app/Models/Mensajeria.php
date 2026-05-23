<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mensajeria extends Model
{
    use HasFactory;

    protected $table = 'mensajeria';

    // No usamos created_at ni updated_at
    public $timestamps = false;

    protected $fillable = [
        'id_cliente',
        'id_empleado',
        'asunto',
        'mensaje',
        'usuario_reg',
        'usuario_mod',
        'estado',
        'registrado',
        'modificado',

        // ✅ NUEVOS CAMPOS
        'enviado_email',
        'fecha_envio_email',
    ];

    protected $casts = [
        'enviado_email' => 'boolean',
        'fecha_envio_email' => 'datetime',
        'estado' => 'boolean',
    ];

   

    public function cliente()
    {
        return $this->belongsTo(Persona::class, 'id_cliente');
    }

    public function empleado()
    {
        return $this->belongsTo(Persona::class, 'id_empleado');
    }

    public function usuario_registro()
    {
        return $this->belongsTo(Usuario::class, 'usuario_reg');
    }

    public function usuario_modificado()
    {
        return $this->belongsTo(Usuario::class, 'usuario_mod');
    }
}