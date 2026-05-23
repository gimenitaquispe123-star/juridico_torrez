@extends('adminlte::page')

@section('title', 'Empleado')

@section('content_header')
<h1 class="text-dark" style="font-family: Georgia, serif; font-weight: 800;">
    Detalle del Empleado
</h1>
@stop

@section('content')
<div class="card shadow-lg">
    <div class="card-body">
        <h5>{{ $empleado->nombres }} {{ $empleado->paterno }} {{ $empleado->materno }}</h5>
        <p><strong>Tipo de Persona:</strong> {{ $empleado->tipoPersona->tipo_persona ?? '-' }}</p>
        <p><strong>CI:</strong> {{ $empleado->ci ?? '-' }}</p>
        <p><strong>Celular:</strong> {{ $empleado->celular ?? '-' }}</p>
        <p><strong>Área:</strong> {{ $empleado->area ?? '-' }}</p>
        <p><strong>Correo:</strong> {{ $empleado->email ?? '-' }}</p>
        <p><strong>Dirección:</strong> {{ $empleado->direccion ?? '-' }}</p>
        @if($empleado->foto)
            <p><strong>Foto:</strong><br>
            <img src="{{ asset('storage/'.$empleado->foto) }}" alt="Foto" style="max-width:150px;"></p>
        @endif
        <p><strong>Registrado:</strong> {{ $empleado->created_at ? $empleado->created_at->format('Y-m-d H:i') : '-' }}</p>
    </div>
    <div class="card-footer">
        <a href="{{ route('empleados.index') }}" class="btn btn-info">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>
</div>
@stop
