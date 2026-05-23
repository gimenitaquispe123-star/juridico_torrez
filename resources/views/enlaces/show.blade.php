@extends('adminlte::page')

@section('title', 'Detalles del Enlace Jurídico')

@section('content_header')
<h1 class="text-dark" style="font-family: Georgia, serif; font-weight: 800;">
    Detalles del Enlace Jurídico
</h1>
@stop

@section('content')

<div class="card shadow-lg">
    <div class="card-body">
        <div class="form-group">
            <label class="font-weight-bold">Nombre:</label>
            <p>{{ $enlace->nombre }}</p>
        </div>

        <div class="form-group">
            <label class="font-weight-bold">Enlace:</label>
            <p><a href="{{ $enlace->enlace }}" target="_blank">{{ $enlace->enlace }}</a></p>
        </div>

        <div class="form-group">
            <label class="font-weight-bold">Descripción:</label>
            <p>{{ $enlace->descripcion ?? '—' }}</p>
        </div>

        <div class="form-group">
            <label class="font-weight-bold">Estado:</label>
            <p>
                @if($enlace->estado == 'activo')
                    <span class="badge badge-success">Activo</span>
                @else
                    <span class="badge badge-danger">Inactivo</span>
                @endif
            </p>
        </div>

        <div class="form-group">
            <label class="font-weight-bold">Registrado por:</label>
            <p>{{ $enlace->usuarioRegistrado->usuario ?? '—' }}</p>
        </div>

        <div class="form-group">
            <label class="font-weight-bold">Modificado por:</label>
            <p>{{ $enlace->usuarioModificado->usuario ?? '—' }}</p>
        </div>

        <div class="form-group mt-3">
            <a href="{{ route('enlaces.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
            <a href="{{ route('enlaces.edit', $enlace->id) }}" class="btn btn-info btn-sm">
                <i class="fas fa-edit"></i> Editar
            </a>
        </div>
    </div>
</div>

@stop
