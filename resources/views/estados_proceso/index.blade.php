@extends('adminlte::page')

@section('title', 'Estados de Proceso')

@section('content_header')
<h1 class="text-dark" style="font-family: Georgia, serif; font-weight: 800;">
    Estados de Proceso
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

@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>¡Error!</strong> Corrige los siguientes campos antes de continuar:
    <ul class="mb-0 mt-2">
        @foreach ($errors->all() as $error)
        <li>• {{ $error }}</li>
        @endforeach
    </ul>
    <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<div class="card shadow-lg">
    <div class="card-header d-flex flex-wrap justify-content-between align-items-center">
        <form method="GET" action="{{ route('estados_proceso.index') }}" class="form-inline w-100">
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
                    <input type="text" name="buscar" value="{{ request('buscar') }}" class="form-control form-control-sm" placeholder="Buscar estado de proceso...">
                </div>

                <div class="col-auto">
                    <button type="submit" class="btn btn-info btn-sm">
                        <i class="fas fa-search"></i> Buscar
                    </button>
                </div>

                <div class="col-auto ml-auto d-flex">
                    <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#modalCrearEstado"
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
                    <th>Estado de Proceso</th>
                    <th>Descripcion</th>
                    <th>Registrado</th>
                    <th>Modificado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($estados as $estado)
                <tr>
                    <td>{{ $loop->iteration + ($estados->currentPage()-1)*$estados->perPage() }}</td>
                    <td>{{ $estado->estado_proceso }}</td>
                    <td>{{ $estado->descripcion }}</td>
                    <td>{{ $estado->registrado }}</td>
                    <td>{{ $estado->modificado ?? '-' }}</td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                    id="accionesDropdown{{ $estado->id }}"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Acciones
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="accionesDropdown{{ $estado->id }}">
                                <a class="dropdown-item" href="{{ route('estados_proceso.show', $estado) }}">
                                    <i class="fas fa-eye text-info"></i> Ver
                                </a>
                             
                                <button type="button" class="dropdown-item" data-toggle="modal" data-target="#modalEditarEstado{{ $estado->id }}">
                                    <i class="fas fa-edit text-warning"></i> Editar
                                </button>

                                <form action="{{ route('estados_proceso.destroy', $estado->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="dropdown-item text-danger" onclick="return confirm('¿Eliminar estado de proceso?')">
                                        <i class="fas fa-trash-alt"></i> Eliminar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </td>
                </tr>

                <!-- Modal Editar -->
                <div class="modal fade" id="modalEditarEstado{{ $estado->id }}" tabindex="-1" role="dialog" aria-labelledby="modalEditarEstadoLabel{{ $estado->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <form action="{{ route('estados_proceso.update', $estado->id) }}" method="POST" autocomplete="off">
                                @csrf
                                @method('PUT')
                                <div class="modal-header bg-light">
                                    <h5 class="modal-title text-dark" id="modalEditarEstadoLabel{{ $estado->id }}" style="font-family: Georgia, serif;">
                                        <i class="fas fa-edit text-warning"></i> Editar Estado de Proceso
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <div class="modal-body">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="estado_proceso_{{ $estado->id }}" class="font-weight-bold">Estado de Proceso</label>
                                            <input type="text" name="estado_proceso" id="estado_proceso_{{ $estado->id }}" class="form-control" value="{{ old('estado_proceso', $estado->estado_proceso) }}" required>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="descripcion_{{ $estado->id }}" class="font-weight-bold">Descripción</label>
                                            <input type="text" name="descripcion" id="descripcion_{{ $estado->id }}" class="form-control" value="{{ old('descripcion', $estado->descripcion) }}">
                                        </div>
                                    </div>

                                    <div class="alert alert-info p-2">
                                        <i class="fas fa-info-circle"></i> El campo <strong>Modificado</strong> se llenará automáticamente.
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">
                                        <i class="fas fa-times"></i> Cancelar
                                    </button>
                                    <button type="submit" class="btn btn-warning btn-sm">
                                        <i class="fas fa-save"></i> Actualizar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">No hay estados de proceso registrados.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="d-flex justify-content-between align-items-center mt-2">
            <div>
                Mostrando {{ $estados->firstItem() ?? 0 }} - {{ $estados->lastItem() ?? 0 }}
                de {{ $estados->total() ?? 0 }} registros
            </div>
            <div>
                {{ $estados->appends(request()->query())->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modalCrearEstado" tabindex="-1" role="dialog" aria-labelledby="modalCrearEstadoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ route('estados_proceso.store') }}" method="POST" autocomplete="off">
                @csrf
                <div class="modal-header bg-light">
                    <h5 class="modal-title text-dark" id="modalCrearEstadoLabel" style="font-family: Georgia, serif;">
                        <i class="fas fa-file-alt text-primary"></i> Registrar Nuevo Estado de Proceso
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="estado_proceso" class="font-weight-bold">Estado de Proceso</label>
                            <input type="text" name="estado_proceso" id="estado_proceso" class="form-control" required>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="descripcion" class="font-weight-bold">Descripción</label>
                            <input type="text" name="descripcion" id="descripcion" class="form-control" placeholder="Descripción breve">
                        </div>
                    </div>

                    <div class="alert alert-info p-2">
                        <i class="fas fa-info-circle"></i> Los campos <strong>Registrado</strong> y <strong>Modificado</strong> se llenan automáticamente.
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-success btn-sm">
                        <i class="fas fa-save"></i> Registrar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@stop
