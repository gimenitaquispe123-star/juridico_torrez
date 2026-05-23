@extends('adminlte::page')

@section('title', 'Editar Seguimiento')

@section('content_header')
<h1 class="text-dark" style="font-family: Georgia, serif; font-weight: 800;">
    Editar Seguimiento
</h1>
@stop


@section('content')

<div class="card shadow-lg border-0 rounded-lg">

<div class="card-body">

<form action="{{ route('procesos_seguimiento.update', $seguimiento->id) }}" method="POST">

@csrf
@method('PUT')

<div class="row">

{{-- FECHA --}}
<div class="col-md-4">
<div class="form-group">
<label>Fecha del Seguimiento</label>
<input type="date"
name="fecha"
id="fecha"
class="form-control"
value="{{ old('fecha', $seguimiento->fecha) }}"
required>
</div>
</div>

{{-- ETAPA --}}
<div class="col-md-4">
<div class="form-group">
<label>Etapa del Proceso</label>
<input type="text"
name="etapa"
class="form-control"
value="{{ old('etapa', $seguimiento->etapa) }}">
</div>
</div>

{{-- CLIENTE --}}
<div class="col-md-4">
<div class="form-group">
<label>Cliente</label>
<select name="id_cliente" class="form-control">
<option value="">Seleccione un cliente</option>

@foreach ($clientes as $cliente)

<option value="{{ $cliente->id }}"
{{ $seguimiento->id_cliente == $cliente->id ? 'selected' : '' }}>

{{ $cliente->nombres }}

</option>

@endforeach

</select>
</div>
</div>

</div>


{{-- SEGUNDA FILA --}}

<div class="row">

{{-- ACCION --}}
<div class="col-md-4">
<div class="form-group">
<label>Acción Realizada</label>
<input type="text"
name="accion"
class="form-control"
value="{{ old('accion', $seguimiento->accion) }}">
</div>
</div>

{{-- DIAS PLAZO --}}
<div class="col-md-4">
<div class="form-group">
<label>Días de Plazo</label>
<input type="number"
name="dias_plazo"
id="dias_plazo"
class="form-control"
value="{{ old('dias_plazo', $seguimiento->dias_plazo) }}">
</div>
</div>

{{-- FECHA VENCIMIENTO --}}
<div class="col-md-4">
<div class="form-group">
<label>Fecha de Vencimiento</label>

<input type="date"
name="fecha_vencimiento"
id="fecha_vencimiento"
class="form-control"
value="{{ old('fecha_vencimiento', $seguimiento->fecha_vencimiento) }}"
readonly>

</div>
</div>

</div>


{{-- OBSERVACIONES --}}

<div class="form-group">

<label>Observaciones</label>

<textarea
name="observaciones"
rows="3"
class="form-control">{{ old('observaciones', $seguimiento->observaciones) }}</textarea>

</div>


{{-- BOTONES --}}

<div class="mt-3">

<button type="submit" class="btn btn-info">
<i class="fas fa-save"></i> Actualizar
</button>

<a href="{{ route('procesos_seguimiento.index', ['proceso_id' => $proceso->id ?? null]) }}"
class="btn btn-secondary">

<i class="fas fa-arrow-left"></i> Volver

</a>

</div>

</form>

</div>

</div>

@stop



@section('js')

<script>

document.addEventListener("DOMContentLoaded", function(){

let fecha = document.getElementById('fecha');
let dias = document.getElementById('dias_plazo');
let vencimiento = document.getElementById('fecha_vencimiento');

function calcularVencimiento(){

if(fecha.value && dias.value){

let f = new Date(fecha.value);

f.setDate(f.getDate() + parseInt(dias.value));

vencimiento.value = f.toISOString().split('T')[0];

}

}

fecha.addEventListener('change', calcularVencimiento);
dias.addEventListener('input', calcularVencimiento);

});

</script>

@stop