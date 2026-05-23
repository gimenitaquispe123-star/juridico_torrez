<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpedienteDocumento extends Model
{
    use HasFactory;

    protected $table = 'expedientes_documentos';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id_expediente',
        'documento_id',
        'observacion_descripcion',
        'ruta_documento',
        'usuario_regi',
        'usuario_modi',
        'registrado',
        'modificado',
        'estado',
    ];

    protected $casts = [
        'registrado' => 'datetime',
        'modificado' => 'datetime',
        'estado' => 'boolean',
    ];

    // Relaciones
    public function expediente()
    {
        return $this->belongsTo(Expediente::class, 'id_expediente', 'id')->withDefault();
    }

    public function documento()
    {
        return $this->belongsTo(Documento::class, 'documento_id', 'id_documento')->withDefault();
    }

    public function usuarioRegistro()
    {
        return $this->belongsTo(Usuario::class, 'usuario_regi', 'id')->withDefault();
    }

    public function usuarioModificacion()
    {
        return $this->belongsTo(Usuario::class, 'usuario_modi', 'id')->withDefault();
    }
}
