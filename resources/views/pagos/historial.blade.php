@extends('adminlte::page')

@section('title', 'Historial de Pagos')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 style="font-family: Georgia, serif; font-weight: 800;">
        Historial de Pagos
    </h1>

    <a href="{{ route('pagos.index') }}" class="btn btn-danger">
        <i class="fas fa-arrow-left"></i> Volver
    </a>
</div>
@stop

@section('content')

<div class="card shadow-lg border-0">

    <div class="card-header bg- text-black">
        <h5 class="mb-0">
            <i class="fas fa-user"></i>
            Cliente: {{ $pagos->first()->cliente->nombre_completo ?? '' }}
        </h5>
    </div>

    <div class="card-body">

       
        <div class="row text-center mb-4">

            <div class="col-md-4">
                <div class="p-3 bg-light rounded shadow-sm">
                    <h6>Monto Total</h6>
                    <h4 class="text-dark">
                        Bs {{ number_format($montoTotal,2) }}
                    </h4>
                </div>
            </div>

            <div class="col-md-4">
                <div class="p-3 bg-light text-black rounded shadow-sm">
                    <h6>Total Pagado</h6>
                    <h4>
                        Bs {{ number_format($totalPagado,2) }}
                    </h4>
                </div>
            </div>

            <div class="col-md-4">
                <div class="p-3 bg-light text-black rounded shadow-sm">
                    <h6>Pendiente</h6>
                    <h4>
                        Bs {{ number_format($pendiente,2) }}
                    </h4>
                </div>
            </div>

        </div>

        {{-- TABLA --}}
        <div class="table-responsive">

            <table class="table table-hover table-bordered text-center">

              <thead class="thead-light">
                    <tr>
                        <th>ID</th>
                        <th>Monto Pagado</th>
                        <th>Fecha</th>
                        <th>Glosa</th>
                        <th>Estado</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($pagos as $pago)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <strong>Bs {{ number_format($pago->monto_pagado,2) }}</strong>
                            </td>
                            <td>
                                {{ $pago->fecha_pago ? \Carbon\Carbon::parse($pago->fecha_pago)->format('d/m/Y') : '-' }}
                            </td>
                            <td>{{ $pago->glosa_pago ?? '-' }}</td>
                            <td>
                                <span class="badge badge-{{ $pago->estado == 'Pagado' ? 'success' : 'warning' }}">
                                    {{ $pago->estado }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-muted">
                                No hay pagos registrados
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>

        </div>

    </div>
</div>

@stop