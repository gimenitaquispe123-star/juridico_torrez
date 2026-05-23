@extends('adminlte::page')

@section('title', 'Detalles del Tipo de Persona')

@section('content_header')
   <h1 class="text-dark" style="font-family: Georgia, serif; font-weight: 800;">
 Detalles del Tipo de Persona
</h1>
@stop

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-6">
                <h6 class="text-secondary"><i class="fas fa-id-card"></i> ID:</h6>
                <p class="font-weight-bold">{{ $tipoPersona->id }}</p>
            </div>
            <div class="col-md-6">
                <h6 class="text-secondary"><i class="fas fa-user-tag"></i> Tipo de Persona:</h6>
                <p class="font-weight-bold text-dark">{{ $tipoPersona->tipo_persona }}</p>
            </div>
        </div>

        <div class="mb-3">
            <h6 class="text-secondary"><i class="fas fa-align-left"></i> Descripción:</h6>
            <div class="border rounded p-2 bg-light">
                {{ $tipoPersona->descripcion ?? 'Sin descripción disponible' }}
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <h6 class="text-secondary"><i class="fas fa-calendar-plus"></i> Fecha de Registro:</h6>
                <p>{{ \Carbon\Carbon::parse($tipoPersona->registrado)->format('d/m/Y H:i') }}</p>
            </div>
            <div class="col-md-6">
                <h6 class="text-secondary"><i class="fas fa-calendar-check"></i> Última Modificación:</h6>
                <p>
                    {{ $tipoPersona->modificado 
                        ? \Carbon\Carbon::parse($tipoPersona->modificado)->format('d/m/Y H:i')
                        : 'Sin modificar' }}
                </p>
            </div>
        </div>

        <hr>

        <div class="text-right">
            <a href="{{ route('tipos_personas.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
            <a href="{{ route('tipos_personas.edit', $tipoPersona->id) }}" class="btn btn-info">
                <i class="fas fa-edit"></i> Editar
            </a>
        </div>
    </div>
</div>
@stop

@section('css')
    <style>
        .card {
            border-radius: 15px;
        }
        h6 {
            color: #555;
            font-weight: 600;
        }
        .bg-light {
            background-color: #f9f9f9 !important;
        }
    </style>
@stop
