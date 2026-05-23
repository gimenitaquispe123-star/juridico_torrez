<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Usuario;

class Persona extends Model
{
    use HasFactory;

    protected $table = 'personas';
    protected $primaryKey = 'id'; 
    public $timestamps = true;

    protected $fillable = [
        'id_tipo_persona',
        'nombres',
        'paterno',
        'materno',
        'ci',
        'ci_expedido',
        'celular',
        'direccion',
        'email',
        'fecha_nacimiento',
        'matricula',
        'area',
        'foto',
        'usuario_reg',   
        'usuario_mod',   
    ];

    public function tipoPersona()
    {
        return $this->belongsTo(TipoPersona::class, 'id_tipo_persona');
    }

    public function scopeClientes($query)
    {
        return $query->where('id_tipo_persona', 1);
    }

    public function scopeEmpleados($query)
    {
        return $query->where('id_tipo_persona', 2);
    }


    
public function getNombreCompletoAttribute()
{
    return trim("{$this->paterno} {$this->materno} {$this->nombres}");
}

    public function usuarios()
    {
        return $this->hasMany(Usuario::class, 'persona_id');
    }

    public function usuarioReg()
    {
        return Usuario::find($this->usuario_reg);
    }

    public function usuarioMod()
    {
        return Usuario::find($this->usuario_mod);
    }

    public function expedientes()
{
    return $this->hasMany(\App\Models\Expediente::class, 'id_cliente');
}


}
