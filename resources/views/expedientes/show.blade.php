@extends('adminlte::page')

@section('title', 'Detalle del Expediente')

@section('content_header')
<h1><i class="fas fa-folder-open text-black"></i> Detalle del Expediente</h1>
@stop

@section('content')
<div class="card shadow-lg">
    <div class="card-header d-flex align-items-center p-2">
        <ul class="nav nav-tabs" id="expedienteDetalleTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="tab-general" data-toggle="tab" href="#detalleGeneral" role="tab">
                    <i class="fas fa--circle text-"></i> Información General
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tab-usuarios" data-toggle="tab" href="#detalleUsuarios" role="tab">
                    <i class="fas fa-user text-black"></i> Usuarios
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tab-observaciones" data-toggle="tab" href="#detalleObservaciones" role="tab">
                    <i class="fas fa-sticky-note text-black"></i> Observaciones
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tab-documentos" data-toggle="tab" href="#detalleDocumentos" role="tab">
                    <i class="fas fa-file-upload text-black"></i> Documentos
                </a>
            </li>
        </ul>

        <div class="ml-auto d-flex">
            <a href="{{ route('expedientes.edit', $expediente->id) }}" class="btn btn-info btn-sm mr-2">
                <i class="fas fa-edit"></i> Editar
            </a>
            <a href="{{ route('expedientes.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>

    <div class="card-body tab-content">
        <div class="tab-pane fade show active" id="detalleGeneral" role="tabpanel">
            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Código Expediente:</strong>
                    <p>{{ $expediente->codigo_expediente ?? '-' }}</p>
                </div>
                <div class="col-md-6">
                    <strong>Número de Expediente:</strong>
                    <p>{{ $expediente->nro_expediente ?? '-' }}</p>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Demandante:</strong>
                    <p>{{ strtoupper($expediente->demandante) ?? '-' }}</p>
                </div>
                <div class="col-md-6">
                    <strong>Demandado:</strong>
                    <p>{{ strtoupper($expediente->demandado) ?? '-' }}</p>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Cliente:</strong>
                    <p>{{ $expediente->cliente->nombres ?? '-' }} {{ $expediente->cliente->paterno ?? '' }} {{ $expediente->cliente->materno ?? '' }}</p>
                </div>
                <div class="col-md-6">
    <strong>Abogado Asignado:</strong>
    <p>
        @if($expediente->abogadoAsignado)
            {{ $expediente->abogadoAsignado->empleado->nombres ?? '' }}
            {{ $expediente->abogadoAsignado->empleado->paterno ?? '' }}
            {{ $expediente->abogadoAsignado->empleado->materno ?? '' }}
        @else
            -
        @endif
    </p>
</div>
                <div class="col-md-6">
                    <strong>Estado del Expediente:</strong>
                    <p>
                        <span class="badge {{ $expediente->estado_expediente ? 'bg-info' : 'bg-danger' }}">
                            {{ strtoupper($expediente->estado_expediente ?? 'INACTIVO') }}
                        </span>
                    </p>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Fecha Registro:</strong>
                    <p>{{ $expediente->registrado ? \Carbon\Carbon::parse($expediente->registrado)->format('d/m/Y H:i') : '-' }}</p>
                </div>
                <div class="col-md-6">
                    <strong>Fecha Modificación:</strong>
                    <p>{{ $expediente->modificado ? \Carbon\Carbon::parse($expediente->modificado)->format('d/m/Y H:i') : '-' }}</p>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="detalleUsuarios" role="tabpanel">
            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Usuario Registro:</strong>
                    <p>{{ $expediente->usuarioReg?->usuario ?? '-' }}</p>
                </div>
                <div class="col-md-6">
                    <strong>Usuario Modificación:</strong>
                    <p>{{ $expediente->usuarioMod?->usuario ?? '-' }}</p>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="detalleObservaciones" role="tabpanel">
            <div class="row">
                <div class="col-md-12">
                    <strong>Observaciones:</strong>
                    <p>{{ $expediente->observaciones ?? '-' }}</p>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="detalleDocumentos" role="tabpanel">
            <div class="row mb-3">
                <div class="col-md-12">
                   <h5>Documentos Asociados al Expediente</h5>

<ul class="list-group mb-3">
@if($expediente->respaldo)
<li class="list-group-item d-flex justify-content-between align-items-center">

    <div>
        <strong>Documento Principal</strong><br>
        {{ basename($expediente->respaldo) }}
    </div>

    <div class="btn-group">


        {{-- 🗑️ ELIMINAR --}}
        <form action="{{ route('expedientes.respaldo.delete', $expediente->id) }}" 
              method="POST" 
              onsubmit="return confirm('¿Eliminar documento principal?')"
              style="display:inline;">
            @csrf
            @method('DELETE')
            <button class="btn btn-sm btn-danger">
                <i class="fas fa-trash"></i>
            </button>
        </form>

    </div>

</li>
@endif

    @forelse($expediente->documentos as $doc)
        <li class="list-group-item d-flex justify-content-between align-items-center">

            <div>
                {{ $doc->nombre }}
            </div>

            <div class="btn-group">

<a href="{{ route('documentos.download', $doc->id_documento) }}" 
   class="btn btn-sm btn-" 
   title="Descargar">
    
    <i class="fas fa-download"></i> Descargar
</a>

                <form action="{{ route('documentos.delete', ['id' => $doc->id ?? $doc->id_documento]) }}" 
      method="POST"
      onsubmit="return confirm('¿Eliminar documento?')"
      style="display:inline;">
    @csrf
    @method('DELETE')
    <button class="btn btn-sm btn">
        <i class="fas fa-trash"></i>
    </button>
</form>

            </div>

        </li>
    @empty
        @if(!$expediente->respaldo)
            <li class="list-group-item">No hay documentos cargados.</li>
        @endif
    @endforelse

</ul>

<form action="{{ route('expedientes.documentos.upload', $expediente->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="input-group mb-3">
        <input type="file" name="archivo" class="form-control" required>
        <input type="text" name="nombre" class="form-control" placeholder="Nombre del documento (opcional)">
         </div>
        <button class="btn btn-danger" type="submit"><i class="fas fa-upload"></i> Subir Documento</button>
    </div>
</form>
    </div> 
</div> 
@stop

@section('css')
<style>
    body, p {
        font-family: Georgia, serif;
    }
    .nav-tabs .nav-link.active {
        background-color: #efeff0ff;
        color: #111111ff;
        font-weight: 600;
    }
</style>
@stops

@section('js')
<script>
$(function () {
    $('#expedienteDetalleTabs a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    })
})
</script>
@stop
