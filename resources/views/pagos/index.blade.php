@extends('adminlte::page')

@section('title', 'Pagos')

@section('content_header')
<h1 class="text-dark" style="font-family: Georgia, serif; font-weight: 800;">
    Pagos
</h1>
@stop

@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif


<div class="card shadow-lg">
    <div class="card-header d-flex flex-wrap justify-content-between align-items-center">
        <form method="GET" action="{{ route('pagos.index') }}" class="form-inline w-100">
            <div class="form-row align-items-center w-100">

                <div class="col-auto">
                    <select name="per_page" class="form-control form-control-sm" onchange="this.form.submit()">
                        <option disabled>Mostrar</option>
                        @foreach([5,10,15,25,50,100] as $cantidad)
                            <option value="{{ $cantidad }}" {{ request('perPage') == $cantidad ? 'selected' : '' }}>{{ $cantidad }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-auto">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm" placeholder="Buscar pago...">
                </div>

                <div class="col-auto">
                    <button type="submit" class="btn btn-info btn-sm">
                        <i class="fas fa-search"></i> Buscar
                    </button>
                </div>

                <div class="col-auto ml-auto d-flex">
                    <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#modalNuevoPago" 
                        style="background-color: #ffffff; color: #c21508ff; border: 1px solid #aa1906ff;">
                        <i class="fas fa-plus"></i> Nuevo
                    </button>
                                  </div>
                <div class="btn-group">
        <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-chart-bar"></i> Reportes
        </button>
        <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="{{ url('pagos/reportes/anual') }}">
                <i class="fas fa-calendar-alt text-primary"></i> Ver Anual
            </a>
            <a class="dropdown-item" href="{{ url('pagos/reportes/mensual') }}">
                <i class="fas fa-calendar text-success"></i> Ver Mensual
            </a>
                </div>
            </div>

          </div>
        </form>
    </div>

    <div class="card-body table-responsive">
        <table class="table table-bordered table-hover text-center">
            <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Glosa</th>
                    <th>Total</th>
                    <th>Pagado</th>
                    <th>Pendiente</th>
                    <th>Fecha Pago</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pagos as $pago)
                <tr>
                    <td>{{ $loop->iteration + ($pagos->currentPage()-1)*$pagos->perPage() }}</td>
                    <td>{{ $pago->cliente->nombre_completo }}</td>
                    <td>{{ $pago->glosa_pago }}</td>
                   <td>{{ number_format($pago->monto_total,0) }}</td>
                    <td>{{ number_format($pago->monto_pagado,0) }}</td>
                    <td>{{ number_format($pago->monto_pendiente,0) }}</td>
                    <td>{{ $pago->fecha_pago ? $pago->fecha_pago->format('d/m/Y') : '-' }}</td>
                    <td>{{ $pago->estado }}</td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                    id="accionesDropdown{{ $pago->id_pago }}"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Acciones
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="accionesDropdown{{ $pago->id_pago }}">
                                <a class="dropdown-item" href="{{ route('pagos.show', $pago->id_pago) }}">
                                    <i class="fas fa-eye text-info"></i> Detalles
                                </a>
                            @can('editar pago')
                                <a class="dropdown-item" href="{{ route('pagos.edit', $pago->id_pago) }}">
                                    <i class="fas fa-edit text-warning"></i> Editar
                                </a>
                          @endcan
                          
                                <a class="dropdown-item" href="{{ route('pagos.recibo', $pago->id_pago) }}">
                                <i class="fas fa-receipt text-info"></i>  emitir Recibo
                              </a>
                              
                              <a class="dropdown-item" href="{{ route('pagos.historial', [$pago->id_cliente, $pago->tarifa_id]) }}">
    <i class="fas fa-history text-info"></i> Historial
