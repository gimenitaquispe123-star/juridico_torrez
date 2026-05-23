<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    use HasFactory;

    protected $table = 'notificaciones';
    protected $primaryKey = 'id_notificacion';

    protected $fillable = [
        'usuario_id',
        'titulo',
        'mensaje',
        'fecha_envio',
        'fecha_evento',
        'estado',
        'canal',
        'leido',
        'url_direccion',
    ];

    // Relación: una notificación pertenece a un usuario
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id', 'id_usuarios');
    }
}
