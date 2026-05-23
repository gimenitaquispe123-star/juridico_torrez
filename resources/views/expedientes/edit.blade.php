@extends('adminlte::page')

@section('title', 'Editar Expediente')

@section('content_header')
    <h1 class="text-dark" style="font-family: 'Merriweather', serif; font-weight: 800;">
        Editar Expediente
    </h1>
@stop

@section('content')
<div class="card shadow-lg">
    <div class="card-body">
        <form action="{{ route('expedientes.update', $expediente->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="form-group col-md-4">
                    <label for="id_cliente" class="font-weight-bold">Cliente</label>
                    <select name="id_cliente" id="id_cliente" class="form-control">
                        <option value="">-- Seleccione cliente --</option>
                        @foreach($clientes as $cliente)
                            <option value="{{ $cliente->id }}" {{ $expediente->id_cliente == $cliente->id ? 'selected' : '' }}>
                                {{ $cliente->nombre }} {{ $cliente->apellido }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md-4">
                    <label for="codigo_expediente" class="font-weight-bold">Código de Expediente</label>
                    <input type="text" name="codigo_expediente" id="codigo_expediente" class="form-control" value="{{ old('codigo_expediente', $expediente->codigo_expediente) }}" readonly>
                </div>

                <div class="form-group col-md-4">
                    <label for="nro_expediente" class="font-weight-bold">N° de Expediente</label>
                    <input type="text" name="nro_expediente" id="nro_expediente" class="form-control" value="{{ old('nro_expediente', $expediente->nro_expediente) }}">
                </div>

                <div class="form-group col-md-6">
                    <label for="demandante" class="font-weight-bold">Demandante</label>
                    <input type="text" name="demandante" id="demandante" class="form-control" value="{{ old('demandante', $expediente->demandante) }}">
                </div>

                <div class="form-group col-md-6">
                    <label for="demandado" class="font-weight-bold">Demandado</label>
                    <input type="text" name="demandado" id="demandado" class="form-control" value="{{ old('demandado', $expediente->demandado) }}">
                </div>

                <div class="form-group col-md-4">
                    <label for="materia" class="font-weight-bold">Materia</label>
                    <input type="text" name="materia" id="materia" class="form-control" value="{{ old('materia', $expediente->materia) }}">
                </div>

                <div class="form-group col-md-4">
                    <label for="contingencia" class="font-weight-bold">Contingencia</label>
                    <input type="text" name="contingencia" id="contingencia" class="form-control" value="{{ old('contingencia', $expediente->contingencia) }}">
                </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="estado_expediente" class="form-label">Estado del Expediente</label>
                            <input 
                                type="text" 
                                name="estado_expediente" 
                                id="estado_expediente" 
                                class="form-control" 
                                value="{{ old('estado_expediente', $expediente->estado_expediente) }}"
                                onkeypress="return /[A-Za-zÁÉÍÓÚáéíóúÑñ\s]/i.test(String.fromCharCode(event.charCode))"
                                placeholder="Escriba el estado del expediente">
                            @error('estado_expediente') 
                                <span class="text-danger">{{ $message }}</span> 
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="estado" class="font-weight-bold">Estado</label>
                            <select name="estado" id="estado" class="form-control">
                                <option value="1" {{ $expediente->estado ? 'selected' : '' }}>Activo</option>
                                <option value="0" {{ !$expediente->estado ? 'selected' : '' }}>Inactivo</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="respaldo" class="font-weight-bold">Respaldo (Documento)</label>
                            <input type="file" name="respaldo" id="respaldo" class="form-control-file">
                            @if($expediente->respaldo)
                                <small class="text-success">
                                    <i class="fas fa-check-circle"></i> Archivo actual: 
                                    <a href="{{ asset('storage/' . $expediente->respaldo) }}" target="_blank">Ver respaldo</a>
                                </small>
                            @endif
                        </div>
                    </div>

                                    


                <div class="form-group col-md-12">
                    <label for="observaciones" class="font-weight-bold">Observaciones</label>
                    <textarea name="observaciones" id="observaciones" class="form-control" rows="3">{{ old('observaciones', $expediente->observaciones) }}</textarea>
                </div>

            </div>

            <div class="text-right mt-4">
                <a href="{{ route('expedientes.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
                <button type="submit" class="btn btn-info">
                    <i class="fas fa-save"></i> Actualizar
                </button>
            </div>

        </form>
    </div>
</div>
@stop

@section('css')
    <style>
        .card {
            border-radius: 1rem;
        }
        .form-control, .form-select {
            border-radius: 0.5rem;
        }
        label {
            font-weight: 600;
        }
        .btn-success {
            background-color: #28a745 !important;
        }
    </style>
@stop
