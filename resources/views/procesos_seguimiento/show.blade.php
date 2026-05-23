@extends('adminlte::page')

@section('title', 'Detalle de Seguimiento')

@section('content_header')
<h1 class="text-dark" style="font-family: Georgia, serif; font-weight: 800;">
    Detalle del Seguimiento
</h1>
@stop


@section('content')

<div class="card shadow-lg border-0 rounded-lg">

<div class="card-body">

{{-- FILA 1 --}}
<div class="row">

<div class="col-md-4">
<label><b>ID</b></label>
<p>{{ $seguimiento->id }}</p>
</div>

<div class="col-md-4">
<label><b>Fecha del Seguimiento</b></label>
<p>
{{ \Carbon\Carbon::parse($seguimiento->fecha)->format('d/m/Y') }}
</p>
</div>

<div class="col-md-4">
<label><b>Proceso</b></label>
<p>{{ $seguimiento->proceso->proceso ?? '-' }}</p>
</div>

</div>


<div class="row mt-3">

<div class="col-md-4">
<label><b>Cliente</b></label>
<p>{{ $seguimiento->proceso->cliente->nombres ?? '-' }}</p>
</div>

<div class="col-md-4">
<label><b>Etapa</b></label>
<p>{{ $seguimiento->etapa ?? '-' }}</p>
</div>

<div class="col-md-4">
<label><b>Acción</b></label>
<p>{{ $seguimiento->accion ?? '-' }}</p>
</div>

</div>



<div class="row mt-3">

<div class="col-md-4">
<label><b>Días de Plazo</b></label>
<p>{{ $seguimiento->dias_plazo ?? '-' }}</p>
</div>

<div class="col-md-4">
<label><b>Fecha de Vencimiento</b></label>
<p>

@if($seguimiento->fecha_vencimiento)

{{ \Carbon\Carbon::parse($seguimiento->fecha_vencimiento)->format('d/m/Y') }}

@else

-

@endif

</p>
</div>

<div class="col-md-4">

<label><b>Estado del Plazo</b></label>

<p>

@if($seguimiento->estado_plazo == 'vencido')

<span class="badge badge-danger">
Vencido
</span>

@elseif($seguimiento->estado_plazo == 'proximo')

<span class="badge badge-warning">
Próximo
</span>

@elseif($seguimiento->estado_plazo == 'pendiente')

<span class="badge badge-success">
Pendiente
</span>

@else

-

@endif

</p>

</div>

</div>


{{-- OBSERVACIONES --}}
<div class="row mt-3">

<div class="col-md-12">

<label><b>Observaciones</b></label>

<p>{{ $seguimiento->observaciones ?? '-' }}</p>

</div>

</div>


{{-- USUARIOS --}}
<div class="row mt-3">

<div class="col-md-6">

<label><b>Usuario que Registró</b></label>

<p>

{{ $seguimiento->usuarioReg->usuario ?? '-' }}

</p>

</div>

<div class="col-md-6">

<label><b>Usuario que Modificó</b></label>

<p>

{{ $seguimiento->usuarioMod->usuario ?? '-' }}

</p>

</div>

</div>


{{-- FECHAS --}}
<div class="row mt-3">

<div class="col-md-6">

<label><b>Fecha de Registro</b></label>

<p>

{{ \Carbon\Carbon::parse($seguimiento->created_at)->format('d/m/Y H:i') }}

</p>

</div>

<div class="col-md-6">

<label><b>Fecha de Modificación</b></label>

<p>

{{ \Carbon\Carbon::parse($seguimiento->updated_at)->format('d/m/Y H:i') }}

</p>

</div>

</div>


{{-- BOTONES --}}
<div class="mt-4">

<a href="{{ route('procesos_seguimiento.index') }}"
class="btn btn-secondary">

<i class="fas fa-arrow-left"></i> Volver

</a>

<a href="{{ route('procesos_seguimiento.edit', $seguimiento->id) }}"
class="btn btn-info">

<i class="fas fa-edit"></i> Editar

</a>

</div>

</div>

</div>

@stop