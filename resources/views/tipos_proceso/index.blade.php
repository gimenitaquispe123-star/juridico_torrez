@extends('adminlte::page')

@section('title', 'Tipos de Proceso')

@section('content_header')
<h1 class="text-dark" style="font-family: Georgia, serif; font-weight: 800;">
    Tipos de Proceso
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
        <form method="GET" action="{{ route('tipos_proceso.index') }}" class="form-inline w-100">
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
                    <input 
                        type="text" 
                        name="buscar" 
                        value="{{ request('buscar') }}" 
                        class="form-control form-control-sm" 
                        placeholder="Buscar tipo de proceso..."
                    >
                </div>

                <div class="col-auto">
                    <button type="submit" class="btn btn-info btn-sm">
                        <i class="fas fa-search"></i> Buscar
                    </button>
                </div>

                <div class="col-auto ml-auto d-flex">
               
                    <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#modalCrearTipoProceso"
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
                    <th>Tipo de Proceso</th>
                    <th>Descripción</th>
                    <th>Registrado</th>
                    <th>Modificado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tipos as $tipo)
                <tr>
                    <td>{{ $loop->iteration + ($tipos->currentPage()-1)*$tipos->perPage() }}</td>
                    <td>{{ $tipo->tipo_proceso }}</td>
                    <td>{{ $tipo->descripcion }}</td>
                    <td>{{ $tipo->registrado }}</td>
                    <td>{{ $tipo->modificado ?? '-' }}</td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                    id="accionesDropdown{{ $tipo->id }}"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Acciones
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="accionesDropdown{{ $tipo->id }}">
                             <a class="dropdown-item" href="{{ route('tipos_proceso.show', $tipo) }}">
                                <i class="fas fa-eye text-info"></i> Detalles
                            </a>
                        
                            <a class="dropdown-item" href="{{ route('tipos_proceso.edit', $tipo) }}">
                                <i class="fas fa-edit text-warning"></i> Editar
                            </a>
                        

                                <form action="{{ route('tipos_proceso.destroy', $tipo->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="dropdown-item text-danger" onclick="return confirm('¿Eliminar tipo de proceso?')">
                                        <i class="fas fa-trash-alt"></i> Eliminar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">No hay tipos de proceso registrados.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="d-flex justify-content-between align-items-center mt-2">
            <div>
                Mostrando {{ $tipos->firstItem() ?? 0 }} - {{ $tipos->lastItem() ?? 0 }}
                de {{ $tipos->total() ?? 0 }} registros
            </div>
            <div>
                {{ $tipos->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modalCrearTipoProceso" tabindex="-1" role="dialog" aria-labelledby="modalCrearTipoProcesoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ route('tipos_proceso.store') }}" method="POST" autocomplete="off">
                @csrf
                <div class="modal-header bg-light">
                    <h5 class="modal-title text-dark" id="modalCrearTipoProcesoLabel" style="font-family: Georgia, serif;">
                        <i class="fas fa-file-alt text-primary"></i> Registrar Nuevo Tipo de Proceso
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="tipo_proceso" class="font-weight-bold">Tipo de Proceso <span class="text-danger"></span></label>
                            <input type="text" name="tipo_proceso" id="tipo_proceso" class="form-control" required>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="descripcion" class="font-weight-bold">Descripción</label>
                            <input type="text" name="descripcion" id="descripcion" class="form-control" placeholder="Descripción breve del tipo de proceso">
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
