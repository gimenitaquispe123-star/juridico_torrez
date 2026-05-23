@extends('adminlte::page')

@section('title', 'Editar Tipo de Plantilla')

@section('content_header')
<h1 class="text-dark" style="font-family: Georgia, serif; font-weight: 800;">
    Editar Tipo de Plantilla
</h1>
@stop

@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<div class="card shadow-lg">
    <div class="card-body">
        <form action="{{ route('tipo_plantilla.update', $tipoPlantilla->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Tipo de Plantilla --}}
            <div class="form-group mb-3">
                <label for="tipo_plantilla">Tipo de Plantilla</label>
                <input type="text" name="tipo_plantilla" id="tipo_plantilla"
                       class="form-control @error('tipo_plantilla') is-invalid @enderror"
                       value="{{ old('tipo_plantilla', $tipoPlantilla->tipo_plantilla) }}" required>
                @error('tipo_plantilla')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Descripción --}}
            <div class="form-group mb-3">
                <label for="descripcion">Descripción</label>
                <textarea name="descripcion" id="descripcion"
                          class="form-control @error('descripcion') is-invalid @enderror"
                          rows="3">{{ old('descripcion', $tipoPlantilla->descripcion) }}</textarea>
                @error('descripcion')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Estado --}}
            <div class="form-group mb-3">
                <label for="estado">Estado</label>
                <select name="estado" id="estado"
                        class="form-control @error('estado') is-invalid @enderror" required>
                    <option value="1" {{ old('estado', $tipoPlantilla->estado) == 1 ? 'selected' : '' }}>Activo</option>
                    <option value="0" {{ old('estado', $tipoPlantilla->estado) == 0 ? 'selected' : '' }}>Inactivo</option>
                </select>
                @error('estado')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-center">
                <a href="{{ route('tipo_plantilla.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Cancelar
                </a>
                <button type="submit" class="btn btn-info">
                    <i class="fas fa-save"></i>Actualizar
                </button>
            </div>
        </form>
    </div>
</div>
@stop
