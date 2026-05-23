@extends('adminlte::page')

@section('title', 'Reporte Anual de Pagos')

@section('content_header')
<h1 style="font-family: Georgia, serif; font-weight: 800;">
    Reporte Anual de Pagos
</h1>
@stop

@section('content')

<div class="card mb-3">
    <div class="card-body">

        <form action="{{ route('pagos.reporte.anual') }}" method="GET" class="form-inline">

            <label class="mr-2">Seleccionar Año:</label>

            <select name="year" class="form-control mr-2" onchange="this.form.submit()">
                @for($i = now()->year; $i >= 2020; $i--)
                    <option value="{{ $i }}" {{ $i == $year ? 'selected' : '' }}>
                        {{ $i }}
                    </option>
                @endfor
            </select>

            <label class="mr-2">Mostrar:</label>

            <select name="perPage" class="form-control mr-2" onchange="this.form.submit()">
                @foreach([5,10,15,25,50,100] as $cantidad)
                    <option value="{{ $cantidad }}" {{ $perPage == $cantidad ? 'selected' : '' }}>
                        {{ $cantidad }}
                    </option>
                @endforeach
            </select>

            <noscript>
                <button class="btn btn-primary">Filtrar</button>
            </noscript>

        </form>

    </div>
</div>

<div class="card shadow">

    <div class="card-header bg-info text-white">
        Pagos del año <strong>{{ $year }}</strong>
    </div>

    <div class="card-body table-responsive">

        <table class="table table-bordered table-hover text-center">

            <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Glosa</th>
                    <th>Total (Bs.)</th>
                    <th>Pagado (Bs.)</th>
                    <th>Pendiente (Bs.)</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                </tr>
            </thead>

            <tbody>

                @forelse($pagos as $pago)

                <tr>
                    <td>{{ $pago->id_pago }}</td>

                    <td>
                        {{ $pago->cliente->nombre_completo ?? 'Sin cliente' }}
                    </td>

                    <td class="text-left">
                        {{ $pago->glosa_pago }}
                    </td>

                    <td>{{ number_format($pago->monto_total,0) }}</td>
                    <td class="text-success">{{ number_format($pago->monto_pagado,0) }}</td>
                    <td class="text-danger">{{ number_format($pago->monto_pendiente,0) }}</td>

                    <td>
                        {{ $pago->fecha_pago ? \Carbon\Carbon::parse($pago->fecha_pago)->format('d/m/Y') : '-' }}
                    </td>

                    <td>
                        @if($pago->estado == 'Pagado')
                            <span class="badge bg-success">Pagado</span>
                        @else
                            <span class="badge bg-warning text-dark">Pendiente</span>
                        @endif
                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="8">No hay pagos en este año</td>
                </tr>

                @endforelse

            </tbody>

            <tfoot class="font-weight-bold bg-light">

                <tr>
                    <td colspan="3" class="text-right">
                        Totales:
                    </td>

                    <td></td>

                    <td class="text-success">
                        {{ number_format($totalPagado,0) }}
                    </td>

                    

                    <td colspan="2"></td>
                </tr>

            </tfoot>

        </table>

        <div class="d-flex justify-content-center mt-3">
            {{ $pagos->links() }}
        </div>

    </div>

</div>

<div class="mt-3 d-flex gap-2">

    <a href="{{ route('pagos.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Volver
    </a>

    <a href="{{ route('pagos.reporte.anual.pdf', ['year' => $year]) }}" class="btn btn-danger">
        <i class="fas fa-file-pdf"></i> Exportar PDF
    </a>

</div>

@stop