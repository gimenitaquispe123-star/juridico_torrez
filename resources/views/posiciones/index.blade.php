@extends('adminlte::page')

@section('title', 'Posiciones')

@section('content_header')
<h1 class="text-dark" style="font-family: Georgia, serif; font-weight: 800;">
    Posiciones
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
        <form method="GET" action="{{ route('posiciones.index') }}" class="form-inline w-100">
            <div class="form-row align-items-center w-100">
                
                <div class="col-auto">
                    <select name="per_page" class="form-control form-control-sm" onchange="this.form.submit()">
                        <option disabled>Mostrar</option>
                        @foreach([5,10,15,25,50,100] as $cantidad)
                            <option value="{{ $cantidad }}" {{ request('per_page') == $cantidad ? 'selected' : '' }}>{{ $cantidad }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-auto">
                    <input type="text" name="buscar" value="{{ request('buscar') }}" class="form-control form-control-sm" placeholder="Buscar posición...">
                </div>

                <div class="col-auto">
                    <button type="submit" class="btn btn-info btn-sm">
                        <i class="fas fa-search"></i> Buscar
                    </button>
                </div>
                <div class="col-auto ml-auto">
                
                    <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#modalNuevaPosicion" 
                        style="background-color: #ffffff; color: #007bff; border: 1px solid #007bff;">
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
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($posiciones as $posicion)
                <tr>
                    <td>{{ $loop->iteration + ($posiciones->currentPage()-1)*$posiciones->perPage() }}</td>
                    <td>{{ $posicion->nombre }}</td>
                    <td>{{ $posicion->descripcion ?? '-' }}</td>
                    <td>
                        @if($posicion->estado)
                            <span class="badge badge-">Activo</span>
                        @else
                            <span class="badge badge-danger">Inactivo</span>
                        @endif
                    </td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                    id="accionesDropdown{{ $posicion->id }}"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Acciones
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="accionesDropdown{{ $posicion->id }}">
                       
                                <button type="button" class="dropdown-item text-primary" data-toggle="modal" data-target="#modalEditarPosicion{{ $posicion->id }}">
                                    <i class="fas fa-edit"></i> Editar
                                </button>
                            
                                <form action="{{ route('posiciones.destroy', $posicion->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="dropdown-item text-danger" onclick="return confirm('¿Eliminar posición?')">
                                        <i class="fas fa-trash-alt"></i> Eliminar
                                    </button>
                                </form>
                            
                            </div>
                        </div>
                    </td>
                </tr>

                <div class="modal fade" id="modalEditarPosicion{{ $posicion->id }}" tabindex="-1" role="dialog" aria-labelledby="modalEditarPosicionLabel{{ $posicion->id }}" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content border-0 shadow-lg">
                      <div class="modal-header bg-info text-white">
                        <h5 class="modal-title" id="modalEditarPosicionLabel{{ $posicion->id }}"><i class="fas fa-edit"></i> Editar Posición</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <form action="{{ route('posiciones.update', $posicion->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="nombre{{ $posicion->id }}">Nombre</label>
                                <input type="text" name="nombre" id="nombre{{ $posicion->id }}" class="form-control" value="{{ $posicion->nombre }}" required>
                            </div>

                            <div class="form-group">
                                <label for="descripcion{{ $posicion->id }}">Descripción</label>
                                <textarea name="descripcion" id="descripcion{{ $posicion->id }}" class="form-control">{{ $posicion->descripcion }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="estado{{ $posicion->id }}">Estado</label>
                                <select name="estado" id="estado{{ $posicion->id }}" class="form-control">
                                   <option value="" {{ $posicion->estado === null ? 'selected' : '' }}>Seleccione</option>
                                    <option value="1" {{ $posicion->estado ? 'selected' : '' }}>Activo</option>
                                    <option value="0" {{ !$posicion->estado ? 'selected' : '' }}>Inactivo</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">
                              <i class="fas fa-times"></i> Cancelar
                          </button>
                          <button type="submit" class="btn btn-primary">
                              <i class="fas fa-save"></i> Actualizar
                          </button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>

                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">No hay posiciones registradas.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="d-flex justify-content-between align-items-center mt-2">
            <div>
                Mostrando {{ $posiciones->firstItem() ?? 0 }} - {{ $posiciones->lastItem() ?? 0 }}
                de {{ $posiciones->total() ?? 0 }} registros
            </div>
            <div>
          {{ $posiciones->appends(request()->query())->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalNuevaPosicion" tabindex="-1" role="dialog" aria-labelledby="modalNuevaPosicionLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content border-0 shadow-lg">
      <div class="modal-header bg-info text-white">
        <h5 class="modal-title" id="modalNuevaPosicionLabel"><i class="fas fa-plus"></i> Nueva Posición</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('posiciones.store') }}" method="POST">
        @csrf
        <div class="modal-body">
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre') }}" required>
                @error('nombre')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea name="descripcion" id="descripcion" class="form-control">{{ old('descripcion') }}</textarea>
            </div>

            <div class="form-group">
    <label for="estado">Estado</label>
    <select name="estado" id="estado" class="form-control">
        <option value="">Seleccione</option>
        <option value="1" {{ old('estado', 1) == 1 ? 'selected' : '' }}>Activo</option>
        <option value="0" {{ old('estado') == 0 ? 'selected' : '' }}>Inactivo</option>
    </select>
</div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">
              <i class="fas fa-times"></i> Cancelar
          </button>
          <button type="submit" class="btn btn-info">
              <i class="fas fa-save"></i> Guardar
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@stop
