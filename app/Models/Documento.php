<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    protected $table = 'documentos';
    protected $primaryKey = 'id_documento';
    public $incrementing = true;
    protected $keyType = 'int';

    public $timestamps = true;

    protected $fillable = [
        'nombre',
        'tipo',
        'archivo',
        'descripcion',
        'fecha_subida',
        'texto_extraido', 
        'proceso_id',
        'carpeta_id',
        'id_usuario',
        'userid_sha256',
        'id_cliente', 
        'expediente_id',
    ];


    protected $casts = [
        'fecha_subida' => 'datetime',
    ];



    public function carpeta()
    {
        return $this->belongsTo(Carpeta::class, 'carpeta_id');
    }
   

    public function usuario()
{
    return $this->belongsTo(\App\Models\Usuario::class, 'id_usuario', 'id');
}

    public function proceso()
    {
        return $this->belongsTo(Proceso::class, 'proceso_id');
    }

    public function cliente()
    {
        return $this->belongsTo(Persona::class, 'id_cliente'); 
    }


   
    public function tieneOCR(): bool
    {
        return !empty($this->texto_extraido);
    }
    public function expediente()
{
    return $this->belongsTo(Expediente::class, 'expediente_id');
}

   
}
