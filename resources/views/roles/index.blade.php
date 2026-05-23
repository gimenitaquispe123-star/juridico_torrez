@extends('adminlte::page')

@section('title', 'Roles')

@section('content_header')
<h1 class="text-dark" style="font-family: Georgia, serif; font-weight: 800;">
    Roles
</h1>
@stop

@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
@endif

<div class="card shadow-lg">

<div class="card-header d-flex justify-content-end align-items-center">
    
    <div class="d-flex align-items-center">
    {{-- Botón Nuevo Rol --}}
    <button type="button" class="btn btn-info btn-sm mr-2" data-toggle="modal" data-target="#modalNuevoRol">
        <i class="fas fa-plus"></i> Nuevo
    </button>

    {{-- Formulario de búsqueda --}}
    <form method="GET" action="{{ route('roles.index') }}" class="d-flex">
        <div class="input-group">
            <input type="text" name="buscar" class="form-control"
                   placeholder="Buscar rol..."
                   value="{{ request('buscar') }}">
            <div class="input-group-append">
                <button class="btn btn-info" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </form>
</div>

</div>

    <div class="card-body table-responsive">
        <table class="table table-bordered table-hover text-center">
            <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th>Nombre Rol</th>
                    <th>Fecha Registrado</th>
                    <th>Fecha Modificado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($roles as $rol)
                <tr>
                    <td>{{ $loop->iteration + ($roles->currentPage()-1)*$roles->perPage() }}</td>
                    <td>{{ $rol->name }}</td>
                    <td>{{ $rol->created_at->format('d/m/Y') }}</td>
                    <td>{{ $rol->updated_at ? $rol->updated_at->format('d/m/Y') : '-' }}</td>
                    <td>
                        <a href="{{ route('roles.edit', $rol->id) }}" class="btn btn-sm btn-primary mb-1">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        <a href="{{ route('roles.permissions', $rol->id) }}" class="btn btn-sm btn-info mb-1">
                            <i class="fas fa-key"></i> Asignar Permisos
                        </a>
                        <form action="{{ route('roles.destroy', $rol->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger mb-1" onclick="return confirm('¿Eliminar rol?')">
                                <i class="fas fa-trash-alt"></i> Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">No hay roles registrados.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- PAGINACIÓN -->
        <div class="d-flex justify-content-between align-items-center mt-2">
            <div>
                Mostrando {{ $roles->firstItem() ?? 0 }} - {{ $roles->lastItem() ?? 0 }}
                de {{ $roles->total() ?? 0 }} registros
            </div>
            <div>
                {{ $roles->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>

<!-- MODAL CREAR ROL -->
<div class="modal fade" id="modalNuevoRol" tabindex="-1" role="dialog" aria-labelledby="modalNuevoRolLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content shadow-lg">

      <div class="modal-header bg-info text-white">
        <h5 class="modal-title" id="modalNuevoRolLabel">
            <i class="fas fa-user-shield"></i> Crear Nuevo Rol
        </h5>
        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
      </div>

      <form action="{{ route('roles.store') }}" method="POST">
        @csrf
        <div class="modal-body">
            <div class="form-group">
                <label>Nombre del Rol</label>
                <input type="text" name="name" class="form-control" placeholder="Ej: Administrador" required>
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
