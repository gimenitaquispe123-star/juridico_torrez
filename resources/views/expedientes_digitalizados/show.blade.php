@extends('adminlte::page')

@section('title', 'Detalles del Expediente Digitalizado')

@section('content_header')
<h1 class="text-dark" style="font-family: Georgia, serif; font-weight: 800;">
     Detalles del Expediente Digitalizado
</h1>
@stop

@section('content')

<div class="card shadow-lg">
    <div class="card-body">

        <div class="mb-3">
            <a href="{{ route('expedientes_digitalizados.index') }}" class="btn btn-danger">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>

        <h5 class="text-primary">
    <i class="fas fa-folder-open"></i> Información General
</h5>

<div class="row">

    <div class="col-md-2">
        <strong>ID:</strong><br>
        {{ $expediente->id }}
    </div>

    <div class="col-md-2">
        <strong>Cliente:</strong><br>
        {{ $expediente->cliente->nombres ?? '' }}
        {{ $expediente->cliente->paterno ?? '' }}
        {{ $expediente->cliente->materno ?? '' }}
    </div>

    <div class="col-md-2">
        <strong>Expediente:</strong><br>
        {{ $expediente->expediente->nombre_expediente 
            ?? $expediente->expediente->nro_expediente ?? '' }}
    </div>

    <div class="col-md-2">
        <strong>Nro. Expediente:</strong><br>
        {{ $expediente->nro_expediente }}
    </div>

    <div class="col-md-2">
        <strong>Tipo:</strong><br>
        {{ $expediente->tipo_expediente }}
    </div>

    <div class="col-md-2">
        <strong>Estado:</strong><br>
        <span class="text-success font-weight-bold">
            {{ $expediente->estado }}
        </span>
    </div>

</div>

        <hr>

        <h5 class="text-primary"><i class="fas fa-align-left"></i> Descripción</h5>
        <div class="row">
            <div class="col-md-12">
                <p>{{ $expediente->texto_expediente }}</p>
            </div>
        </div>

        <hr>

        <h5 class="text-primary"><i class="fas fa-file-pdf"></i> Documento Digital</h5>

<div class="row">

    <div class="col-md-6">
        <strong>Archivo:</strong><br>

        @if($expediente->url_documento)

            <a href="{{ route('expedientes_digitalizados.verPDF', basename($expediente->url_documento)) }}" 
               target="_blank" 
               class="btn btn-outline-danger mt-2">

                <i class="fas fa-file-pdf"></i> Ver Documento
            </a>

            <p class="mt-2 text-muted">
                {{ basename($expediente->url_documento) }}
            </p>

        @else
            <p class="text-danger">No disponible</p>
        @endif
    </div>

</div>
        


        <h5 class="text-primary"><i class="fas fa-users"></i> Control de Usuarios</h5>

<div class="row text-center">

    <div class="col-md-3">
        <div class="p-2 border rounded bg-light">
            <strong>Registrado por:</strong>
            <p class="mb-0">
                {{ $expediente->usuarioRegistro->usuario ?? 'No disponible' }}
            </p>
        </div>
    </div>

    <div class="col-md-3">
        <div class="p-2 border rounded bg-light">
            <strong>Modificado por:</strong>
            <p class="mb-0">
                {{ $expediente->usuarioModificacion->usuario ?? 'Sin modificaciones' }}
            </p>
        </div>
    </div>

    <div class="col-md-3">
        <div class="p-2 border rounded bg-light">
            <strong>Fecha Registro:</strong>
            <p class="mb-0">
                {{ $expediente->created_at->format('d/m/Y H:i') }}
            </p>
        </div>
    </div>

    <div class="col-md-3">
        <div class="p-2 border rounded bg-light">
            <strong>Última Modificación:</strong>
            <p class="mb-0">
                {{ $expediente->updated_at 
                    ? $expediente->updated_at->format('d/m/Y H:i') 
                    : 'Sin cambios' }}
            </p>
        </div>
    </div>

</div>

    </div>
</div>

@stop