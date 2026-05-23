@extends('adminlte::page')

@section('title', 'Asignar Abogado')

@section('content_header')
    <h1 class="text-dark" style="font-family: Georgia, serif; font-weight: 800;">
        <i class="fas fa-user-tie text-success"></i> Asignar Abogado al Expediente
    </h1>
@stop

@section('content')
<div class="card shadow-lg">
    <div class="card-body">
        <form action="{{ route('abogado_expediente.store') }}" method="POST">
            @csrf

            <input type="hidden" name="id_expediente" value="{{ $expediente->id }}">

            <div class="form-group">
                <label><i class="fas fa-folder-open text-primary"></i> Expediente:</label>
                <input type="text" class="form-control" value="{{ $expediente->codigo_expediente }}" readonly>
            </div>

            <div class="form-group">
                <label><i class="fas fa-user-tie text-success"></i> Seleccionar Abogado:</label>
                <select name="id_empleado" id="id_empleado" class="form-control select2" required>
        <option value="">Seleccione...</option>
        @forelse($abogados as $abogado)
            <option value="{{ $abogado->id }}">
                {{ $abogado->nombre_completo ?? $abogado->nombres . ' ' . $abogado->apellidos }}
            </option>
        @empty
            <option value="">No hay abogados registrados</option>
        @endforelse
    </select>
            </div>
            

            <div class="form-group">
                <label><i class="fas fa-calendar-alt text-info"></i> Fecha de Asignación:</label>
                <input type="date" name="fecha_asignacion" class="form-control" required>
            </div>

            <div class="form-group">
                <label><i class="fas fa-comment text-secondary"></i> Observaciones:</label>
                <textarea name="observacion" class="form-control" rows="3" placeholder="Observaciones..."></textarea>
            </div>

            <div class="text-right">
                <a href="{{ route('expedientes.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Registrar Asignación
                </button>
            </div>
        </form>
    </div>
</div>
@stop
