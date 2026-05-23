@php
use App\Models\Expediente;
use App\Models\Persona;
use App\Models\AbogadoExpediente;

$expedientes = $expedientes ?? Expediente::all();
$empleados = $empleados ?? Persona::all();
$abogados = $abogados ?? AbogadoExpediente::with(['expediente', 'empleado'])->get();
@endphp

<div class="card shadow-lg">

    <div class="card-header bg-white">

    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table id="tablaAbogados"
                class="table table-bordered table-striped table-hover align-middle text-center">

                <thead class="bg-light">

                    <tr>

                        <th>ID</th>
                        <th>Expediente</th>
                        <th>Abogado Asignado</th>
                        <th>Fecha Asignación</th>
                        <th>Fecha Desvinculación</th>
                        <th>Estado</th>
                        <th width="120">Acciones</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach ($abogados as $index => $abogado)

                        <tr>

                            <td>
                                {{ $index + 1 }}
                            </td>

                            <td>
                                {{ $abogado->expediente->codigo_expediente ?? 'N/A' }}
                            </td>

                            <td>
                                {{ trim("{$abogado->empleado->nombres} {$abogado->empleado->paterno} {$abogado->empleado->materno}") }}
                            </td>

                            <td>

                                {{ $abogado->fecha_asignacion
                                    ? \Carbon\Carbon::parse($abogado->fecha_asignacion)->format('d/m/Y')
                                    : '-' }}

                            </td>

                            <td>

                                {{ $abogado->fecha_desvinculacion &&
                                $abogado->fecha_desvinculacion != '0000-00-00'
                                    ? \Carbon\Carbon::parse($abogado->fecha_desvinculacion)->format('d/m/Y')
                                    : '-' }}

                            </td>

                            <td>

                                @if ($abogado->estado)

                                    <span class="badge border text-dark">
                                        Activo
                                    </span>

                                @else

                                    <span class="badge border text-dark">
                                        Inactivo
                                    </span>

                                @endif

                            </td>

                            <td>

                                <div class="dropdown">

                                    <button class="btn btn-info btn-sm dropdown-toggle"
                                        type="button"
                                        id="dropdownMenuButton{{ $abogado->id }}"
                                        data-bs-toggle="dropdown"
                                        aria-expanded="false">

                                        Opciones

                                    </button>

                                    <ul class="dropdown-menu">

                                        <li>

                                            <a class="dropdown-item"
                                                href="{{ route('abogado_expediente.show', $abogado->id) }}">

                                                <i class="fas fa-eye text-primary"></i> Ver

                                            </a>

                                        </li>

                                        @hasanyrole('administrador|secretaria')

                                            <li>

                                                <a class="dropdown-item"
                                                    href="{{ route('abogado_expediente.edit', $abogado->id) }}">

                                                    <i class="fas fa-edit text-warning"></i> Editar

                                                </a>

                                            </li>

                                            <li>

                                                <form action="{{ route('abogado_expediente.destroy', $abogado->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('¿Desea eliminar este registro?');">

                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit"
                                                        class="dropdown-item text-danger">

                                                        <i class="fas fa-trash-alt"></i> Eliminar

                                                    </button>

                                                </form>

                                            </li>

                                        @endhasanyrole

                                    </ul>

                                </div>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

        {{-- MENSAJE SI NO HAY DATOS --}}
        @if($abogados->isEmpty())

            <div class="alert alert-secondary text-center mt-3">

                No hay abogados asignados.

            </div>

        @endif

    </div>

</div>

@section('js')

    {{-- JQuery --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    {{-- DataTables --}}
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    {{-- Responsive --}}
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

    <script>

        $(document).ready(function () {

            if ($.fn.DataTable.isDataTable('#tablaAbogados')) {

                $('#tablaAbogados').DataTable().destroy();

            }

            $('#tablaAbogados').DataTable({

                language: {

                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'

                },

                pageLength: 5,

                lengthMenu: [
                    [5, 10, 25, 50, 100],
                    [5, 10, 25, 50, 100]
                ],

                responsive: true,

                ordering: true,

                searching: true,

                paging: true,

                info: true,

                autoWidth: false,

                order: [[0, 'asc']],

                columnDefs: [
                    {
                        targets: '_all',
                        defaultContent: '-'
                    }
                ]

            });

        });

    </script>

@stop


{{-- ESTILOS --}}
@section('css')

    {{-- DataTables --}}
    <link rel="stylesheet"
        href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    {{-- Responsive --}}
    <link rel="stylesheet"
        href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

    <style>

        .select2{
            width:100% !important;
        }

        table,
        th,
        td{
            font-family: Georgia, serif;
        }

        .dataTables_length label,
        .dataTables_filter label{
            font-weight: bold;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button{
            padding: 2px 10px;
        }

        .table thead th{
            vertical-align: middle;
        }

        .dropdown-menu{
            min-width: 140px;
        }

        .badge{
            font-size: 0.85rem;
            padding: 6px 10px;
        }

    </style>

@stop