<?php

namespace App\Services;

use Twilio\Rest\Client;

class TwilioService
{
    protected $twilio;

    public function __construct()
    {
        $this->twilio = new Client(
            env('TWILIO_SID'),
            env('TWILIO_TOKEN')
        );
    }

    /**
     * Enviar mensaje de WhatsApp
     *
     * @param string $to      Número del destinatario (ej: +59177712345)
     * @param string $mensaje Mensaje a enviar
     */
    public function enviarWhatsApp($to, $mensaje)
    {
        $from = env('TWILIO_WHATSAPP_FROM'); // ej: whatsapp:+14155238886

        return $this->twilio->messages->create(
            "whatsapp:{$to}",
            [
                'from' => $from,
                'body' => $mensaje
            ]
        );
    }
}