</a>
                               @can('eliminar pago') 
                                <form action="{{ route('pagos.destroy', $pago->id_pago) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="dropdown-item text-black" onclick="return confirm('¿Eliminar pago?')">
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
                    <td colspan="10" class="text-center text-muted">No hay pagos registrados.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="d-flex justify-content-between align-items-center mt-2">
            <div>
                Mostrando {{ $pagos->firstItem() ?? 0 }} - {{ $pagos->lastItem() ?? 0 }} de {{ $pagos->total() ?? 0 }} registros
            </div>
            <div>
                {{ $pagos->appends(request()->query())->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modalNuevoPago" tabindex="-1" role="dialog" aria-labelledby="modalNuevoPagoLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content border-0 shadow-lg">
      
     
      <div class="modal-header bg-info text-white">
        <h5 class="modal-title" id="modalNuevoPagoLabel">
          <i class="fas fa-coins"></i> Registrar Nuevo Pago
        </h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

     
      <form action="{{ route('pagos.store') }}" method="POST">
        @csrf
        <div class="modal-body">
          
          
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="id_cliente">Cliente <span class="text-danger"></span></label>
 <select name="id_cliente" id="id_cliente" class="form-control @error('id_cliente') is-invalid @enderror" required>
    <option value="">-- Seleccione Cliente --</option>
    @foreach($clientes as $cliente)
        <option value="{{ $cliente->id }}" {{ old('id_cliente') == $cliente->id ? 'selected' : '' }}>
            {{ $cliente->nombre_completo }}
        </option>
    @endforeach
</select>
@error('id_cliente')
    <span class="invalid-feedback">{{ $message }}</span>
@enderror

              
            </div>

            <div class="form-group col-md-6">
    <label for="tarifa_id">Tarifa</label>
    <select name="tarifa_id" id="tarifa_id"
        class="form-control @error('tarifa_id') is-invalid @enderror" required>

        <option value="">-- Seleccione Tarifa --</option>

        @foreach($tarifas as $tarifa)
            <option value="{{ $tarifa->id_tarifa }}"
                {{ old('tarifa_id') == $tarifa->id_tarifa ? 'selected' : '' }}>

                {{ $tarifa->tipoProceso->tipo_proceso ?? 'Sin proceso' }}
                - {{ $tarifa->categoria ?? 'General' }}
                ({{ number_format($tarifa->monto_min,0) }} - {{ number_format($tarifa->monto_max,0) }} Bs)

            </option>
        @endforeach

    </select>

    @error('tarifa_id')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>
          <div class="form-row">
            <div class="form-group col-md-4">
              <label for="monto_total">Monto Total (Bs.) <span class="text-danger"></span></label>
              <input type="number" step="0.01" name="monto_total" id="monto_total" 
                     class="form-control @error('monto_total') is-invalid @enderror"
                     value="{{ old('monto_total') }}" required>
              @error('monto_total')
                <span class="invalid-feedback">{{ $message }}</span>
              @enderror
            </div>

            <div class="form-group col-md-4">
              <label for="monto_pagado">Monto Pagado (Bs.)</label>
              <input type="number" step="0.01" name="monto_pagado" id="monto_pagado" 
                     class="form-control @error('monto_pagado') is-invalid @enderror"
                     value="{{ old('monto_pagado', 0) }}">
              @error('monto_pagado')
                <span class="invalid-feedback">{{ $message }}</span>
              @enderror
            </div>

            <div class="form-group col-md-4">
    <label for="monto_pendiente">
        Monto Pendiente (Bs.)
    </label>

    <input
        type="text"
        id="monto_pendiente"
        class="form-control bg-light text-danger font-weight-bold"
        value="Se calculará automáticamente"
        readonly
    >

    <small class="text-muted">
        El pendiente real se calcula tomando en cuenta pagos anteriores.
    </small>
</div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="fecha_pago">Fecha de Pago</label>
              <input type="date" name="fecha_pago" id="fecha_pago" 
                     class="form-control @error('fecha_pago') is-invalid @enderror"
                     value="{{ old('fecha_pago') }}">
              @error('fecha_pago')
                <span class="invalid-feedback">{{ $message }}</span>
              @enderror
            </div>

            <div class="form-group col-md-6">
              <label for="glosa_pago">Glosa / Detalle</label>
              <input type="text" name="glosa_pago" id="glosa_pago" 
                     class="form-control @error('glosa_pago') is-invalid @enderror"
                     value="{{ old('glosa_pago') }}" placeholder="Ej. Pago parcial, abono, etc." maxlength="255">
              @error('glosa_pago')
                <span class="invalid-feedback">{{ $message }}</span>
              @enderror
            </div>
          </div>

        </div>


        <div class="modal-footer">
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


@push('js')

<script>

    function calcularPendienteVisual() {

        let total = parseFloat(document.getElementById('monto_total').value) || 0;
        let pagado = parseFloat(document.getElementById('monto_pagado').value) || 0;

        // SOLO VISUAL
        let pendiente = total - pagado;

        if (pendiente < 0) {
            pendiente = 0;
        }

        document.getElementById('monto_pendiente').value =
            pendiente.toFixed(2);
    }

    document.getElementById('monto_total')
        .addEventListener('input', calcularPendienteVisual);

    document.getElementById('monto_pagado')
        .addEventListener('input', calcularPendienteVisual);

    $('#modalNuevoPago').on('shown.bs.modal', function () {

        calcularPendienteVisual();
    });

</script>

@endpush

@stop
