@extends('adminlte::page')

@section('title', 'Detalle Tipo de Proceso')

@section('content_header')
    <h1 class="text-dark" style="font-family: Georgia, serif; font-weight: 800;">
        Detalle Tipo de Proceso
    </h1>
@stop

@section('content')
<div class="card shadow-lg">
    <div class="card-header bg-light">
        <h5 class="mb-0">
            <i class="fas fa-info-circle text-primary"></i> Información Detallada
        </h5>
    </div>
    <div class="card-body">
        <div class="row mb-2">
            <div class="col-md-6"><strong>ID:</strong> {{ $tipoProceso->id }}</div>
            <div class="col-md-6"><strong>Tipo de Proceso:</strong> {{ $tipoProceso->tipo_proceso }}</div>
        </div>
        <div class="row mb-2">
            <div class="col-md-12"><strong>Descripción:</strong> {{ $tipoProceso->descripcion ?? '-' }}</div>
        </div>
        <div class="row mb-2">
            <div class="col-md-6"><strong>Registrado:</strong> {{ $tipoProceso->registrado ?? '-' }}</div>
            <div class="col-md-6"><strong>Usuario Registro:</strong> {{ $tipoProceso->usuario_reg ?? '-' }}</div>
        </div>
        <div class="row mb-2">
            <div class="col-md-6"><strong>Modificado:</strong> {{ $tipoProceso->modificado ?? '-' }}</div>
            <div class="col-md-6"><strong>Usuario Modificación:</strong> {{ $tipoProceso->usuario_mod ?? '-' }}</div>
        </div>

        <div class="mt-3">
            <a href="{{ route('tipos_proceso.index') }}" class="btn btn-info">
                <i class="fas fa-arrow-left"></i> Volver
            </a>

            
        </div>
    </div>
</div>
@stop
