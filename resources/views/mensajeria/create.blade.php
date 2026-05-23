@extends('adminlte::page')

@section('title', 'Nuevo Mensaje')

@section('content_header')
<h1 class="text-primary" style="font-family: Georgia;">
📩 Enviar Nuevo Mensaje
</h1>
@stop


@section('content')

<div class="card shadow">

<div class="card-header bg-primary text-white">
<i class="fas fa-edit"></i> Crear Mensaje
</div>


<div class="card-body">

<form action="{{ route('mensajeria.store') }}" method="POST">

@csrf


{{-- CLIENTE --}}
<div class="form-group">

<label for="id_cliente">Cliente</label>

<select name="id_cliente" id="id_cliente" class="form-control select2" required>

<option value="">Seleccione...</option>

@isset($clientes)

@foreach ($clientes as $cliente)

<option value="{{ $cliente->id }}"
{{ old('id_cliente') == $cliente->id ? 'selected' : '' }}>

{{ $cliente->nombres ?? $cliente->nombre }}

</option>

@endforeach

@endisset

</select>

</div>



{{-- ASUNTO --}}
<div class="form-group mt-3">

<label for="asunto">Asunto</label>

<input type="text"
name="asunto"
class="form-control"
maxlength="150"
required>

</div>



{{-- MENSAJE --}}
<div class="form-group mt-3">

<label for="mensaje">Mensaje</label>

<textarea name="mensaje"
class="form-control"
rows="5"
required></textarea>

</div>



{{-- TIPO ENVIO --}}
<div class="form-group mt-4">

<label>Enviar por:</label>

<div class="form-check">

<input class="form-check-input"
type="radio"
name="tipo_envio"
value="email"
required>

<label class="form-check-label">

📧 Email

</label>

</div>


<div class="form-check">

<input class="form-check-input"
type="radio"
name="tipo_envio"
value="whatsapp">

<label class="form-check-label">

🟢 WhatsApp

</label>

</div>


<div class="form-check">

<input class="form-check-input"
type="radio"
name="tipo_envio"
value="ambos">

<label class="form-check-label">

📧🟢 Email y WhatsApp

</label>

</div>

</div>



{{-- BOTONES --}}
<div class="d-flex justify-content-end mt-4">

<a href="{{ route('mensajeria.index') }}"
class="btn btn-secondary mr-2">

Cancelar

</a>

<button type="submit"
class="btn btn-primary">

<i class="fas fa-paper-plane"></i> Enviar

</button>

</div>


</form>

</div>

</div>

@stop