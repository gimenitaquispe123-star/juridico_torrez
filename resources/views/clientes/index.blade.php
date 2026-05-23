@extends('adminlte::page')

@section('title', 'Clientes')

@section('content_header')
<h1 class="text-dark" style="font-family: Georgia, serif; font-weight: 800;">
    Clientes
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
    <div class="card-header d-flex flex-wrap align-items-center">
       
        <form method="GET" action="{{ route('clientes.index') }}" class="form-inline d-flex flex-wrap align-items-center">
            <div class="form-group mr-2 mb-1">
                <select name="per_page" class="form-control form-control-sm" onchange="this.form.submit()">
                    <option disabled>Mostrar</option>
                    @foreach([5,10,15,25,50,100] as $cantidad)
                        <option value="{{ $cantidad }}" {{ request('per_page') == $cantidad ? 'selected' : '' }}>
                            {{ $cantidad }}
                        </option>
                    @endforeach
                </select>
            

            <div class="form-group mr-2 mb-1">
                <input type="text" name="buscar" value="{{ request('buscar') }}" class="form-control form-control-sm" placeholder="Buscar cliente...">
            </div>

            <button type="submit" class="btn btn-info btn-sm mb-1">
                <i class="fas fa-search"></i> Buscar
            </button>
        </form>

        
        <div class="d-flex flex-wrap align-items-center ml-auto">
      @can('crear clientes') 
            <button type="button" class="btn btn-sm mr-2 mb-1" 
                data-toggle="modal" data-target="#modalNuevoCliente" 
                style="background-color: #ffffff; color: #0b5ed7; border: 1px solid #0b5ed7;">
                <i class="fas fa-plus me-1"></i> Nuevo
            </button>
     @endcan 
            <form action="{{ route('clientes.export.pdf') }}" method="GET" class="d-flex align-items-center mb-1">
                <input type="month" name="fecha" class="form-control form-control-sm mr-2" style="width: 140px;" onchange="this.form.submit()">
                <button type="submit" class="btn btn-danger btn-sm">
                    <i class="fas fa-file-pdf"></i> PDF
                </button>
            </form>
        </div>
    </div>
</div>


    <div class="card-body table-responsive">
        <table class="table table-bordered table-hover text-center">
            <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th>Nombre Completo</th>
                    <th>Celular</th>
                    <th>Fecha Registro</th>
                    <th>Usuario Registro</th>
                    <th>Usuario Modificación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            @forelse($clientes as $cliente)
                <tr>
                    <td>{{ $loop->iteration + ($clientes->currentPage()-1)*$clientes->perPage() }}</td>
                    <td>{{ $cliente->nombres }} {{ $cliente->paterno }} {{ $cliente->materno }}</td>
                    <td>{{ $cliente->celular ?? '-' }}</td>
                    <td>{{ $cliente->created_at ? $cliente->created_at->format('Y-m-d H:i') : '-' }}</td>
                    <td>{{ $cliente->usuario_reg ? \App\Models\Usuario::find($cliente->usuario_reg)?->name ?? '-' : '-' }}</td>
                    <td>{{ $cliente->usuario_mod ? \App\Models\Usuario::find($cliente->usuario_mod)?->name ?? '-' : '-' }}</td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                    id="accionesDropdown{{ $cliente->id }}"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Acciones
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="accionesDropdown{{ $cliente->id }}">
                                <a class="dropdown-item" href="{{ route('clientes.show', $cliente->id) }}">
                                    <i class="fas fa-eye"></i> Ver
                                </a>
                            @can('editar clientes')    
                                <a class="dropdown-item" href="{{ route('clientes.edit', $cliente->id) }}">
                                    <i class="fas fa-edit text-warning"></i> Editar
                                </a>  
                            @endcan
                          @can('eliminar clientes')       
                                <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="dropdown-item text-danger" onclick="return confirm('¿Eliminar cliente?')">
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
                    <td colspan="8" class="text-center text-muted">No hay clientes registrados.</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        <div class="d-flex justify-content-between align-items-center mt-2">
            <div class="d-flex justify-content-between align-items-center mt-2">

    <div>
        Mostrando {{ $clientes->firstItem() ?? 0 }} - {{ $clientes->lastItem() ?? 0 }}
        de {{ $clientes->total() ?? 0 }} registros
    </div>

    <div>
        {{ $clientes->appends(request()->query())->links('pagination::bootstrap-4') }}
    </div>

</div>
        </div>
    </div>
</div>

{{-- Modal Nuevo Cliente --}}
<div class="modal fade" id="modalNuevoCliente" tabindex="-1" role="dialog" aria-labelledby="modalNuevoClienteLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content border-0 shadow-lg">
      <div class="modal-header bg-info text-white">
        <h5 class="modal-title" id="modalNuevoClienteLabel"><i class="fas fa-user-plus"></i> Nuevo Cliente</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('clientes.store') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="form-row">
              <div class="form-group col-md-4">
                  <label for="nombres">Nombres</label>
                  <input type="text" name="nombres" class="form-control @error('nombres') is-invalid @enderror" value="{{ old('nombres') }}" required>
                  @error('nombres') <span class="invalid-feedback">{{ $message }}</span> @enderror
              </div>
              <div class="form-group col-md-4">
                  <label for="paterno">Apellido Paterno</label>
                  <input type="text" name="paterno" class="form-control @error('paterno') is-invalid @enderror" value="{{ old('paterno') }}">
                  @error('paterno') <span class="invalid-feedback">{{ $message }}</span> @enderror
              </div>
              <div class="form-group col-md-4">
                  <label for="materno">Apellido Materno</label>
                  <input type="text" name="materno" class="form-control @error('materno') is-invalid @enderror" value="{{ old('materno') }}">
                  @error('materno') <span class="invalid-feedback">{{ $message }}</span> @enderror
              </div>
          </div>

          <div class="form-row">
              <div class="form-group col-md-4">
                  <label for="ci">Cédula de Identidad</label>
                  <input type="text" name="ci" class="form-control @error('ci') is-invalid @enderror" value="{{ old('ci') }}">
                  @error('ci') <span class="invalid-feedback">{{ $message }}</span> @enderror
              </div>
              <div class="form-group col-md-4">
                  <label for="ci_expedido">Expedido</label>
                  <input type="text" name="ci_expedido" class="form-control @error('ci_expedido') is-invalid @enderror" value="{{ old('ci_expedido') }}">
                  @error('ci_expedido') <span class="invalid-feedback">{{ $message }}</span> @enderror
              </div>
              <div class="form-group col-md-4">
                  <label for="celular">Celular</label>
                  <input type="text" name="celular" class="form-control @error('celular') is-invalid @enderror" value="{{ old('celular') }}">
                  @error('celular') <span class="invalid-feedback">{{ $message }}</span> @enderror
              </div>
          </div>

          <div class="form-row">
              <div class="form-group col-md-6">
                  <label for="email">Correo Electrónico</label>
                  <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                  @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
              </div>
              <div class="form-group col-md-6">
                  <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                  <input type="date" name="fecha_nacimiento" class="form-control @error('fecha_nacimiento') is-invalid @enderror" value="{{ old('fecha_nacimiento') }}">
                  @error('fecha_nacimiento') <span class="invalid-feedback">{{ $message }}</span> @enderror
              </div>
          </div>
        </div>

        <div class="modal-footer">
             <button type="submit" class="btn btn-info">
              <i class="fas fa-save"></i> Registrar
          </button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">
              <i class="fas fa-times"></i> Cancelar
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

@stop

