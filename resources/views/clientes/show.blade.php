@extends('adminlte::page')

@section('title', 'Ver Cliente')

@section('content_header')
    <h1 class="text-dark" style="font-family: Georgia, serif; font-weight: 800;">
        Detalle del Cliente
    </h1>
@stop

@section('content')
<div class="card shadow-lg border-0">
    <div class="card-header bg-info text-white">
        <h5 class="mb-0"><i class="fas fa-user"></i> Información General</h5>
    </div>
    <div class="card-body">
   
        <div class="row mb-3">
            <div class="col-md-4">
                <strong>Nombres:</strong>
                <p>{{ $cliente->nombres }}</p>
            </div>
            <div class="col-md-4">
                <strong>Apellido Paterno:</strong>
                <p>{{ $cliente->paterno }}</p>
            </div>
            <div class="col-md-4">
                <strong>Apellido Materno:</strong>
                <p>{{ $cliente->materno }}</p>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <strong>Cédula de Identidad:</strong>
                <p>{{ $cliente->ci }}</p>
            </div>
            <div class="col-md-4">
                <strong>Expedido:</strong>
                <p>{{ $cliente->ci_expedido }}</p>
            </div>
            <div class="col-md-4">
                <strong>Celular:</strong>
                <p>{{ $cliente->celular }}</p>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <strong>Dirección:</strong>
                <p>{{ $cliente->direccion }}</p>
            </div>
            <div class="col-md-6">
                <strong>Correo Electrónico:</strong>
                <p>{{ $cliente->email }}</p>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <strong>Fecha de Nacimiento:</strong>
                <p>{{ $cliente->fecha_nacimiento ?? '-' }}</p>
            </div>
            <div class="col-md-4">
                <strong>Registrado:</strong>
                <p>{{ $cliente->regsitrado ?? $cliente->created_at->format('d/m/Y') }}</p>
            </div>
            <div class="col-md-4">
                <strong>Usuario Registro:</strong>
                <p>{{ $cliente->usuario_reg ?? '-' }}</p>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <strong>Usuario Modificación:</strong>
                <p>{{ $cliente->usuario_mod ?? '-' }}</p>
            </div>
        </div>
    </div>
    <div class="card-footer d-flex justify-content-center">
        <a href="{{ route('clientes.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver
        </a>

        <a href="{{ route('clientes.edit', $cliente->id) }}" class="btn btn-info">
            <i class="fas fa-edit"></i> Editar
        </a>
    </div>
</div>
@stop
