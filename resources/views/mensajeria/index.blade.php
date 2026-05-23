@extends('adminlte::page')

@section('title', 'Mensajería')

@section('content_header')
<h1 class="text-dark" style="font-family: Georgia, serif; font-weight: 800;">
    Mensajería
</h1>
@stop

@section('content')

{{-- ALERTAS --}}
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show">
    {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert">
        <span>&times;</span>
    </button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show">
    {{ session('error') }}
    <button type="button" class="close" data-dismiss="alert">
        <span>&times;</span>
    </button>
</div>
@endif


<div class="card shadow-lg">

{{-- HEADER --}}
<div class="card-header d-flex flex-wrap justify-content-between align-items-center">

<form method="GET" action="{{ route('mensajeria.index') }}" class="form-inline w-100">

<div class="form-row align-items-center w-100">

<div class="col-auto">
<select name="per_page" class="form-control form-control-sm" onchange="this.form.submit()">
@foreach([5,10,15,25,50,100] as $cantidad)
<option value="{{ $cantidad }}" {{ request('per_page',10)==$cantidad ? 'selected':'' }}>
{{ $cantidad }}
</option>
@endforeach
</select>
</div>

<div class="col-auto">
<input type="text"
name="buscar"
value="{{ request('buscar') }}"
class="form-control form-control-sm"
placeholder="Buscar mensaje...">
</div>

<div class="col-auto">
<button type="submit" class="btn btn-info btn-sm">
<i class="fas fa-search"></i> Buscar
</button>
</div>

<div class="col-auto ml-auto">
<button type="button"
class="btn btn-sm"
data-toggle="modal"
data-target="#modalNuevoMensaje"
style="background-color:white;color:#0d6efd;border:1px solid #0d6efd">
<i class="fas fa-plus"></i> Nuevo
</button>
</div>

</div>
</form>

</div>


<div class="card-body table-responsive">

<table class="table table-bordered table-hover text-center">

<thead class="thead-light">
<tr>
<th>ID</th>
<th>Cliente</th>
<th>Asunto</th>
<th>Mensaje</th>
<th>Fecha</th>
<th>Acciones</th>
</tr>
</thead>


<tbody>

@forelse($mensajes as $m)

<tr>

<td>{{ $m->id }}</td>

<td>
{{ $m->cliente->nombres ?? '—' }}
{{ $m->cliente->paterno ?? '' }}
</td>

<td>{{ $m->asunto }}</td>

<td>
{{ \Illuminate\Support\Str::limit($m->mensaje,50) }}
</td>

<td>
{{ $m->registrado
? \Carbon\Carbon::parse($m->registrado)->format('d/m/Y H:i')
: '—' }}
</td>

<td>

<div class="dropdown">

<button class="btn btn-secondary btn-sm dropdown-toggle"
type="button"
data-toggle="dropdown">

 Acciones

</button>

<div class="dropdown-menu dropdown-menu-right">

{{-- VER --}}
<a href="{{ route('mensajeria.show',$m->id) }}"
class="dropdown-item">

<i class="fas fa-eye text-info"></i>
Ver detalle

</a>


@if($m->enviado_email)

<span class="dropdown-item text-success">
<i class="fas fa-check"></i> Email enviado
</span>

@else

<a href="{{ route('mensajeria.enviarEmail',$m->id) }}"
class="dropdown-item">

<i class="fas fa-envelope text-danger"></i>
Enviar Email

</a>

@endif


@if($m->estado)

<span class="dropdown-item text-black">
<i class="fas fa-check"></i> WhatsApp enviado
</span>

@else

@if($m->cliente && $m->cliente->celular)

<a href="{{ route('mensajeria.enviarWhatsApp',$m->id) }}"
class="dropdown-item">
<i class="fab fa-whatsapp text-success"></i>
Enviar WhatsApp

</a>

@else

<span class="dropdown-item text-muted">
Sin celular
</span>

@endif

@endif

</div>

</div>

</td>

</tr>

@empty

<tr>
<td colspan="6" class="text-center text-muted">
No hay mensajes registrados.
</td>
</tr>

@endforelse

</tbody>

</table>


{{-- PAGINACIÓN --}}
<div class="d-flex justify-content-between align-items-center mt-2">

<div>
Mostrando {{ $mensajes->firstItem() ?? 0 }}
-
{{ $mensajes->lastItem() ?? 0 }}
de {{ $mensajes->total() ?? 0 }}
</div>

<div>
{{ $mensajes->links('pagination::bootstrap-4') }}
</div>

</div>

</div>

</div>


<div class="modal fade" id="modalNuevoMensaje">

<div class="modal-dialog modal-dialog-centered">

<div class="modal-content border-0 shadow-lg">

<div class="modal-header bg-info text-white">
<h5 class="modal-title">
<i class="fas fa-envelope"></i> Nuevo Mensaje
</h5>

<button type="button" class="close text-white" data-dismiss="modal">
<span>&times;</span>
</button>
</div>


<form action="{{ route('mensajeria.store') }}" method="POST">

@csrf

<div class="modal-body">

<div class="form-group">
<label>Cliente</label>

<select name="id_cliente" class="form-control" required>

<option value="">Seleccione un cliente</option>

@foreach($clientes as $cliente)

<option value="{{ $cliente->id }}">

{{ $cliente->nombres }}
{{ $cliente->paterno }}
- {{ $cliente->celular }}

</option>

@endforeach

</select>

</div>


<div class="form-group">

<label>Asunto</label>

<input type="text"
name="asunto"
class="form-control"
required>

</div>


<div class="form-group">

<label>Mensaje</label>

<textarea name="mensaje"
class="form-control"
rows="4"
required></textarea>

</div>

</div>


<div class="modal-footer">

<button type="button"
class="btn btn-info"
data-dismiss="modal">

<i class="fas fa-times"></i> Cancelar

</button>

<button type="submit"
class="btn btn-danger">

<i class="fas fa-paper-plane"></i> Guardar

</button>

</div>

</form>

</div>

</div>

</div>

@stop