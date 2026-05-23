@extends('adminlte::page')

@section('title', 'Detalle de Pago')

@section('content_header')
<h1 class="text-dark" style="font-family: Georgia, serif; font-weight: 800;">
    Detalle del Pago
</h1>
@stop

@section('content')
<div class="card shadow-lg">
    <div class="card-header bg-info text-white">
        <h3 class="card-title">
            <i class="fas fa-coins"></i> Información Detallada del Pago
        </h3>
       
    </div>

    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-6">
                <strong>Cliente:</strong><br>
                {{ $pago->cliente->nombre_completo ?? '-' }}
            </div>
            <div class="col-md-6">
                <strong>Tarifa:</strong><br>
                                 
    {{ $pago->tarifa ? $pago->tarifa->tipo_proceso . ' (' . number_format($pago->tarifa->monto_min, 2) . ' - ' . number_format($pago->tarifa->monto_max, 2) . ' Bs.)' : '-' }}


            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <strong>Monto Total:</strong><br>
                Bs. {{ number_format($pago->monto_total, 2) }}
            </div>
            <div class="col-md-4">
                <strong>Monto Pagado:</strong><br>
                Bs. {{ number_format($pago->monto_pagado, 2) }}
            </div>
            <div class="col-md-4">
                <strong>Monto Pendiente:</strong><br>
                Bs. {{ number_format($pago->monto_pendiente, 2) }}
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <strong>Fecha de Pago:</strong><br>
                {{ $pago->fecha_pago ? $pago->fecha_pago->format('d/m/Y') : '-' }}
            </div>
            <div class="col-md-6">
                <strong>Estado:</strong><br>
                <span class="badge {{ $pago->estado == 'Pagado' ? 'badge-success' : 'badge-warning' }}">
                    {{ $pago->estado }}
                </span>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                <strong>Glosa / Detalle:</strong><br>
                {{ $pago->glosa_pago ?? '-' }}
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <strong>Registrado por:</strong><br>
                {{ $pago->usuarioRegistro->name ?? 'Sin registro' }}
            </div>
            <div class="col-md-6">
                <strong>Modificado por:</strong><br>
                {{ $pago->usuarioModifico->name ?? 'Sin modificación' }}
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <strong>Creado en:</strong><br>
                {{ $pago->created_at ? $pago->created_at->format('d/m/Y H:i') : '-' }}
            </div>
            <div class="col-md-6">
                <strong>Última actualización:</strong><br>
                {{ $pago->updated_at ? $pago->updated_at->format('d/m/Y H:i') : '-' }}
            </div>
        </div>
    </div>

    <div class="card-footer d-flex justify-content-center">
        <a href="{{ route('pagos.edit', $pago->id_pago) }}" class="btn btn-info">
            <i class="fas fa-edit"></i> Editar Pago
        </a>
        <a href="{{ route('pagos.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver al listado
        </a>
    </div>
</div>
@stop
