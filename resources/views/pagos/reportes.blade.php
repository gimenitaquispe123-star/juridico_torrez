@extends('adminlte::page')

@section('title', 'Reportes de Pagos')

@section('content_header')
<h1><i class="fas fa-chart-line text-primary"></i> Reportes de Pagos</h1>
@stop


@section('content')

<div class="card shadow">

    <div class="card-header bg-primary text-white">

        <form method="GET" class="form-inline">

            <label class="mr-2"><b>Tipo de reporte:</b></label>

            <select name="tipo" class="form-control mr-2">

                <option value="mensual" {{ $tipo == 'mensual' ? 'selected' : '' }}>
                    Mensual
                </option>

                <option value="anual" {{ $tipo == 'anual' ? 'selected' : '' }}>
                    Anual
                </option>

            </select>

            <button type="submit" class="btn btn-light">
                <i class="fas fa-sync"></i> Generar
            </button>

        </form>

    </div>


    <div class="card-body">

        <table class="table table-bordered table-hover">

            <thead class="bg-light">

                <tr>

                    <th class="text-center">
                        {{ $tipo == 'anual' ? 'Año' : 'Mes / Año' }}
                    </th>

                    <th class="text-center">Total Servicio (Bs)</th>

                    <th class="text-center text-success">Pagado (Bs)</th>

                    <th class="text-center text-danger">Pendiente (Bs)</th>

                </tr>

            </thead>

            <tbody>

                @php
                    $totalServicio = 0;
                    $totalPagado = 0;
                    $totalPendiente = 0;
                @endphp


                @forelse ($reportes as $r)

                <tr>

                    <td class="text-center">

                        @if($tipo == 'anual')

                            <b>{{ $r->periodo }}</b>

                        @else

                            {{ str_pad($r->mes, 2, '0', STR_PAD_LEFT) }}/{{ $r->anio }}

                        @endif

                    </td>

                    <td class="text-center">

                        {{ number_format($r->total, 2) }}

                    </td>

                    <td class="text-center text-success">

                        {{ number_format($r->pagado, 2) }}

                    </td>

                    <td class="text-center text-danger">

                        {{ number_format($r->pendiente, 2) }}

                    </td>

                </tr>

                @php
                    $totalServicio += $r->total;
                    $totalPagado += $r->pagado;
                    $totalPendiente += $r->pendiente;
                @endphp

                @empty

                <tr>
                    <td colspan="4" class="text-center">
                        No existen registros para este reporte
                    </td>
                </tr>

                @endforelse

            </tbody>


            <tfoot class="bg-light">

                <tr>

                    <th class="text-center">TOTALES</th>

                    <th class="text-center">
                        {{ number_format($totalServicio,2) }}
                    </th>

                    <th class="text-center text-success">
                        {{ number_format($totalPagado,2) }}
                    </th>

                    <th class="text-center text-danger">
                        {{ number_format($totalPendiente,2) }}
                    </th>

                </tr>

            </tfoot>

        </table>

    </div>

</div>

@stop