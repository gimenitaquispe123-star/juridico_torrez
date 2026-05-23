@extends('adminlte::page')

@section('title', 'Asignar Abogado')

@section('content_header')
    <h1 style="font-family: Georgia, serif;">Asignar Abogado al Expediente</h1>
@stop

@section('content')
<div class="card shadow">
    <div class="card-body">

        {{-- Mostrar errores de validación --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('asignar-abogado.store') }}" method="POST">
            @csrf

            <input type="hidden" name="id_expediente" value="{{ $expediente->id }}">

            <div class="form-group">
                <label>Expediente:</label>
                <input type="text" class="form-control" value="{{ $expediente->nro_expediente ?? 'N/A' }}" readonly>
            </div>

            <div class="form-group">
                <label>Seleccionar Abogado:</label>
                <select name="id_empleado" class="form-control select2" required>
                    <option value="">-- Seleccione --</option>
                    @foreach ($abogados as $abogado)
                        <option value="{{ $abogado->id }}" {{ old('id_empleado') == $abogado->id ? 'selected' : '' }}>
                            {{ $abogado->nombres }} {{ $abogado->paterno }} {{ $abogado->materno }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Fecha de Asignación:</label>
                <input type="date" name="fecha_asignacion" class="form-control" value="{{ old('fecha_asignacion') }}" required>
            </div>

            <div class="form-group">
                <label>Observación:</label>
                <textarea name="observacion" class="form-control" rows="3">{{ old('observacion') }}</textarea>
            </div>

            <button type="submit" class="btn btn-info">
                <i class="fas fa-save"></i> Registrar Asignación
            </button>
            <a href="{{ route('expedientes.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@stop

@section('css')
    {{-- Habilitar Select2 si lo usas --}}
    <link rel="stylesheet" href="{{ asset('vendor/select2/css/select2.min.css') }}">
@stop

@section('js')
    <script src="{{ asset('vendor/select2/js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "-- Seleccione --",
                allowClear: true
            });
        });
    </script>
@stop
