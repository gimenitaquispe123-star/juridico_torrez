@extends('adminlte::page')

@section('title', 'Expedientes - Listado')

@section('content_header')
<h1 class="text-dark" style="font-family: 'Merriweather', serif; font-weight: 800;">
    <i class="fas fa-folder-open text-black"></i> Expedientes 
    <small style="font-weight: 400;">Listado</small>
</h1>
@stop

@section('content')
<div class="card shadow-lg">

    <div class="card-header p-2">
        <ul class="nav nav-tabs" id="expedienteTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="tab-lista" data-toggle="tab" href="#listaExpedientes" role="tab">
                    📋 Lista Expedientes
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tab-abogados" data-toggle="tab" href="#detalleAbogados" role="tab">
                    <i class="fas fa-user-tie text-info"></i> Abogados Asignados
                </a>
            </li>
            
            <li class="nav-item ml-auto">
                 @can('crear expediente') 
                <a href="{{ route('expedientes.create') }}" class="btn btn-orange btn-sm">
                    <i class="fas fa-plus-circle"></i> Nuevo Expediente
                </a>
                 @endcan
            </li>
            @can('imprimir expediente')
            <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#exportarPdfModal">
                <i class="fas fa-file-pdf"></i> Exportar PDF
            </button>
             @endcan
        </ul>
    </div>

    <div class="card-body tab-content">
        <div class="tab-pane fade show active" id="listaExpedientes" role="tabpanel">
            <div class="row mb-3">
                <div class="col-md-6 d-flex align-items-center">
                    <form method="GET" id="formPerPage" class="form-inline">
                        <label class="mr-2 mb-0 font-weight-bold text-secondary">Mostrar</label>
                        <select name="per_page" id="pageLength" class="custom-select custom-select-sm w-auto" onchange="this.form.submit()">
                            <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5</option>
                            <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                            <option value="15" {{ request('per_page') == 15 ? 'selected' : '' }}>15</option>
                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                        </select>
                        <input type="hidden" name="buscar" value="{{ request('buscar') }}">
                    </form>
                </div>

                <div class="col-md-6 text-right">
                    <form method="GET" id="formBuscar" class="form-inline">
                        <label class="mr-2 mb-0 font-weight-bold text-secondary">Buscar:</label>
                        <input type="text" name="buscar" id="tableSearch" class="form-control form-control-sm d-inline-block w-auto" value="{{ request('buscar') }}" placeholder="Buscar expediente...">
                        <input type="hidden" name="per_page" value="{{ request('per_page', 10) }}">
                        <button type="submit" class="btn btn-sm btn-danger ml-2">Buscar</button>
                    </form>
                </div>
            </div>

        
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover text-center align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Codigo_expe</th>
                            <th>Expediente_N°</th>
                            <th>Demandante</th>
                            <th>Demandado</th>
                            <th>Estado</th>
                            <th>Usua_Registro</th>
                            <th style="width: 260px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($expedientes as $expediente)
                        <tr>
                            <td>{{ $expediente->codigo_expediente }}</td>
                            <td>{{ $expediente->nro_expediente }}</td>
                            <td>{{ strtoupper($expediente->cliente->nombre ?? $expediente->demandante) }}</td>
                            <td>{{ strtoupper($expediente->demandado) }}</td>
                            <td><span class="badge">{{ strtoupper($expediente->estado_expediente) }}</span></td>
                            <td>{{ $expediente->usuarioMod?->usuario ?? '---' }}</td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown">
                                        Acciones
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        
                                        <a class="dropdown-item" href="{{ route('expedientes.show', $expediente->id) }}">
                                            <i class="fas fa-eye text-primary"></i> Ver Detalle
                                        </a>
                                        @can('asignar abogado') 
                                        <a class="dropdown-item" href="{{ route('asignar-abogado.create', $expediente->id) }}">
                                            <i class="fas fa-user-tie text-success"></i> Asignar abogado
                                        </a>
                                         @endcan
                                        <a class="dropdown-item" href="{{ route('expedientes.edit', $expediente->id) }}">
                                            <i class="fas fa-edit text-primary"></i> Editar
                                        </a>
                                        @can('eliminar expediente') 
                                        <form action="{{ route('expedientes.destroy', $expediente->id) }}" method="POST" onsubmit="return confirm('¿Eliminar expediente?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="fas fa-trash-alt"></i> Eliminar
                                            </button>
                                        </form>
                                         @endcan
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">No se encontraron expedientes</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

          
            <div class="mt-3">
                {{ $expedientes->links('vendor.pagination.bootstrap-5') }}
            </div>

        </div>

        <div class="tab-pane fade" id="detalleAbogados" role="tabpanel">
            @include('expedientes.partials.detalle_abogados')
        </div>
        <div class="tab-pane fade" id="detalleDocumentos" role="tabpanel">
            <div id="documentosExpedienteContainer">
                <p class="text-muted">Seleccione un expediente en la lista para ver sus documentos.</p>
            </div>
        </div>
        <div class="tab-pane fade" id="detalleExpediente" role="tabpanel">
            <div id="detalleExpedienteContainer">
                <p class="text-muted">Seleccione un expediente en la lista para ver sus detalles.</p>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="exportarPdfModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg">

      <div class="modal-header bg-info text-white">
        <h5 class="modal-title">
          <i class="fas fa-file-pdf"></i> Exportar Expedientes PDF
        </h5>
        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
      </div>

      <form method="GET" target="_blank" id="formExportPdf" action="{{ route('expedientes.pdfVista') }}">
        
        <div class="modal-body">

          <!-- MES -->
          <div class="form-group">
            <label>Mes</label>
            <select name="mes" class="form-control">
              <option value="">Todos</option>
              <option value="1">Enero</option>
              <option value="2">Febrero</option>
              <option value="3">Marzo</option>
              <option value="4">Abril</option>
              <option value="5">Mayo</option>
              <option value="6">Junio</option>
              <option value="7">Julio</option>
              <option value="8">Agosto</option>
              <option value="9">Septiembre</option>
              <option value="10">Octubre</option>
              <option value="11">Noviembre</option>
              <option value="12">Diciembre</option>
            </select>
          </div>

          <!-- AÑO -->
          <div class="form-group">
            <label>Año</label>
            <input 
              type="number" 
              name="anio" 
              class="form-control" 
              min="2000" 
              max="2100" 
              placeholder="Ej: 2026">
          </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">
            Cancelar
          </button>
          <button type="submit" class="btn btn-danger">
            Generar PDF
          </button>
        </div>

      </form>

    </div>
  </div>
</div>
@stop

@section('css')
<style>
    .btn-orange {
        background-color: #080808;
        color: #fff;
        font-weight: 600;
    }
    .btn-orange:hover {
        background-color: #333;
        color: #fff;
    }
    .table th, .table td {
        vertical-align: middle !important;
    }
</style>
@stop

@section('js')
{{-- No es necesario DataTables --}}
@stop
