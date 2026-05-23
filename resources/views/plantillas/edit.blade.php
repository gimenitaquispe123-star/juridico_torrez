@extends('adminlte::page')

@section('title', 'Editar Plantilla')

@section('content_header')
<h1 class="text-dark font-weight-bold" style="font-family: Georgia, 'Times New Roman', Times, serif;">
    Editar Plantilla
</h1>
@stop

@section('content')
<div class="card shadow-lg">
    <div class="card-body">
        <form action="{{ route('plantillas.update', $plantilla->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row mb-3">
    <div class="col-md-6">
        <label for="id_tipo_plantilla" class="form-label">
            Tipo de Plantilla <span class="text-danger"></span>
        </label>
        <select name="id_tipo_plantilla" id="id_tipo_plantilla"
                class="form-control @error('id_tipo_plantilla') is-invalid @enderror" required>
            <option value="">-- Seleccione --</option>
            @foreach($tipos as $tipo)
                <option value="{{ $tipo->id }}"
                    {{ $plantilla->id_tipo_plantilla == $tipo->id ? 'selected' : '' }}>
                    {{ $tipo->tipo_plantilla ?? $tipo->nombre }}
                </option>
            @endforeach
        </select>
        @error('id_tipo_plantilla')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="plantilla" class="form-label">
            Nombre de la Plantilla <span class="text-danger"></span>
        </label>
        <input type="text" name="plantilla" id="plantilla"
               class="form-control @error('plantilla') is-invalid @enderror"
               value="{{ old('plantilla', $plantilla->plantilla) }}"
               placeholder="Ej. Plantilla de Sentencia" required>
        @error('plantilla')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

            <div class="form-group mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea name="descripcion" id="descripcion" rows="3"
                          class="form-control @error('descripcion') is-invalid @enderror"
                          placeholder="Descripción opcional">{{ old('descripcion', $plantilla->descripcion) }}</textarea>
                @error('descripcion')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

        
            <div class="form-group mb-3">
                <label for="archivo" class="form-label">Archivo de Plantilla</label>
                
                @if($plantilla->ruta_archivo)
                    <div class="mb-2">
                        <a href="{{ route('plantillas.verPDF', $plantilla->id) }}" target="_blank" class="btn btn-secondary btn-sm">
                            <i class="fas fa-file"></i> Ver archivo actual
                        </a>
                    </div>
                @endif


                <input type="file" name="archivo" id="archivo"
                       class="form-control @error('archivo') is-invalid @enderror"
                       accept=".pdf,.doc,.docx,.txt">
                <small class="form-text text-muted">
                    Subir archivo solo si desea reemplazar el existente.
                </small>
                @error('archivo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="estado" class="form-label">Estado</label>
                <select name="estado" id="estado"
                        class="form-control @error('estado') is-invalid @enderror">
                    <option value="1" {{ old('estado', $plantilla->estado) == 1 ? 'selected' : '' }}>Activo</option>
                    <option value="0" {{ old('estado', $plantilla->estado) == 0 ? 'selected' : '' }}>Inactivo</option>
                </select>
                @error('estado')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group mt-4 d-flex justify-content-center">
                <a href="{{ route('plantillas.index') }}" class="btn btn-info">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>

                
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-save"></i> Actualizar
                    </button>
                </div>
            </div>

        </form>
    </div>
</div>
@stop

@section('css')
<style>
    .form-label { font-weight: 600; }
    .btn-primary {
        background-color: #0056b3;
        border-color: #004a99;
    }
    .btn-primary:hover {
        background-color: #004a99;
    }
</style>
@stop
