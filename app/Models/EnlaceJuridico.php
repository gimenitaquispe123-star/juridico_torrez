<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnlaceJuridico extends Model
{
    use HasFactory;

    protected $table = 'enlaces_juridicos';

    protected $fillable = [
        'nombre',
        'enlace',
        'descripcion',
        'estado',
        'registrado_por',
        'modificado_por',
    ];

    
    public function usuarioRegistrado()
    {
        return $this->belongsTo(Usuario::class, 'registrado_por');
    }

    public function usuarioModificado()
    {
        return $this->belongsTo(Usuario::class, 'modificado_por');
    }
}
