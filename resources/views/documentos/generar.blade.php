@extends('adminlte::page')

@section('title', 'Generar Documento')

@section('content_header')
<h1>Generar documento desde plantilla</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('documentos.subir', $plantilla->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>Proceso/Expediente</label>
                <select name="proceso_id" class="form-control" required>
                    <option value="">-- Seleccione proceso --</option>
                    @foreach(\App\Models\Proceso::all() as $proceso)
                        <option value="{{ $proceso->id }}">{{ $proceso->nombre_cliente ?? 'Proceso '.$proceso->id }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Documento generado</label>
                <a href="{{ asset('storage/' . $rutaCopia) }}" target="_blank" class="btn btn-info">
                    <i class="fas fa-file-alt"></i> Ver / Descargar
                </a>
            </div>

            <div class="form-group">
                <label>Subir versión final</label>
                <input type="file" name="documento" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success">
                <i class="fas fa-upload"></i> Subir a proceso
            </button>
        </form>
    </div>
</div>
@stop
