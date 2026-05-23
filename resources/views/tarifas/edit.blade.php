@extends('adminlte::page')

@section('title', 'Editar Tarifa')

@section('content_header')
<h1 class="text-dark fw-bold" style="font-family: 'Merriweather', serif;">
    <i class="fas fa-coins text-info"></i> Editar Tarifa
</h1>
@stop

@section('content')
<div class="card shadow-lg border-0">
    <div class="card-body">
        <form action="{{ route('tarifas.update', $tarifa->id_tarifa) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="tipo_proceso_id">Tipo de Proceso <span class="text-danger"></span></label>
                <select name="tipo_proceso_id" id="tipo_proceso_id" class="form-control" required>
                    <option value="">Seleccione...</option>
                    @foreach($tiposProcesos as $tipo)
                        <option value="{{ $tipo->id }}" {{ $tarifa->tipo_proceso_id == $tipo->id ? 'selected' : '' }}>
                            {{ $tipo->tipo_proceso }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="categoria">Categoría</label>
                <input type="text" name="categoria" id="categoria" class="form-control" value="{{ $tarifa->categoria }}" placeholder="Ej. Básica, Premium">
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="monto_min">Monto Mínimo <span class="text-danger"></span></label>
                    <input type="number" name="monto_min" id="monto_min" step="0.01" class="form-control" value="{{ $tarifa->monto_min }}" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="monto_max">Monto Máximo <span class="text-danger"></span></label>
                    <input type="number" name="monto_max" id="monto_max" step="0.01" class="form-control" value="{{ $tarifa->monto_max }}" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="moneda">Moneda</label>
                    <select name="moneda" id="moneda" class="form-control">
                        <option value="Bs" {{ $tarifa->moneda == 'Bs' ? 'selected' : '' }}>Bolivianos (Bs)</option>
                        <option value="$us" {{ $tarifa->moneda == '$us' ? 'selected' : '' }}>Dólares ($us)</option>
                    </select>
                </div>
            </div>

            <div class="mt-3">
                <a href="{{ route('tarifas.index') }}" class="btn btn-secondary">
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
