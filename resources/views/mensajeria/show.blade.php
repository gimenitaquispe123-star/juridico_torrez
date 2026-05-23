@extends('adminlte::page')

@section('title', 'Detalle del Mensaje')

@section('content_header')
<h1 class="text-dark" style="font-family: Georgia, serif; font-weight: 800;">
    Detalle del Mensaje
</h1>
@stop

@section('content')
<div class="card shadow-lg">
    <div class="card-header bg-info text-white">
        <h5><i class="fas fa-envelope"></i> Mensaje #{{ $mensaje->id }}</h5>
    </div>
    <div class="card-body">
        <p><strong>Cliente:</strong> {{ $mensaje->cliente->nombres ?? '—' }} {{ $mensaje->cliente->paterno ?? '' }}</p>
        <p><strong>Celular:</strong> {{ $mensaje->cliente->celular ?? '—' }}</p>
        <p><strong>Email:</strong> {{ $mensaje->cliente->email ?? '—' }}</p>
        <p><strong>Asunto:</strong> {{ $mensaje->asunto }}</p>
        <p><strong>Mensaje:</strong> {{ $mensaje->mensaje }}</p>
        <p><strong>Registrado:</strong> {{ $mensaje->registrado ? \Carbon\Carbon::parse($mensaje->registrado)->format('d/m/Y H:i') : '—' }}</p>
         <p><strong>Registrado por:</strong> {{ $mensaje->usuario_registro->usuario ?? '—' }}</p>

    </div>
    <div class="card-footer">
        <a href="{{ route('mensajeria.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>
</div>
@stop
