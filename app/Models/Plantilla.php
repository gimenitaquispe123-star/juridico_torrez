<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plantilla extends Model
{
    use HasFactory;

    
    protected $table = 'plantillas';

    protected $fillable = [
        'id_tipo_plantilla',
        'plantilla',
        'descripcion',
        'ruta_archivo',
        'usuario_reg',
        'usuario_mod',
        'estado',
    ];


    public $timestamps = false;

    public function tipoPlantilla()
    {
        return $this->belongsTo(TipoPlantilla::class, 'id_tipo_plantilla');
    }

    public function getArchivoUrlAttribute()
    {
        return $this->ruta_archivo
            ? asset('storage/' . $this->ruta_archivo)
            : null;
    }

    public function scopeActivas($query)
    {
        return $query->where('estado', 1);
    }
}
