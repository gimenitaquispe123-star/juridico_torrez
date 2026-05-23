<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoPersona extends Model
{
    use HasFactory;

    protected $table = 'tipos_personas';

    protected $primaryKey = 'id';

    public $timestamps = false; 

    protected $fillable = [
        'tipo_persona',
        'descripcion',
        'registrado',
        'modificado',
        'usuario_reg',
        'usuario_mod',
    ];


    
    public function personas()
    {
        return $this->hasMany(Persona::class, 'id_tipo_persona');
    }
    public function usuario_reg()
{
    return $this->belongsTo(Usuario::class, 'usuario_reg', 'id');
}

public function usuario_mod()
{
    return $this->belongsTo(Usuario::class, 'usuario_mod', 'id');
}

}

