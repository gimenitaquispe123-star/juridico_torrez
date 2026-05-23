@extends('adminlte::page')

@section('title', 'Detalle de Notificación')

@section('content_header')
    <h2 class="text-center fw-bold" style="font-family: Georgia, serif;">
         Detalle de Notificación
    </h2>
@stop

@section('content')
<div class="card shadow rounded">
    <div class="card-header bg-info text-white">
        <h4 class="mb-0">Notificación #{{ $notificacion->id_notificacion }}</h4>
    </div>
    <div class="card-body">
        <p><strong>Título:</strong> {{ $notificacion->titulo }}</p>
        <p><strong>Mensaje:</strong> {{ $notificacion->mensaje }}</p>
        <p><strong>Usuario:</strong> {{ $notificacion->usuario->nombre ?? 'Sin usuario asignado' }}</p>
        <p><strong>Canal:</strong> {{ ucfirst($notificacion->canal) }}</p>
        <p><strong>Estado:</strong> {{ ucfirst($notificacion->estado) }}</p>
        <p><strong>Leído:</strong> 
            @if($notificacion->leido)
                <span class="badge bg-success">Sí</span>
            @else
                <span class="badge bg-danger">No</span>
            @endif
        </p>
        <p><strong>Fecha de Envío:</strong> {{ $notificacion->fecha_envio ? \Carbon\Carbon::parse($notificacion->fecha_envio)->format('d/m/Y H:i') : '-' }}</p>
        <p><strong>Fecha del Evento:</strong> {{ $notificacion->fecha_evento ? \Carbon\Carbon::parse($notificacion->fecha_evento)->format('d/m/Y H:i') : '-' }}</p>
    </div>
    <div class="card-footer text-end">
        <a href="{{ route('notificaciones.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
        <a href="{{ route('notificaciones.edit', $notificacion->id_notificacion) }}" class="btn btn-danger">
            <i class="fas fa-edit"></i> Editar
        </a>
    </div>
</div>
@stop
