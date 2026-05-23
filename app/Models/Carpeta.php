<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carpeta extends Model
{
    protected $table = 'carpetas';
    public $timestamps = false;


    protected $fillable = [
        'nombre',
        'padre_id',
        'usuario_id',
        'proceso_id',
        'proceso_type',
    ];

    public function subcarpetas()
    {
        return $this->hasMany(Carpeta::class, 'padre_id')->orderBy('nombre');
    }
    

  
    public function padre()
    {
        return $this->belongsTo(Carpeta::class, 'padre_id');
    }

   
    public function usuario()
    {
        return $this->belongsTo(\App\Models\User::class, 'usuario_id');
    }

  
    public function documentos()
    {
        return $this->hasMany(\App\Models\Documento::class, 'carpeta_id');
    }


   
    public function proceso()
{
    return $this->belongsTo(Proceso::class);
}

public function tipoProceso()
{
    return $this->belongsTo(TipoProceso::class, 'tipo_proceso_id');
}

public function hijos()
{
    return $this->hasMany(Carpeta::class, 'padre_id');
}

}
