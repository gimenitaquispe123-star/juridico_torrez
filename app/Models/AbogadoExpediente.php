<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbogadoExpediente extends Model
{
    use HasFactory;

    protected $table = 'abogado_expediente';
    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'id_expediente',
        'id_empleado',
        'fecha_asignacion',
        'fecha_desvinculacion',
        'observacion',
        'usuario_reg',
        'usuario_mod',
        'estado',
    ];

    protected $casts = [
        'fecha_asignacion' => 'date',
        'fecha_desvinculacion' => 'date',
        'registro' => 'datetime',
        'modificado' => 'datetime',
        'estado' => 'boolean',
    ];


    public function expediente()
    {
        return $this->belongsTo(Expediente::class, 'id_expediente');
    }

    public function empleado()
    {
        return $this->belongsTo(Persona::class, 'id_empleado');
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
