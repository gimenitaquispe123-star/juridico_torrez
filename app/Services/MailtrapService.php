<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class MailtrapService
{
    protected $apiToken;

    public function __construct()
    {
        $this->apiToken = env('MAILTRAP_API_TOKEN');
    }

    public function enviarCorreo($toEmail, $subject, $text)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiToken,
            'Content-Type' => 'application/json',
        ])->post('https://send.api.mailtrap.io/api/send', [
            'from' => [
                'email' => 'hello@demomailtrap.co',
                'name' => 'Bufet Jurídico'
            ],
            'to' => [
                ['email' => $toEmail]
            ],
            'subject' => $subject,
            'text' => $text,
            'category' => 'Notificacion Laravel'
        ]);

        return $response->successful();
    }
}
