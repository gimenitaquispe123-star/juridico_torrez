@extends('adminlte::page')

@section('title', 'Crear Plantilla')

@section('content_header')
<h1 class="text-dark font-weight-bold" style="font-family: Georgia, 'Times New Roman', Times, serif;">
    Crear Plantilla
</h1>
@stop

@section('content')
<div class="card shadow-lg">
    <div class="card-body">
        <form action="{{ route('plantillas.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

           <div class="row">
    <div class="col-md-6">
        <div class="form-group mb-3">
            <label for="id_tipo_plantilla" class="form-label">
                Tipo de Plantilla <span class="text-danger"></span>
            </label>
            <select name="id_tipo_plantilla" id="id_tipo_plantilla"
                class="form-control @error('id_tipo_plantilla') is-invalid @enderror" required>
                <option value="">-- Seleccione --</option>
                @foreach($tipos as $tipo)
                    <option value="{{ $tipo->id }}" {{ old('id_tipo_plantilla') == $tipo->id ? 'selected' : '' }}>
                        {{ $tipo->tipo_plantilla ?? $tipo->nombre }}
                    </option>
                @endforeach
            </select>
            @error('id_tipo_plantilla')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group mb-3">
            <label for="plantilla" class="form-label">
                Nombre de la Plantilla <span class="text-danger"></span>
            </label>
            <input type="text" name="plantilla" id="plantilla"
                class="form-control @error('plantilla') is-invalid @enderror"
                value="{{ old('plantilla') }}"
                placeholder="Ej. Plantilla de Sentencia" required>
            @error('plantilla')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>


            <div class="form-group mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea name="descripcion" id="descripcion" rows="3"
                    class="form-control @error('descripcion') is-invalid @enderror"
                    placeholder="Descripción opcional">{{ old('descripcion') }}</textarea>
                @error('descripcion')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3">
    <label for="archivo" class="form-label">Archivo de Plantilla</label>

    <input type="file" name="archivo" id="archivo"
        class="form-control @error('archivo') is-invalid @enderror"
        accept=".pdf,.doc,.docx,.txt,.jpg,.jpeg,.png,.webp">

    <small class="form-text text-muted">
        Formatos permitidos: PDF, DOC, DOCX, TXT, JPG, JPEG, PNG, WEBP (máx. 8 MB)
    </small>

    @error('archivo')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>


            <div class="form-group mb-3">
                <label for="estado" class="form-label">Estado</label>
                <select name="estado" id="estado"
                    class="form-control @error('estado') is-invalid @enderror">
                    <option value="1" {{ old('estado', '1') == '1' ? 'selected' : '' }}>Activo</option>
                    <option value="0" {{ old('estado') == '0' ? 'selected' : '' }}>Inactivo</option>
                </select>
                @error('estado')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            
            <div class="form-group mt-4 d-flex justify-content-center">
                 <button type="submit" class="btn btn-info">
                    <i class="fas fa-save"></i> Registrar
                </button>
                <a href="{{ route('plantillas.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
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
