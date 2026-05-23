<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes'; // si tu tabla se llama clientes

    protected $fillable = [
        'persona_id',
        'usuario_reg',
        'usuario_mod',
        // otros campos que quieras llenar
    ];

    public function persona()
    {
        return $this->belongsTo(Persona::class);
    }
}
