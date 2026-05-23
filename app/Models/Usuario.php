<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Usuario extends Authenticatable
{
    use Notifiable, HasRoles;

    protected $table = 'usuarios';

    protected $fillable = [
        'persona_id',
        'usuario',
        'rol',
        'email',
        'password',
        'nombre',
        'estado',
        'usuario_reg', 
        'usuario_mod',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'persona_id', 'id');
    }

    public function usuarioReg()
    {
        return $this->belongsTo(Usuario::class, 'usuario_reg', 'id');
    }

    public function usuarioMod()
    {
        return $this->belongsTo(Usuario::class, 'usuario_mod', 'id');
    }

    public function getNameAttribute()
    {
        return $this->nombre ?? $this->usuario;
    }

    public function adminlte_desc()
    {
        return $this->email;
    }

    public function adminlte_name()
    {
        if ($this->persona && !empty($this->persona->nombre_completo)) {
            return $this->persona->nombre_completo;
        }
        return $this->nombre ?? $this->usuario ?? 'Usuario sin nombre';
    }
}
