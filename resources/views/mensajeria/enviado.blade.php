@component('mail::message')
# 📬 Nuevo mensaje

**Asunto:** {{ $mensaje->asunto }}

{{ $mensaje->mensaje }}

@component('mail::panel')
Este mensaje fue enviado por el sistema de mensajería del bufete.
@endcomponent

Gracias,<br>
{{ config('app.name') }}
@endcomponent
