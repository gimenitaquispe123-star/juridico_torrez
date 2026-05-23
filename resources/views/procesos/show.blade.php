@extends('adminlte::page')

@section('title', 'Detalle del Proceso')

@section('content_header')
<h1 style="font-family: Georgia, serif; color: #2c3e50;">
    Detalle del Proceso
</h1>
@stop

@section('content')
<div class="container-fluid mt-3">
    @if(isset($proceso))
        <div class="card shadow-sm border-0 rounded">

            <ul class="nav nav-tabs" id="procesoTabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="detalle-tab" data-toggle="tab" href="#detalle" role="tab"
                       aria-controls="detalle" aria-selected="true">Detalle</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="documentos-tab" data-toggle="tab" href="#documentos" role="tab"
                       aria-controls="documentos" aria-selected="false">
                        <i class="fas fa-file-alt mr-1"></i> Documentos
                    </a>
                </li>
            </ul>

            <div class="tab-content" id="procesoTabsContent">

                <div class="tab-pane fade show active p-4" id="detalle" role="tabpanel" aria-labelledby="detalle-tab">

                    <div class="row g-3">
                        {{-- Cliente --}}
                        <div class="col-md-4">
                            <div class="card border-info shadow-sm h-100">
                                <div class="card-header  text-black">
                                    <i class="fas fa-user"></i> Información del Cliente
                                </div>
                                <div class="card-body">
                                    <p><strong>Cliente:</strong> 
@if($proceso->cliente)
    {{ $proceso->cliente->nombres ?? '' }}
    {{ $proceso->cliente->paterno ?? '' }}
    {{ $proceso->cliente->materno ?? '' }}
@else
    -
