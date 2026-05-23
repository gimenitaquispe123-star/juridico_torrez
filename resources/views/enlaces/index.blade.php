@extends('adminlte::page')

@section('title', 'Enlaces Jurídicos')

@section('content_header')
<h1 class="text-dark" style="font-family: Georgia, serif; font-weight: 800;">
    Enlaces Jurídicos
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
        <form method="GET" action="{{ route('enlaces.index') }}" class="form-inline w-100">
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
                    <input type="text" name="buscar" value="{{ request('buscar') }}" class="form-control form-control-sm" placeholder="Buscar enlace...">
                </div>

                <div class="col-auto">
                    <button type="submit" class="btn btn-info btn-sm">
                        <i class="fas fa-search"></i> Buscar
                    </button>
                </div>

                <div class="col-auto ml-auto d-flex">
                    <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#modalCrearEnlace"
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
                    <th>Nombre</th>
                    <th>Enlace</th>
                    <th>Descripción</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($enlaces as $enlace)
                <tr>
                    <td>{{ $loop->iteration + ($enlaces->currentPage()-1)*$enlaces->perPage() }}</td>
                    <td>{{ $enlace->nombre }}</td>
                    <td>
                        <a href="{{ $enlace->enlace }}" target="_blank">{{ $enlace->enlace }}</a>
                    </td>
                    <td>{{ $enlace->descripcion }}</td>
                    <td>
                        @if($enlace->estado == 'activo')
                            <span class="badge badge-success">Activo</span>
                        @else
                            <span class="badge badge-danger">Inactivo</span>
                        @endif
                    </td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                    id="accionesDropdown{{ $enlace->id }}"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Acciones
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="accionesDropdown{{ $enlace->id }}">
                                
                            <a  class="dropdown-item" href="{{ $enlace->enlace }}" target="_blank" class="btn btn-sm btn-info">
                                <i class="fas fa-external-link-alt"></i> Abrir
                            </a>

                            <a class="dropdown-item" href="{{ route('enlaces.show', $enlace->id) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-eye"></i> Detalles
                            </a>
                            <a class="dropdown-item" href="{{ route('enlaces.edit', $enlace->id) }}">
                                    <i class="fas fa-edit text-warning"></i> Editar
                                </a>
                             
                                <form action="{{ route('enlaces.destroy', $enlace->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="dropdown-item text-danger" onclick="return confirm('¿Eliminar enlace?')">
                                        <i class="fas fa-trash-alt"></i> Eliminar
                                    </button>
                                </form>
                            
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted">No hay enlaces registrados.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="d-flex justify-content-between align-items-center mt-2">
            <div>
                Mostrando {{ $enlaces->firstItem() ?? 0 }} - {{ $enlaces->lastItem() ?? 0 }}
                de {{ $enlaces->total() ?? 0 }} registros
            </div>
            <div>
                {{ $enlaces->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalCrearEnlace" tabindex="-1" role="dialog" aria-labelledby="modalCrearEnlaceLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ route('enlaces.store') }}" method="POST" autocomplete="off">
                @csrf
                <div class="modal-header bg-light">
                    <h5 class="modal-title text-dark" id="modalCrearEnlaceLabel" style="font-family: Georgia, serif;">
                        <i class="fas fa-link text-danger"></i> Registrar Nuevo Enlace Jurídico
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="nombre" class="font-weight-bold">Nombre del Enlace</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" required>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="enlace" class="font-weight-bold">URL</label>
                            <input type="url" name="enlace" id="enlace" class="form-control" placeholder="https://example.com" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="descripcion" class="font-weight-bold">Descripción</label>
                            <input type="text" name="descripcion" id="descripcion" class="form-control" placeholder="Descripción breve del enlace">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="estado" class="font-weight-bold">Estado</label>
                            <select name="estado" id="estado" class="form-control" required>
                                <option value="activo">Activo</option>
                                <option value="inactivo">Inactivo</option>
                            </select>
                        </div>
                    </div>

                    <div class="alert alert-info p-2">
                        <i class="fas fa-info-circle"></i> Los campos <strong>Registrado por</strong> y <strong>Modificado por</strong> se llenan automáticamente.
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
