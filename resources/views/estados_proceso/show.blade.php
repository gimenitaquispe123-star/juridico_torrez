@extends('adminlte::page')

@section('title', 'Detalle Estado de Proceso')

@section('content_header')
<h1 class="text-dark" style="font-family: Georgia, serif; font-weight: 800;">
    Detalle del Estado de Proceso
</h1>
@stop

@section('content')

<div class="card shadow-lg">
    <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
        <span class="font-weight-bold"><i class="fas fa-eye"></i> Estado de Proceso #{{ $estado->id }}</span>
        
    </div>

    <div class="card-body">
        <div class="row mb-2">
            <div class="col-md-4 font-weight-bold">Estado de Proceso:</div>
            <div class="col-md-8">{{ $estado->estado_proceso }}</div>
        </div>

        <div class="row mb-2">
            <div class="col-md-4 font-weight-bold">Descripción:</div>
            <div class="col-md-8">{{ $estado->descripcion ?? '-' }}</div>
        </div>

        <div class="row mb-2">
            <div class="col-md-4 font-weight-bold">Registrado:</div>
            <div class="col-md-8">{{ $estado->registrado }}</div>
        </div>

        <div class="row mb-2">
            <div class="col-md-4 font-weight-bold">Modificado:</div>
            <div class="col-md-8">{{ $estado->modificado ?? '-' }}</div>
        </div>

        <div class="row mb-2">
            <div class="col-md-4 font-weight-bold">Usuario Registro:</div>
            <div class="col-md-8">{{ $estado->usuario_reg }}</div>
        </div>

        <div class="row mb-2">
            <div class="col-md-4 font-weight-bold">Usuario Modificación:</div>
            <div class="col-md-8">{{ $estado->usuario_mod ?? '-' }}</div>
        </div>
    </div>

    <div class="card-footer text-right">
        <a href="{{ route('estados_proceso.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Volver al listado
        </a>
        <a href="{{ route('estados_proceso.edit', $estado) }}" class="btn btn-info btn-sm">
            <i class="fas fa-edit"></i> Editar
        </a>
    </div>
</div>

@stop
