@extends('adminlte::page')

@section('title', 'Permisos')

@section('content_header')
<h1 class="text-dark" style="font-family: Georgia, serif; font-weight: 800;">
    Permisos
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
        <form method="GET" action="{{ route('permisos.index') }}" class="form-inline w-100">
            <div class="form-row align-items-center w-100">

                {{-- Selección de registros por página --}}
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

                {{-- Buscador --}}
                <div class="col-auto">
                    <input type="text" name="buscar" value="{{ request('buscar') }}" class="form-control form-control-sm"
                           placeholder="Buscar permiso...">
                </div>

                {{-- Botón buscar --}}
                <div class="col-auto">
                    <button type="submit" class="btn btn-info btn-sm">
                        <i class="fas fa-search"></i> Buscar
                    </button>
                </div>

                {{-- Botón Nuevo --}}
                <div class="col-auto ml-auto">
                    <button type="button" class="btn btn-sm"
                        data-toggle="modal" data-target="#modalNuevoPermiso"
                        style="background-color: #ffffff; color: #c21508ff; border: 1px solid #aa1906ff;">
                        <i class="fas fa-plus"></i> Nuevo
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
                    <th>Permiso</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                @forelse($permissions as $permission)
                <tr>
                    <td>{{ $loop->iteration + ($permissions->currentPage()-1)*$permissions->perPage() }}</td>
                    <td>{{ $permission->name }}</td>

                    <td class="text-center">

                        <a href="{{ route('permisos.edit', $permission->id) }}"
                           class="btn btn-danger btn-sm" title="Editar">
                            <i class="fas fa-edit"></i> Editar
                        </a>

                        <form action="{{ route('permisos.destroy', $permission->id) }}" method="POST"
                              style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-info btn-sm"
                                    onclick="return confirm('¿Eliminar permiso?')" title="Eliminar">
                                <i class="fas fa-trash-alt"></i> Eliminar
                            </button>
                        </form>

                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center text-muted">No hay permisos registrados.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Paginación --}}
        <div class="d-flex justify-content-between align-items-center mt-2">
            <div>
                Mostrando {{ $permissions->firstItem() ?? 0 }} - {{ $permissions->lastItem() ?? 0 }}
                de {{ $permissions->total() ?? 0 }} registros
            </div>

            <div>
                <ul class="pagination justify-content-center">
                    {{-- Botón Anterior --}}
                    @if ($permissions->onFirstPage())
                        <li class="page-item disabled">
                            <span class="page-link"><i class="fas fa-angle-left fa-lg"></i></span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $permissions->previousPageUrl() }}">
                                <i class="fas fa-angle-left fa-lg"></i>
                            </a>
                        </li>
                    @endif

                    @foreach ($permissions->getUrlRange(1, $permissions->lastPage()) as $page => $url)
                        <li class="page-item {{ $permissions->currentPage() == $page ? 'active' : '' }}">
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endforeach

                    {{-- Botón Siguiente --}}
                    @if ($permissions->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $permissions->nextPageUrl() }}">
                                <i class="fas fa-angle-right fa-lg"></i>
                            </a>
                        </li>
                    @else
                        <li class="page-item disabled">
                            <span class="page-link"><i class="fas fa-angle-right fa-lg"></i></span>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>

{{-- Modal Nuevo Permiso --}}
<div class="modal fade" id="modalNuevoPermiso" tabindex="-1" role="dialog" aria-labelledby="modalNuevoPermisoLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content border-0 shadow-lg">
      <div class="modal-header bg-info text-white">
        <h5 class="modal-title"><i class="fas fa-key"></i> Nuevo Permiso</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form action="{{ route('permisos.store') }}" method="POST">
        @csrf
        <div class="modal-body">

            <div class="form-group">
                <label for="name">Nombre del Permiso</label>
                <input type="text" name="name" id="name"
                       class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name') }}" required>
                @error('name')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
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

@stop
