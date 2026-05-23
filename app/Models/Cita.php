<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    use HasFactory;

    protected $table = 'citas';

    protected $fillable = [
        'id_cliente',
        'id_empleado',
        'titulo',
        'nota',
        'asunto',
        'mensaje',
        'fecha_hora_cita',
        'lugar_cita',
        'estado_cita',
        'registrado',
        'modificado',
        'usuario_registrado',
        'usuario_modificado',
        'estado',
    ];

    public $timestamps = false;


    public function cliente()
    {
        return $this->belongsTo(Persona::class, 'id_cliente');
    }

    public function empleado()
    {
        return $this->belongsTo(Persona::class, 'id_empleado');
    }

    public function usuarioRegistrado()
{
    return $this->belongsTo(Usuario::class, 'usuario_registrado');
}

public function usuarioModificado()
{
    return $this->belongsTo(Usuario::class, 'usuario_modificado');
}

}
