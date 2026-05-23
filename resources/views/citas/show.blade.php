@extends('adminlte::page')

@section('title', 'Detalle de Cita')

@section('content_header')
    <h1 style="font-family: Georgia, 'Times New Roman', serif;">
        <i class=""></i> Detalle Cita
    </h1>
@stop

@section('content')
<div class="card shadow-lg">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 mb-3">
                <strong>Cliente:</strong> {{ $cita->cliente->nombres ?? 'Sin asignar' }}
            </div>
            <div class="col-md-6 mb-3">
                <strong>Empleado:</strong> {{ $cita->empleado->nombres ?? 'Sin asignar' }}
            </div>
            <div class="col-md-6 mb-3">
                <strong>Título:</strong> {{ $cita->titulo ?? '---' }}
            </div>
            <div class="col-md-6 mb-3">
                <strong>Asunto:</strong> {{ $cita->asunto ?? '---' }}
            </div>
            <div class="col-md-6 mb-3">
                <strong>Fecha / Hora:</strong> {{ \Carbon\Carbon::parse($cita->fecha_hora_cita)->format('d/m/Y H:i') }}
            </div>
            <div class="col-md-6 mb-3">
                <strong>Lugar:</strong> {{ $cita->lugar_cita ?? '---' }}
            </div>
            <div class="col-md-6 mb-3">
                <strong>Estado:</strong> 
                <span class="badge bg-{{ $cita->estado_cita == 'Completada' ? 'success' : ($cita->estado_cita == 'Cancelada' ? 'danger' : 'warning') }}">
                    {{ strtoupper($cita->estado_cita ?? 'Pendiente') }}
                </span>
            </div>
            <div class="col-12 mb-3">
                <strong>Mensaje:</strong>
                <p class="mt-2">{{ $cita->mensaje ?? 'Sin mensaje adicional' }}</p>
            </div>

           <div class="col-md-6 mb-3">
    <strong>Usuario que Registró:</strong> 
    {{ $cita->usuarioRegistrado->usuario ?? '-' }}
</div>
<div class="col-md-6 mb-3">
    <strong>Usuario que Modificó:</strong> 
    {{ $cita->usuarioModificado->usuario ?? '-' }}
</div>

        </div>
    </div>

    <div class="card-footer text-end">
        <a href="{{ route('citas.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Volver</a>
        <a href="{{ route('citas.edit', $cita->id) }}" class="btn btn-info"><i class="fas fa-edit"></i> Editar</a>
    </div>
</div>
@stop

