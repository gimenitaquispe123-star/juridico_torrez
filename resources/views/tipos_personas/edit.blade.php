@extends('adminlte::page')

@section('title', 'Editar Tipo de Persona')

@section('content_header')
    <h1 class="text-black"><i class="fas fa-user-edit"></i> Editar Tipo de Persona</h1>
@stop

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('tipos_personas.update', $tipoPersona->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="tipo_persona" class="font-weight-bold">Tipo de Persona <span class="text-danger"></span></label>
                <input type="text" name="tipo_persona" id="tipo_persona" 
                       class="form-control @error('tipo_persona') is-invalid @enderror" 
                       value="{{ old('tipo_persona', $tipoPersona->tipo_persona) }}" 
                       placeholder="Ejemplo: Natural, Jurídica..." required>
                @error('tipo_persona')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
    
            <div class="form-group">
                <label for="descripcion" class="font-weight-bold">Descripción</label>
                <textarea name="descripcion" id="descripcion" rows="4" 
                          class="form-control @error('descripcion') is-invalid @enderror"
                          placeholder="Escribe una breve descripción...">{{ old('descripcion', $tipoPersona->descripcion) }}</textarea>
                @error('descripcion')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

       
            <div class="row">
                <div class="col-md-6">
                    <label class="font-weight-bold">Registrado:</label>
                    <input type="text" class="form-control" value="{{ $tipoPersona->registrado }}" readonly>
                </div>
                <div class="col-md-6">
                    <label class="font-weight-bold">Última Modificación:</label>
                    <input type="text" class="form-control" 
                           value="{{ $tipoPersona->modificado ? $tipoPersona->modificado : 'Sin modificar' }}" readonly>
                </div>
            </div>

            <hr>

            <div class="text-right">
                <a href="{{ route('tipos_personas.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
                <button type="submit" class="btn btn-info">
                    <i class="fas fa-save"></i> Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div>
@stop

@section('css')
    <style>
        .card {
            border-radius: 15px;
        }
        label {
            color: #555;
        }
    </style>
@stop
