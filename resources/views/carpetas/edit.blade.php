@extends('adminlte::page')

@section('title', 'Editar Carpeta')

@section('content_header')

<h1 style="font-family: Georgia, serif; font-weight: 900; color:black;">
    Editar Carpeta
</h1>
@stop

@section('content')

<div class="container-fluid">

<div class="card shadow">

<div class="card-header bg-info text-white">

<h5 class="mb-0">
<i class="fas fa-edit"></i> Editar Carpeta
</h5>

</div>

<div class="card-body">

<form action="{{ route('carpetas.update',$carpeta->id) }}" method="POST">

@csrf
@method('PUT')

<div class="form-group">

<label>Nombre de la Carpeta</label>

<input type="text"
name="nombre"
class="form-control"
value="{{ old('nombre',$carpeta->nombre) }}"
required>

</div>

<div class="form-group">

<label>Carpeta Padre (Opcional)</label>

<select name="padre_id" class="form-control">

<option value="">-- Ninguna --</option>

@foreach($carpetas as $c)

<option value="{{ $c->id }}"
{{ $carpeta->padre_id == $c->id ? 'selected' : '' }}>

{{ $c->nombre }}

</option>

@endforeach

</select>

</div>

<div class="form-group">

<label>Tipo de Proceso</label>

<select name="tipo_proceso_id" class="form-control">

<option value="">-- Seleccionar --</option>

@foreach($tipos_procesos as $tp)

<option value="{{ $tp->id }}"
{{ $carpeta->tipo_proceso_id == $tp->id ? 'selected' : '' }}>

{{ $tp->nombre }}

</option>

@endforeach

</select>

</div>

<div class="form-group">

<label>Proceso Asociado</label>

<select name="proceso_id" class="form-control">

<option value="">-- Ninguno --</option>

@foreach($procesos as $p)

<option value="{{ $p->id }}"
{{ $carpeta->proceso_id == $p->id ? 'selected' : '' }}>

{{ $p->proceso }} - {{ $p->cliente->nombre ?? 'N/A' }}

</option>

@endforeach

</select>

</div>

<div class="mt-4">

<button type="submit" class="btn btn-success">

<i class="fas fa-save"></i> Actualizar

</button>

<a href="{{ route('carpetas.index') }}" class="btn btn-secondary">

<i class="fas fa-arrow-left"></i> Cancelar

</a>

</div>

</form>

</div>

</div>

</div>

@stop
