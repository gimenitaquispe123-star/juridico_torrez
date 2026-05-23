@extends('adminlte::page')

@section('title', 'Editar Pago')

@section('content_header')
<h1 class="text-center" style="font-family: Georgia, serif; font-weight: 900;">
    Editar Pago
</h1>
@stop

@section('content')
<div class="card shadow">
<div class="card-body">

<form action="{{ route('pagos.update', $pago->id_pago) }}" method="POST">
@csrf
@method('PUT')

<div class="row mb-3">

<div class="col-md-6">
<label>Cliente:</label>
<input type="text" class="form-control"
value="{{ $pago->cliente->nombre_completo }}" readonly>
</div>

<div class="col-md-6">
<label>Tarifa:</label>
<input type="text" class="form-control"
value="{{ $pago->tarifa->categoria }}" readonly>
</div>

</div>


<div class="row mb-3">

<div class="col-md-4">
<label>Monto Total (Bs.)</label>
<input type="number"
id="monto_total"
class="form-control"
value="{{ number_format($pago->monto_total,2,'.','') }}"
readonly>
</div>


<div class="col-md-4">
<label>Monto Pagado (Bs.)</label>
<input type="number"
name="monto_pagado"
id="monto_pagado"
class="form-control"
step="0.01"
min="0"
value="{{ old('monto_pagado',$pago->monto_pagado) }}"
required>
</div>


<div class="col-md-4">
<label>Monto Pendiente (Bs.)</label>
<input type="number"
id="monto_pendiente"
class="form-control bg-light"
readonly
value="{{ number_format($pago->monto_pendiente,2,'.','') }}">
</div>

</div>


<div class="row mb-3">

<div class="col-md-4">
<label>Fecha de Pago:</label>
<input type="date"
name="fecha_pago"
class="form-control"
value="{{ old('fecha_pago', optional($pago->fecha_pago)->format('Y-m-d')) }}"
max="{{ date('Y-m-d') }}">
</div>


<div class="col-md-8">
<label>Glosa</label>
<textarea name="glosa_pago"
class="form-control"
rows="1"
placeholder="Escriba una descripción del pago...">{{ old('glosa_pago',$pago->glosa_pago) }}</textarea>
</div>

</div>


<div class="row mb-3 align-items-center">

<div class="col-md-2">
<label class="mb-0">Estado:</label>
</div>

<div class="col-md-10 d-flex align-items-center gap-3">

<div class="form-check">
<input type="radio"
name="estado"
value="Pagado"
class="form-check-input"
id="pagado"
{{ old('estado',$pago->estado) == 'Pagado' ? 'checked' : '' }}>
<label class="form-check-label">Pagado</label>
</div>

<div class="form-check">
<input type="radio"
name="estado"
value="Pendiente"
class="form-check-input"
id="pendiente"
{{ old('estado',$pago->estado) == 'Pendiente' ? 'checked' : '' }}>
<label class="form-check-label">Pendiente</label>
</div>

</div>
</div>


<div class="d-flex justify-content-center mt-4">

<button type="submit" class="btn btn-info">
Actualizar
</button>

<a href="{{ route('pagos.index') }}" class="btn btn-secondary ms-2">
Cancelar
</a>

</div>

</form>

</div>
</div>
@stop


@section('js')

<script>

document.addEventListener("DOMContentLoaded", function(){

const total = document.getElementById("monto_total");
const pagado = document.getElementById("monto_pagado");
const pendiente = document.getElementById("monto_pendiente");

const estadoPagado = document.getElementById("pagado");
const estadoPendiente = document.getElementById("pendiente");

function calcular(){

let totalVal = parseFloat(total.value) || 0;
let pagadoVal = parseFloat(pagado.value) || 0;

let resultado = totalVal - pagadoVal;

if(resultado < 0){
resultado = 0;
}

pendiente.value = resultado.toFixed(2);

if(pagadoVal >= totalVal){
estadoPagado.checked = true;
}else{
estadoPendiente.checked = true;
}

}

pagado.addEventListener("input", calcular);

calcular();

});

</script>

@stop