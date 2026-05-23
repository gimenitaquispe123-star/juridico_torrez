@extends('adminlte::page')

@section('title', 'Editar Permiso')

@section('content_header')
<h1 class="text-dark" style="font-family: Georgia, serif; font-weight: 800;">
    Editar Permiso
</h1>
@stop

@section('content')
<div class="card shadow-lg">
    <div class="card-body">
        <form action="{{ route('permisos.update', $permission->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Nombre del Permiso</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', $permission->name) }}" required>
                @error('name')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="mt-3">
                <a href="{{ route('permisos.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Cancelar
                </a>
                <button type="submit" class="btn btn-info">
                    <i class="fas fa-save"></i> Guardar cambios
                </button>
            </div>
        </form>
    </div>
</div>
@stop
