<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Familiar;

class Evento extends Model
{
    // Si tu tabla no se llama 'eventos' (pero en este caso sí, así que no es necesario especificarlo)

    // Para permitir asignación masiva
    protected $fillable = [
        'familiar_id',
        'tipo',
        'fecha',
        'observaciones',
    ];

    // Relación: un evento pertenece a un familiar
    public function familiar()
    {
        return $this->belongsTo(Familiar::class, 'familiar_id', 'id_familiar');
    }
}
