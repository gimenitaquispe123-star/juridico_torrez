@extends('adminlte::page')

@section('title', 'Reporte Mensual de Pagos')

@section('content_header')
<h1 style="font-family: Georgia, serif; font-weight: 800;">
    Reporte Mensual de Pagos
</h1>
@stop

@section('content')

<div class="card mb-3">
    <div class="card-body">

        <form action="{{ route('pagos.reporte.mensual') }}" method="GET" class="form-inline">
            
            <label for="year" class="mr-2">Seleccionar Año:</label>
            <select name="year" id="year" class="form-control mr-2" onchange="this.form.submit()">
                @for($i = now()->year; $i >= 2020; $i--)
                    <option value="{{ $i }}" {{ $i == $year ? 'selected' : '' }}>{{ $i }}</option>
                @endfor
            </select>
            <label for="month" class="mr-2">Mes:</label>
            <select name="month" id="month" class="form-control mr-2" onchange="this.form.submit()">
                @foreach([
                    1=>'Enero',2=>'Febrero',3=>'Marzo',4=>'Abril',5=>'Mayo',6=>'Junio',
                    7=>'Julio',8=>'Agosto',9=>'Septiembre',10=>'Octubre',11=>'Noviembre',12=>'Diciembre'
                ] as $num => $nombre)
                    <option value="{{ $num }}" {{ $month == $num ? 'selected' : '' }}>{{ $nombre }}</option>
                @endforeach
            </select>
            <label for="perPage" class="mr-2">Mostrar:</label>
            <select name="perPage" id="perPage" class="form-control mr-2" onchange="this.form.submit()">
                @foreach([5,10,15,25,50,100] as $cantidad)
                    <option value="{{ $cantidad }}" {{ $perPage == $cantidad ? 'selected' : '' }}>{{ $cantidad }}</option>
                @endforeach
            </select>

            <noscript>
                <button type="submit" class="btn btn-primary">Filtrar</button>
            </noscript>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header bg-info text-white">
        Pagos del {{ $month }}/{{ $year }}
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
                    <th>Fecha Pago</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pagos as $pago)
                <tr>
                    <td>{{ $pago->id_pago }}</td>
                    <td>{{ $pago->cliente->nombre_completo }}</td>
                    <td>{{ $pago->glosa_pago }}</td>
                    <td>{{ number_format($pago->monto_total,0) }}</td>
                    <td>{{ number_format($pago->monto_pagado,0) }}</td>
                    <td>{{ number_format($pago->monto_pendiente,0) }}</td>
                    <td>{{ $pago->fecha_pago ? $pago->fecha_pago->format('d/m/Y') : '-' }}</td>
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
                    <td colspan="8" class="text-center">No hay pagos registrados en este mes.</td>
                </tr>
                @endforelse
            </tbody>

            <tfoot class="font-weight-bold bg-light">
                <tr>
                    <td colspan="3" class="text-right">Totales:</td>
                    <td></td>
                    <td>{{ number_format($totalPagado,0) }}</td>
                    <td colspan="2"></td>
                </tr>
            </tfoot>
        </table>

     
        <div class="d-flex justify-content-center mt-2">
            {{ $pagos->links() }}
        </div>
    </div>
</div>

        <div class="mb-3">
            <a href="{{ route('pagos.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
            <a href="{{ route('pagos.reporte.mensual.pdf', ['year'=>$year,'month'=>$month]) }}" class="btn btn-danger mb-2">
    <i class="fas fa-file-pdf"></i> Exportar PDF
</a>

        </div>

@stop
