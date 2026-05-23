@extends('adminlte::page')

@section('title', 'Editar Asignación de Abogado')

@section('content_header')
<h1 style="font-family: Georgia;"><i class="fas fa-user-edit"></i> Editar Asignación de Abogado</h1>

@stop

@section('content')
<div class="container-fluid">
    <div class="card card-warning card-outline">
       
        <div class="card-body">
            <form action="{{ route('abogado_expediente.update', $abogado->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Expediente y Abogado --}}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="id_expediente">Expediente:</label>
                            <select name="id_expediente" id="id_expediente" class="form-control select2" required>
                                <option value="">-- Seleccione --</option>
                                @foreach ($expedientes as $exp)
                                    <option value="{{ $exp->id }}" @if($abogado->id_expediente == $exp->id) selected @endif>
                                        {{ $exp->codigo_expediente }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_expediente')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="id_empleado">Abogado:</label>
                            <select name="id_empleado" id="id_empleado" class="form-control select2" required>
                                <option value="">-- Seleccione --</option>
                                @foreach ($empleados as $emp)
                                    <option value="{{ $emp->id }}" @if($abogado->id_empleado == $emp->id) selected @endif>
                                        {{ $emp->nombres }} {{ $emp->paterno }} {{ $emp->materno }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_empleado')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Fechas --}}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="fecha_asignacion">Fecha Asignación:</label>
                            <input type="date" name="fecha_asignacion" id="fecha_asignacion" class="form-control"
                                   value="{{ $abogado->fecha_asignacion ? \Carbon\Carbon::parse($abogado->fecha_asignacion)->format('Y-m-d') : '' }}">
                            @error('fecha_asignacion')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
    <div class="form-group">
        <label for="fecha_desvinculacion">Fecha Desvinculación:</label>
        <input type="date" name="fecha_desvinculacion" id="fecha_desvinculacion" class="form-control" value="">
        @error('fecha_desvinculacion')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
</div>

                </div>

                {{-- Observación --}}
                <div class="form-group">
                    <label for="observacion">Observación:</label>
                    <textarea name="observacion" id="observacion" class="form-control" rows="3">{{ $abogado->observacion }}</textarea>
                    @error('observacion')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Estado --}}
                <div class="form-group">
                    <label for="estado">Estado:</label>
                    <select name="estado" id="estado" class="form-control">
                        <option value="1" @if($abogado->estado == 1) selected @endif>Activo</option>
                        <option value="0" @if($abogado->estado == 0) selected @endif>Inactivo</option>
                    </select>
                    @error('estado')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Botones --}}
                <div class="card-footer d-flex justify-content-between">
                    <a href="{{ route('expedientes.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save"></i> Guardar Cambios
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@stop

@section('css')
<style>
.select2 {
    width: 100% !important;
}
</style>
@stop

@section('js')
<script>
$(document).ready(function() {
    $('.select2').select2({
        theme: 'bootstrap4',
        placeholder: '-- Seleccione --'
    });
});
</script>
@stop
