<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Carbon\Carbon;

class CitaCreadaNotification extends Notification
{
    use Queueable;

    protected $cita;

    public function __construct($cita)
    {
        $this->cita = $cita;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('📅 Nueva Cita Registrada')
            ->greeting('Hola ' . $notifiable->name)
            ->line('Se ha registrado una nueva cita en el sistema.')
            ->line('📌 Título: ' . ($this->cita->titulo ?? 'Sin título'))
            ->line('📅 Fecha y Hora: ' . Carbon::parse($this->cita->fecha_hora_cita)->format('d/m/Y H:i'))
            ->line('📍 Lugar: ' . ($this->cita->lugar_cita ?? 'No especificado'))
            ->line('📌 Estado: ' . $this->cita->estado_cita)
            ->action('Ver Citas', url('/citas'))
            ->line('Sistema Jurídico - Firma de Abogados');
    }
}