@endif
</p>
                                    <p><strong>Posición:</strong> {{ $proceso->posicion->nombre ?? '-' }}</p>
                                    <p><strong>Contrario:</strong> {{ $proceso->contrario ?? '-' }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card border-success shadow-sm h-100">
                                <div class="card-header text-black">
                                    <i class="fas fa-gavel"></i> Datos del Proceso
                                </div>
                                <div class="card-body">
                                    <p><strong>Nombre:</strong> {{ $proceso->proceso ?? '-' }}</p>
                                    <p><strong>Tipo:</strong> {{ $proceso->tipoProceso->tipo_proceso ?? '-' }}</p>
                                    <p><strong>Estado:</strong> {{ $proceso->estadoProceso->estado_proceso ?? '-' }}</p>
                                </div>
                            </div>
                        </div>

                       
                        <div class="col-md-4">
                            <div class="card border-warning shadow-sm h-100">
                                <div class="card-header  text-black">
                                    <i class="fas fa-user-tie"></i> Abogado y Expediente
                                </div>
                                <div class="card-body">
                                    <p><strong>Abogado Asignado:</strong> @if($proceso->expediente && $proceso->expediente->abogadoAsignado)
    {{ $proceso->expediente->abogadoAsignado->empleado->nombres }}
    {{ $proceso->expediente->abogadoAsignado->empleado->paterno }}
    {{ $proceso->expediente->abogadoAsignado->empleado->materno }}
@else
    -
@endif</p>
                                    <p><strong>Expediente:</strong> {{ $proceso->expediente->codigo_expediente ?? '-' }}</p>
                                    <p><strong>Estado:</strong> {{ $proceso->estadoProceso->estado_proceso ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 mt-3">
                        <div class="col-md-6">
                            <div class="card border-dark shadow-sm h-100">
                                <div class="card-header text-black">
                                    <i class="fas fa-user-check"></i> Información de Registro
                                </div>
                                <div class="card-body">
                                    <p><strong>Registrado por:</strong> {{ $proceso->usuario_reg ?? 'No registrado' }}</p>
                                    <p><strong>Fecha de Registro:</strong> {{ $proceso->created_at ? $proceso->created_at->format('d/m/Y H:i') : '-' }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card border-secondary shadow-sm h-100">
                                <div class="card-header text-black">
                                    <i class="fas fa-user-edit"></i> Última Modificación
                                </div>
                                <div class="card-body">
                                    <p><strong>Modificado por:</strong> {{ $proceso->usuario_mod ?? 'Sin modificaciones' }}</p>
                                    <p><strong>Fecha de Modificación:</strong> {{ $proceso->updated_at ? $proceso->updated_at->format('d/m/Y H:i') : '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                                        <div class="row g-3 mt-3">
                        <div class="col-md-6">
                            <div class="card border-primary shadow-sm h-100">
                                <div class="card-header  text-black">
                                    <i class="fas fa-users"></i> Involucrados
                                </div>
                                <div class="card-body">
                                    <p style="font-size: 15px;">{{ $proceso->involucrados ?? '-' }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card border-secondary shadow-sm h-100">
                                <div class="card-header  text-black">
                                    <i class="fas fa-align-left"></i> Descripción
                                </div>
                                <div class="card-body">
                                    <p style="font-size: 15px;">{{ $proceso->descripcion ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                   
                    <div class="mt-4 text-center">
                        <a href="{{ route('procesos.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Volver
                        </a>
                        <a href="{{ route('procesos.edit', $proceso->id) }}" class="btn btn-info">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                    </div>

                </div>

              
                {{-- DOCUMENTOS DEL PROCESO --}}

<div class="tab-pane fade p-3" id="documentos" role="tabpanel" aria-labelledby="documentos-tab">

@if(session('success'))
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
@endif

{{-- FORMULARIO SUBIR DOCUMENTO --}}
<form action="{{ route('documentos.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <input type="hidden" name="proceso_id" value="{{ $proceso->id }}">

    {{-- FILA 1: NOMBRE + CARPETA --}}
    <div class="row">

        {{-- NOMBRE --}}
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label class="font-weight-bold">
                    Nombre del Documento
                </label>

                <input type="text"
                       name="nombre"
                       class="form-control"
                       placeholder="Ej: Demanda, Contrato, Prueba documental"
                       required>
            </div>
        </div>

        {{-- CARPETA --}}
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label class="font-weight-bold">
                    Carpeta
                </label>

                <select name="carpeta_id" class="form-control">
                    <option value="">
                        -- Seleccionar Carpeta --
                    </option>

                    @foreach($carpetas as $carpeta)
                        <option value="{{ $carpeta->id }}">
                            {{ $carpeta->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

    </div>

    {{-- FILA 2: ARCHIVO --}}
    <div class="row">
        <div class="col-md-12">
            <div class="form-group mb-3">
                <label class="font-weight-bold">
                    Archivo
                </label>

                <input type="file"
                       name="archivo"
                       class="form-control"
                       required>
            </div>
        </div>
    </div>

    {{-- FILA 3: DESCRIPCIÓN --}}
    <div class="row">
        <div class="col-md-12">
            <div class="form-group mb-3">
                <label class="font-weight-bold">
                    Descripción
                </label>

                <textarea name="descripcion"
                          class="form-control"
                          rows="2"
                          placeholder="Descripción del documento"></textarea>
            </div>
        </div>
    </div>

    {{-- BOTÓN --}}
    <button type="submit" class="btn btn-info">
        <i class="fas fa-upload"></i>
        Subir Documento
    </button>

</form>

<hr>
<form method="GET" class="mb-3">

    <label><strong>Mostrar:</strong></label>
    

    <select name="per_page" class="form-control w-auto d-inline"
            onchange="this.form.submit()">

        <option value="5"  {{ request('per_page') == 5 ? 'selected' : '' }}>5</option>
        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
        <option value="15" {{ request('per_page') == 15 ? 'selected' : '' }}>15</option>
        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
        <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>

    </select>
<label><strong>Entrada:</strong></label>
</form>
{{-- LISTA DE DOCUMENTOS --}}
<h5 class="mb-3"><i class="fas fa-folder-open"></i> Documentos del Proceso</h5>

<table class="table table-bordered table-hover table-sm">
    <thead class="thead-light">
        <tr>
            <th>Nombre</th>
            <th>Archivo</th>
            <th>Subido por</th>
            <th>Fecha</th>
        </tr>
    </thead>

    <tbody>
        @forelse($documentos as $doc)
        <tr>

            <td>
                <i class="fas fa-file-alt text-primary"></i>
                {{ $doc->nombre }}
            </td>

            <td>
               <a href="{{ route('documentos.ver', $doc->id_documento) }}" 
   target="_blank"
   class="btn btn-sm btn-info">
   <i class="fas fa-eye"></i>
</a>

            </td>

            <td>
                {{ $doc->usuario->usuario ?? 'Desconocido' }}
            </td>

            <td>
                {{ \Carbon\Carbon::parse($doc->fecha_subida)->format('d/m/Y H:i') }}
            </td>

        </tr>
        @empty
        <tr>
            <td colspan="4" class="text-center text-muted">
                <i class="fas fa-info-circle"></i> No hay documentos registrados
            </td>
        </tr>
        @endforelse
    </tbody>
</table>

{{-- PAGINACIÓN --}}
<div class="d-flex justify-content-center mt-3">
    {{ $documentos->links() }}
</div>


        </div>
    @else
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i> No se encontró información del proceso.
        </div>
    @endif
</div>
@stop

@section('css')
<style>
    .card {
        border-radius: 12px;
    }
    .card-header {
        font-weight: 600;
        font-size: 16px;
    }
    p {
        margin-bottom: 0.5rem;
        font-size: 15px; 
    }
    hr {
        border-top: 1px solid #dee2e6;
    }
</style>
@stop
