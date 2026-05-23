@extends('adminlte::page')

@section('title', 'Editar Enlace Jurídico')

@section('content_header')
<h1 class="text-dark" style="font-family: Georgia, serif; font-weight: 800;">
    Editar Enlace Jurídico
</h1>
@stop

@section('content')

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>¡Error!</strong> Corrige los siguientes campos:
        <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
                <li>• {{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<div class="card shadow-lg">
    <div class="card-body">
        <form action="{{ route('enlaces.update', $enlace->id) }}" method="POST" autocomplete="off">
            @csrf
            @method('PUT')

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="nombre" class="font-weight-bold">Nombre del Enlace</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre', $enlace->nombre) }}" required>
                </div>

                <div class="form-group col-md-6">
                    <label for="enlace" class="font-weight-bold">URL</label>
                    <input type="url" name="enlace" id="enlace" class="form-control" value="{{ old('enlace', $enlace->enlace) }}" required>
                </div>
            </div>

            <div class="form-group">
                <label for="descripcion" class="font-weight-bold">Descripción</label>
                <input type="text" name="descripcion" id="descripcion" class="form-control" value="{{ old('descripcion', $enlace->descripcion) }}">
            </div>

            <div class="form-group col-md-4">
                <label for="estado" class="font-weight-bold">Estado</label>
                <select name="estado" id="estado" class="form-control" required>
                    <option value="activo" {{ $enlace->estado == 'activo' ? 'selected' : '' }}>Activo</option>
                    <option value="inactivo" {{ $enlace->estado == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                </select>
            </div>

          
            <div class="form-group mt-3">
                <a href="{{ route('enlaces.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
                <button type="submit" class="btn btn-success btn-sm">
                    <i class="fas fa-save"></i> Actualizar
                </button>
            </div>
        </form>
    </div>
</div>

@stop
