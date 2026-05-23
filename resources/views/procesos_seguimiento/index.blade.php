@extends('adminlte::page')

@section('title', 'Seguimientos de Procesos')

@section('content_header')
<h1 class="text-dark" style="font-family: Georgia, serif; font-weight: 800;">
@if(isset($cliente))
Seguimientos del Cliente:
<span class="text-primary">{{ $cliente->nombres }}</span>
@else
Seguimientos de Procesos
@endif
</h1>
@stop

@section('content')

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show">
{{ session('success') }}
<button type="button" class="close" data-dismiss="alert">
<span>&times;</span>
</button>
</div>
@endif

<div class="card shadow-lg border-0 rounded-lg">

<div class="card-header d-flex flex-wrap justify-content-between align-items-center bg-light">

<form method="GET"
action="{{ isset($proceso) ? route('procesos_seguimiento.index',['proceso_id'=>$proceso->id]) : route('procesos_seguimiento.index') }}"
class="form-inline w-100">

<div class="form-row align-items-center w-100">

<a href="{{ route('procesos.index') }}" class="text-danger mr-3">
<i class="fas fa-arrow-left"></i> Atrás
</a>

<div class="col-auto">
<select name="per_page" class="form-control form-control-sm" onchange="this.form.submit()">
<option disabled>Mostrar</option>
@foreach([5,10,15,25,50,100] as $cantidad)
<option value="{{ $cantidad }}" {{ request('per_page')==$cantidad?'selected':'' }}>
{{ $cantidad }}
</option>
@endforeach
</select>
</div>

<div class="col-auto">
<input type="text" name="buscar" value="{{ request('buscar') }}"
class="form-control form-control-sm" placeholder="Buscar seguimiento...">
</div>

<div class="col-auto">
<button class="btn btn-info btn-sm">
<i class="fas fa-search"></i> Buscar
</button>
</div>

<div class="col-auto ml-auto">
<a href="{{ isset($proceso) ? route('procesos_seguimiento.create',['proceso_id'=>$proceso->id]) : route('procesos_seguimiento.create') }}"
class="btn btn-sm btn-danger">
<i class="fas fa-plus"></i> Nuevo Seguimiento
</a>
</div>

</div>
</form>
</div>

<div class="card-body table-responsive">

<table class="table table-bordered table-hover text-center align-middle">

<thead class="thead-light">
<tr>
<th>ID</th>
<th>Fecha</th>
<th>Proceso</th>
<th>Etapa</th>
<th>Plazo</th>
<th>Vencimiento</th>
<th>Estado</th>
<th>Cliente</th>
<th>Acciones</th>
</tr>
</thead>

<tbody>

@forelse($seguimientos as $index => $item)

@php
$hoy = \Carbon\Carbon::today();
$vencimiento = $item->fecha_vencimiento ? \Carbon\Carbon::parse($item->fecha_vencimiento) : null;
@endphp

<tr>

<td>
{{ $index + 1 + ($seguimientos->currentPage()-1) * $seguimientos->perPage() }}
</td>

<td>
{{ \Carbon\Carbon::parse($item->fecha)->format('d/m/Y') }}
</td>

<td>
{{ $item->proceso->proceso ?? '-' }}
</td>

<td>{{ $item->etapa ?? '-' }}</td>
<td>{{ $item->dias_plazo ? $item->dias_plazo.' días' : '-' }}</td>

<td>
{{ $item->fecha_vencimiento ? \Carbon\Carbon::parse($item->fecha_vencimiento)->format('d/m/Y') : '-' }}
</td>

<td>

@if($item->estado_plazo == 'vencido')
<span class="badge badge-danger">Vencido</span>

@elseif($item->estado_plazo == 'proximo')
<span class="badge badge-warning">Próximo</span>

@elseif($item->estado_plazo == 'pendiente')
<span class="badge badge-success">Pendiente</span>

@else
-
@endif

</td>

<td>

@if($item->proceso && $item->proceso->cliente)

<a href="{{ route('procesos_seguimiento.cliente',$item->proceso->cliente->id) }}"
class="text-primary font-weight-bold">

{{ $item->proceso->cliente->nombres }}

</a>

@else
-
@endif

</td>

<td>

<div class="dropdown">

<button class="btn btn-secondary btn-sm dropdown-toggle"
data-toggle="dropdown">
Acciones
</button>

<div class="dropdown-menu dropdown-menu-right">

<a class="dropdown-item"
href="{{ route('procesos_seguimiento.show',$item->id) }}">
<i class="fas fa-eye"></i> Detalles
</a>

<a class="dropdown-item"
href="{{ route('procesos_seguimiento.edit',$item->id) }}">
<i class="fas fa-edit"></i> Editar
</a>

<form action="{{ route('procesos_seguimiento.destroy',$item->id) }}"
method="POST"
onsubmit="return confirm('¿Eliminar seguimiento?')">

@csrf
@method('DELETE')

<button class="dropdown-item text-danger">
<i class="fas fa-trash"></i> Eliminar
</button>

</form>

</div>

</div>

</td>

</tr>

@empty

<tr>
<td colspan="10" class="text-muted">
No hay seguimientos registrados
</td>
</tr>

@endforelse

</tbody>
</table>

<div class="d-flex justify-content-between mt-3 align-items-center">

<div class="text-muted small">
Mostrando {{ $seguimientos->firstItem() ?? 0 }}
- {{ $seguimientos->lastItem() ?? 0 }}
de {{ $seguimientos->total() ?? 0 }}
</div>

<div>
{{ $seguimientos->appends(request()->query())->links() }}
</div>

</div>

</div>
</div>

@stop


@section('js')

<script>

$(function(){

$('.table').DataTable({

language:{ url:'//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json' },

responsive:true,
paging:false,
ordering:true,
info:false,
searching:false

});

});

</script>

@stop