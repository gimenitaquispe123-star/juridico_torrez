@extends('adminlte::page')

@section('title', 'Editar Tipo de Proceso')

@section('content_header')
<h1 class="text-dark" style="font-family: Georgia, serif; font-weight: 800;">
    Editar Tipo de Proceso
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

@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>¡Error!</strong> Corrige los siguientes campos antes de continuar:
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
    <div class="card-header">
        <h5 class="mb-0">Editar Tipo de Proceso</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('tipos_proceso.update', $tipos_proceso) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="tipo_proceso" class="font-weight-bold">Tipo de Proceso <span class="text-danger"></span></label>
                    <input type="text" name="tipo_proceso" id="tipo_proceso" 
                           class="form-control @error('tipo_proceso') is-invalid @enderror" 
                           value="{{ old('tipo_proceso', $tipos_proceso->tipo_proceso) }}" required>
                    @error('tipo_proceso')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="descripcion" class="font-weight-bold">Descripción</label>
                    <input type="text" name="descripcion" id="descripcion" 
                           class="form-control @error('descripcion') is-invalid @enderror" 
                           value="{{ old('descripcion', $tipos_proceso->descripcion) }}">
                    @error('descripcion')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="alert alert- p-2">
                <i class="fas fa-info-circle"></i> Los campos <strong>Registrado</strong> y <strong>Modificado</strong> se llenan automáticamente.
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-info">
                    <i class="fas fa-save"></i> Actualizar
                </button>
                <a href="{{ route('tipos_proceso.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

@stop
