<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NotificacionAudiencia extends Notification
{
    use Queueable;

    protected $titulo;
    protected $mensaje;

    public function __construct($titulo, $mensaje)
    {
        $this->titulo = $titulo;
        $this->mensaje = $mensaje;
    }

    public function via($notifiable)
    {
        return ['mail']; 
    }

    
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject($this->titulo)
                    ->line($this->mensaje)
                    ->action('Ver Notificación', url('/notificaciones'));
    }
}

