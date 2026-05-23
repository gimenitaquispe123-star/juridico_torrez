@extends('adminlte::page')

@section('title', 'Crear Tipo de Plantilla')

@section('content_header')
    <h1 class="text-dark font-weight-bold" style="font-family: Georgia, serif;">
     Registrar Tipo de Plantilla
    </h1>
@stop

@section('content')
<div class="card shadow-lg">
    <div class="card-body">
        <form action="{{ route('tipo_plantilla.store') }}" method="POST">
            @csrf

            <div class="form-group mb-3">
                <label for="tipo_plantilla" class="form-label">Tipo de Plantilla <span class="text-danger"></span></label>
                <input type="text" name="tipo_plantilla" id="tipo_plantilla"
                       class="form-control @error('tipo_plantilla') is-invalid @enderror"
                       value="{{ old('tipo_plantilla') }}" placeholder="Ej. Sentencia, Resolución..." required>
                @error('tipo_plantilla')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

   
            <div class="form-group mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea name="descripcion" id="descripcion" rows="3"
                          class="form-control @error('descripcion') is-invalid @enderror"
                          placeholder="Breve descripción del tipo">{{ old('descripcion') }}</textarea>
                @error('descripcion')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            {{-- Estado --}}
            <div class="form-group mb-3">
                <label for="estado" class="form-label">Estado</label>
                <select name="estado" id="estado" class="form-control">
                    <option value="1" selected>Activo</option>
                    <option value="0">Inactivo</option>
                </select>
            </div>

            {{-- Botones --}}
            <div class="d-flex justify-content-center">
                <a href="{{ route('plantillas.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
                <button type="submit" class="btn btn-info">
                    <i class="fas fa-save"></i> Registrar
                </button>
            </div>
        </form>
    </div>
</div>
@stop

@section('css')
<style>
    .form-label { font-weight: 600; }
</style>
@stop
