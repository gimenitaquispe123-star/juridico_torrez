<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Mensajeria;

class MensajeEnviado extends Mailable
{
    use Queueable, SerializesModels;

    public $mensaje;

    public function __construct(Mensajeria $mensaje)
    {
        $this->mensaje = $mensaje;
    }

    public function build()
    {
        return $this->subject('Nuevo mensaje: ' . $this->mensaje->asunto)
                    ->markdown('emails.mensajeria.enviado');
    }
}
