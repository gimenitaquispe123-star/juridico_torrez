@extends('adminlte::page')

@section('title', 'Gestión de Tarifas')

@section('content_header')
<h1 class="text-dark fw-bold" style="font-family: 'Merriweather', serif;">
    <i class="fas fa-coins text-info"></i> Gestión de Tarifas
</h1>
@stop

@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<div class="card shadow-lg border-0">
    <div class="card-header bg-white d-flex flex-wrap justify-content-between align-items-center">
        <form method="GET" action="{{ route('tarifas.index') }}" class="form-inline w-100">
            <div class="form-row align-items-center w-100">

                <div class="col-auto">
                    <select name="per_page" class="form-control form-control-sm" onchange="this.form.submit()">
                        <option disabled>Mostrar</option>
                        @foreach([5,10,15,25,50,100] as $cantidad)
                            <option value="{{ $cantidad }}" {{ request('per_page') == $cantidad ? 'selected' : '' }}>
                                {{ $cantidad }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-auto">
                    <input type="text" name="buscar" value="{{ request('buscar') }}" 
                           class="form-control form-control-sm" 
                           placeholder="Buscar por tipo de proceso o documento...">
                </div>

                <div class="col-auto">
                    <button type="submit" class="btn btn-info btn-sm">
                        <i class="fas fa-search"></i> Buscar
                    </button>
                </div>

                <div class="col-auto ml-auto d-flex">
                    <button type="button" class="btn btn-outline-danger btn-sm mr-2" data-toggle="modal" data-target="#modalNuevaTarifa">
                        <i class="fas fa-plus"></i> Nueva Tarifa
                    </button>
                    
                </div>
            </div>
        </form>
    </div>


    <div class="card-body table-responsive">
        <table class="table table-bordered table-hover text-center">
            <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th>Tipo Proceso</th>
                    <th>Categoría</th>
                    <th>Monto Mínimo</th>
                    <th>Monto Máximo</th>
                    <th>BS</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tarifas as $tarifa)
                <tr>
                    <td>{{ $loop->iteration + ($tarifas->currentPage()-1)*$tarifas->perPage() }}</td>
                   <td>{{ $tarifa->tipoProceso->tipo_proceso ?? '-' }}</td>

                    <td>{{ $tarifa->categoria ?? '-' }}</td>
                    <td>{{ number_format($tarifa->monto_min, 2) }}</td>
                    <td>{{ number_format($tarifa->monto_max, 2) }}</td>
                    <td>{{ $tarifa->moneda }}</td>
                    
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                id="accionesDropdown{{ $tarifa->id_tarifa }}"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Acciones
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="accionesDropdown{{ $tarifa->id_tarifa }}">
                                <a class="dropdown-item" href="{{ route('tarifas.show', $tarifa->id_tarifa) }}">
                                    <i class="fas fa-eye text-info"></i> Detalles
                                </a>
                                <a class="dropdown-item" href="{{ route('tarifas.edit', $tarifa->id_tarifa) }}">
                                    <i class="fas fa-edit text-warning"></i> Editar
                                </a> 
                          
                                <form action="{{ route('tarifas.destroy', $tarifa->id_tarifa) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="dropdown-item text-danger" onclick="return confirm('¿Eliminar tarifa?')">
                                        <i class="fas fa-trash-alt"></i> Eliminar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="11" class="text-center text-muted">No hay tarifas registradas.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="d-flex justify-content-between align-items-center mt-2">
            <div>
                Mostrando {{ $tarifas->firstItem() ?? 0 }} - {{ $tarifas->lastItem() ?? 0 }}
                de {{ $tarifas->total() ?? 0 }} registros
            </div>
            <div>
                {{ $tarifas->appends(request()->query())->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalNuevaTarifa" tabindex="-1" role="dialog" aria-labelledby="modalNuevaTarifaLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content border-0 shadow-lg">

      <div class="modal-header bg-info text-white">
        <h5 class="modal-title" id="modalNuevaTarifaLabel">
          <i class="fas fa-coins"></i> Registrar Nueva Tarifa
        </h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form action="{{ route('tarifas.store') }}" method="POST">
        @csrf
        <div class="modal-body">

          <div class="form-group">
            <label for="tipo_proceso_id">Tipo de Proceso <span class="text-danger"></span></label>
            <select name="tipo_proceso_id" id="tipo_proceso_id" class="form-control" required>
              <option value="">Seleccione...</option>
              @foreach($tiposProcesos as $tipo)
                <option value="{{ $tipo->id }}">{{ $tipo->tipo_proceso }}</option>
              @endforeach
            </select>
          </div>

          <div class="form-group">
            <label for="categoria">Categoría</label>
            <input type="text" name="categoria" id="categoria" class="form-control" placeholder="Ej. Básica, Premium">
          </div>

          <div class="form-row">
            <div class="form-group col-md-4">
              <label for="monto_min">Monto Mínimo <span class="text-danger"></span></label>
              <input type="number" name="monto_min" id="monto_min" step="0.01" class="form-control" required>
            </div>
            <div class="form-group col-md-4">
              <label for="monto_max">Monto Máximo <span class="text-danger"></span></label>
              <input type="number" name="monto_max" id="monto_max" step="0.01" class="form-control" required>
            </div>
            <div class="form-group col-md-4">
              <label for="moneda">Moneda</label>
              <select name="moneda" id="moneda" class="form-control">
                <option value="Bs">Bolivianos (Bs)</option>
                <option value="$us">Dólares ($us)</option>
              </select>
            </div>
          </div>

        </div>

        <div class="modal-footer bg-light">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">
            <i class="fas fa-times"></i> Cancelar
          </button>
          <button type="submit" class="btn btn-info">
            <i class="fas fa-save"></i> Registrar
          </button>
        </div>
      </form>
    </div>
  </div>
</div>


</div>
@stop
