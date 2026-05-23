@extends('adminlte::page')

@section('title', 'Nueva Carpeta')

@section('content_header')
<h1 style="font-family: Georgia, serif;">Crear Carpeta</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('carpetas.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="nombre">Nombre de la Carpeta <span class="text-danger"></span></label>
                <input type="text" name="nombre" id="nombre" class="form-control" required>
            </div>

              <div class="form-group">
                <label for="padre_id">Carpeta Padre (opcional)</label>
                <select name="padre_id" id="padre_id" class="form-control">
                    <option value="">-- Ninguna --</option>
                    @foreach($carpetas as $c)
                        <option value="{{ $c->id }}">{{ $c->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="tipo_proceso_id">Tipo de Proceso (opcional)</label>
                <select name="tipo_proceso_id" id="tipo_proceso_id" class="form-control">
                    <option value="">-- Ninguno --</option>
                    @foreach($tipos_procesos as $tipo)
                        <option value="{{ $tipo->id }}">{{ $tipo->tipo_proceso }}</option>
                    @endforeach
                </select>
            </div>

           <div class="form-group">
    <label for="proceso_id">Proceso asociado (opcional)</label>
    <select name="proceso_id" id="proceso_id" class="form-control">
        <option value="">-- Ninguno --</option>

        @foreach($procesos as $proceso)
            <option value="{{ $proceso->id }}">
                {{ $proceso->proceso }} - 
                {{ $proceso->cliente->nombres ?? '' }}
                {{ $proceso->cliente->paterno ?? '' }}
                {{ $proceso->cliente->materno ?? '' }}
            </option>
        @endforeach

    </select>
</div>

            <button type="submit" class="btn btn-info">
                <i class="fas fa-folder-plus"></i> Crear Carpeta
            </button>
            <a href="{{ route('carpetas.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </form>
    </div>
</div>
@stop
