<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User; // ✅ Importar el modelo User

class EstadoProceso extends Model
{
    use HasFactory;

    protected $table = 'estados_proceso';

    protected $fillable = [
        'estado_proceso',
        'descripcion',
        'usuario_reg',
        'usuario_mod',
        'registrado',
        'modificado'
    ];

    public $timestamps = false;

    public function usuarioReg()
    {
        return $this->belongsTo(User::class, 'usuario_reg');
    }

    public function usuarioMod()
    {
        return $this->belongsTo(User::class, 'usuario_mod');
    }
}

