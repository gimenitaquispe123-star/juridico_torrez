@extends('adminlte::page')

@section('title', 'Nuevo Expediente')

@section('content_header')
<h5 style="font-family: Georgia, 'Times New Roman', serif; letter-spacing: 0.5px;">
    Registrar Nuevo Expediente
</h5>
@stop

@section('content')
<div class="card shadow">
    <div class="card-body">
        <form action="{{ route('expedientes.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row g-3">

                
                <div class="col-md-4">
                    <label for="codigo_expediente" class="form-label">Código de Expediente</label>
                    @php
                        $lastId = \App\Models\Expediente::max('id') ?? 0;
                        $codigo = 'EXP'.($lastId+1).'-PT';
                    @endphp
                    <input type="text" name="codigo_expediente" id="codigo_expediente" class="form-control" value="{{ $codigo }}" readonly>
                </div>

               <div class="col-md-4">
                    <label for="nro_expediente" class="form-label">Nro. de Expediente</label>

                    <input type="text"
                        name="nro_expediente"
                        id="nro_expediente"
                        class="form-control"
                        value="{{ old('nro_expediente') }}">

                    @error('nro_expediente')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

        
                <div class="col-md-4">
                    <label for="id_cliente" class="form-label">Cliente</label>
                    <select name="id_cliente" id="id_cliente" class="form-control select2">
                        <option value="">Seleccione...</option>
                        @foreach ($clientes as $cliente)
                            <option value="{{ $cliente->id }}" {{ old('id_cliente') == $cliente->id ? 'selected' : '' }}>
                                {{ $cliente->nombre_completo }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_cliente') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

              
               <div class="col-md-6">
    <label for="demandante" class="form-label">Demandante</label>
    <input type="text" name="demandante" id="demandante" class="form-control" value="{{ old('demandante') }}" 
        onkeypress="return /[A-Za-zÁÉÍÓÚáéíóúÑñ0-9\s\.\-]/i.test(String.fromCharCode(event.charCode))">
    @error('demandante') <span class="text-danger">{{ $message }}</span> @enderror
</div>

<div class="col-md-6">
    <label for="demandado" class="form-label">Demandado</label>
    <input type="text" name="demandado" id="demandado" class="form-control" value="{{ old('demandado') }}" 
        onkeypress="return /[A-Za-zÁÉÍÓÚáéíóúÑñ0-9\s\.\-]/i.test(String.fromCharCode(event.charCode))">
    @error('demandado') <span class="text-danger">{{ $message }}</span> @enderror
</div>

                <div class="col-md-4">
                    <label for="materia" class="form-label">Materia</label>
                    <input type="text" name="materia" id="materia" class="form-control" value="{{ old('materia') }}" required
                        onkeypress="return /[A-Za-zÁÉÍÓÚáéíóúÑñ\s]/i.test(String.fromCharCode(event.charCode))">
                    @error('materia') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                
                <div class="col-md-4">
                    <label for="contingencia" class="form-label">Contingencia</label>
                    <input type="text" name="contingencia" id="contingencia" class="form-control" value="{{ old('contingencia') }}" 
                        onkeypress="return /[A-Za-zÁÉÍÓÚáéíóúÑñ\s]/i.test(String.fromCharCode(event.charCode))">
                    @error('contingencia') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

               
                <div class="col-md-4 mt-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="estado" id="estado" {{ old('estado', true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="estado">Activo</label>
                    </div>
                </div>

               <div class="col-md-6">
                <label for="estado_expediente" class="form-label">Estado del Expediente</label>
                <input 
                    type="text" 
                    name="estado_expediente" 
                    id="estado_expediente" 
                    class="form-control" 
                    value="{{ old('estado_expediente', 'Iniciado') }}"
                    onkeypress="return /[A-Za-zÁÉÍÓÚáéíóúÑñ\s]/i.test(String.fromCharCode(event.charCode))"
                    placeholder="Escriba el estado del expediente">
                @error('estado_expediente') 
                    <span class="text-danger">{{ $message }}</span> 
                @enderror
            </div>


                <div class="col-md-6">
                    <label for="respaldo" class="form-label">Archivo de Respaldo</label>
                    <input type="file" name="respaldo" id="respaldo" class="form-control">
                    @error('respaldo') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="col-md-12">
                    <label for="observaciones" class="form-label">Observaciones</label>
                    <textarea name="observaciones" id="observaciones" rows="3" class="form-control">{{ old('observaciones') }}</textarea>
                    @error('observaciones') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="d-flex justify-content-center mt-4 gap-2">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Registrar
                    </button>

                    <a href="{{ route('expedientes.index') }}" class="btn btn-danger px-4">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                </div>

            </div>
        </form>
    </div>
</div>
@stop
