@extends('adminlte::page')

@section('title', 'Detalle de Tarifa')

@section('content_header')
<h1 class="text-dark fw-bold" style="font-family: 'Merriweather', serif;">
    <i class="fas fa-coins text-info"></i> Detalle de Tarifa
</h1>
@stop

@section('content')
<div class="card shadow-lg border-0">
    <div class="card-body">

        <table class="table table-bordered table-striped">
            <tr>
                <th>ID</th>
                <td>{{ $tarifa->id_tarifa }}</td>
            </tr>
            <tr>
                <th>Tipo de Proceso</th>
                <td>{{ $tarifa->tipoProceso->tipo_proceso ?? '-' }}</td>
            </tr>
            <tr>
                <th>Categoría</th>
                <td>{{ $tarifa->categoria ?? '-' }}</td>
            </tr>
            <tr>
                <th>Monto Mínimo</th>
                <td>{{ number_format($tarifa->monto_min, 2) }}</td>
            </tr>
            <tr>
                <th>Monto Máximo</th>
                <td>{{ number_format($tarifa->monto_max, 2) }}</td>
            </tr>
            <tr>
                <th>Moneda</th>
                <td>{{ $tarifa->moneda }}</td>
            </tr>
            <tr>
                <th>Registrado por</th>
                <td>{{ $tarifa->usuarioRegistro->name ?? '-' }}</td>
            </tr>
            <tr>
                <th>Fecha de registro</th>
                <td>{{ $tarifa->created_at->format('d/m/Y H:i') }}</td>
            </tr>
            <tr>
                <th>Modificado por</th>
                <td>{{ $tarifa->usuarioModificacion->name ?? '-' }}</td>
            </tr>
            <tr>
                <th>Fecha de modificación</th>
                <td>{{ optional($tarifa->modificado)->format('d/m/Y H:i') ?? '-' }}</td>
            </tr>
        </table>

        <div class="mt-3">
            <a href="{{ route('tarifas.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
            <a href="{{ route('tarifas.edit', $tarifa->id_tarifa) }}" class="btn btn-info">
                <i class="fas fa-edit"></i> Editar
            </a>
        </div>

    </div>
</div>
@stop
