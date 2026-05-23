@extends('adminlte::page')

@section('title', 'Tipos de Plantilla - Listado')

@section('content_header')
    <h1 class="text-dark" style="font-family: 'Merriweather', serif; font-weight: 800;">
        <i class="fas fa-file-alt text-black"></i> Tipos de Plantilla 
        <small style="font-weight: 400;">Listado</small>
    </h1>
@stop

@section('content')
<div class="card shadow-lg">

    <div class="card-header d-flex align-items-center gap-2">

    <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#crearTipoModal">
        <i class="fas fa-plus-circle"></i> Nuevo 
    </button>

    <a href="{{ route('plantillas.index') }}" class="btn btn-info btn-sm">
        Ir a Plantillas
    </a>

</div>

    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-6 d-flex align-items-center">
                <label class="mr-2 mb-0 font-weight-bold text-secondary">Mostrar</label>
                <select id="pageLength" class="custom-select custom-select-sm w-auto">
                    <option value="5">5</option>
                    <option value="10" selected>10</option>
                    <option value="15">15</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                <label class="ml-2 mb-0 font-weight-bold text-secondary">entradas</label>
            </div>
            <div class="col-md-6 text-right">
                <label class="mr-2 mb-0 font-weight-bold text-secondary">Buscar:</label>
                <input type="text" id="tableSearch" class="form-control form-control-sm d-inline-block w-auto" placeholder="Buscar tipo de plantilla...">
            </div>
        </div>

        <div class="table-responsive">
            <table id="tablaTipos" class="table table-bordered table-striped table-hover text-center align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Tipo de Plantilla</th>
                        <th>Descripción</th>
                        <th>Estado</th>
                        <th>Registrado</th>
                        <th>Modificado</th>
                        <th style="width: 200px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tipos as $tipo)
                        <tr>
                            <td>{{ $tipo->id }}</td>
                            <td>{{ $tipo->tipo_plantilla }}</td>
                            <td>{{ $tipo->descripcion }}</td>
                            <td>
                                @if($tipo->estado)
                                    <span class="badge bg-success">Activo</span>
                                @else
                                    <span class="badge bg-danger">Inactivo</span>
                                @endif
                            </td>
                            <td>{{ $tipo->registrado ? $tipo->registrado->format('d/m/Y H:i') : '---' }}</td>
                            <td>{{ $tipo->modificado ? $tipo->modificado->format('d/m/Y H:i') : '---' }}</td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown">
                                        Acciones
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#editarTipoModal{{ $tipo->id }}">
                                            <i class="fas fa-edit text-primary"></i> Editar
                                        </a>
                                        <form class="dropdown-item" action="{{ route('tipo_plantilla.destroy', $tipo->id) }}" method="POST" onsubmit="return confirm('¿Eliminar tipo de plantilla?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="fas fa-trash-alt"></i> Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        {{-- 🔹 Modal de edición --}}
                        <div class="modal fade" id="editarTipoModal{{ $tipo->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('tipo_plantilla.update', $tipo->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title">Editar Tipo de Plantilla</h5>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label>Tipo de Plantilla</label>
                                                <input type="text" name="tipo_plantilla" class="form-control" value="{{ $tipo->tipo_plantilla }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Descripción</label>
                                                <textarea name="descripcion" class="form-control">{{ $tipo->descripcion }}</textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Estado</label>
                                                <select name="estado" class="form-control">
                                                    <option value="1" {{ $tipo->estado ? 'selected' : '' }}>Activo</option>
                                                    <option value="0" {{ !$tipo->estado ? 'selected' : '' }}>Inactivo</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-primary">Actualizar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- 🔹 Modal de creación --}}
<div class="modal fade" id="crearTipoModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('tipo_plantilla.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Nuevo Tipo de Plantilla</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Tipo de Plantilla</label>
                        <input type="text" name="tipo_plantilla" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Descripción</label>
                        <textarea name="descripcion" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Estado</label>
                        <select name="estado" class="form-control">
                            <option value="1" selected>Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

@stop

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <style>
        .btn-orange {
            background-color: #080808ff;
            color: #fff;
            font-weight: 600;
        }
        .btn-orange:hover {
            background-color: #080808ff;
            color: #fff;
        }
        .table th, .table td {
            vertical-align: middle !important;
        }
        #tablaTipos_filter,
        #tablaTipos_length {
            display: none !important; 
        }
    </style>
@stop

@section('js')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(function () {
            var table = $('#tablaTipos').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',
                    paginate: { previous: "Anterior", next: "Siguiente" },
                    info: "Mostrando _START_ a _END_ de _TOTAL_ tipos de plantilla",
                    zeroRecords: "No se encontraron resultados",
                    infoEmpty: "No hay tipos de plantilla registrados"
                },
                order: [[0, 'desc']],
                responsive: true,
                pageLength: 10
            });

            $('#pageLength').on('change', function () {
                table.page.len($(this).val()).draw();
            });

            $('#tableSearch').on('keyup', function () {
                table.search(this.value).draw();
            });
        });
    </script>
@stop
