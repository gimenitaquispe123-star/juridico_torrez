{{-- 🔹 Filtro superior --}}
<div class="row mb-3 align-items-center">
    <div class="col-md-6 d-flex align-items-center">
        <h6 class="text-secondary font-weight-bold mb-0">
            Lista de Plantillas
        </h6>
    </div>
    
    <div class="col-md-6 d-flex justify-content-end align-items-center">
    
        <form method="GET" action="{{ route('plantillas.index') }}" class="d-flex me-2">
            <input type="text" name="search" class="form-control form-control-sm" 
                   placeholder="Buscar plantilla..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-sm btn-info ms-2">
                <i class="fas fa-search"></i>
            </button>
        </form>

        <a href="{{ route('plantillas.create') }}" class="btn btn-orange btn-sm">
            <i class="fas fa-plus-circle"></i> Nuevo / Plantilla
        </a>
    </div>
</div>

<div class="table-responsive">
<table id="tablaPlantillas" class="table table-bordered table-striped table-hover text-center align-middle">
<thead class="table-light">
<tr>
<th>ID</th>
<th>Plantilla</th>
<th>Tipo</th>
<th>Descripción</th>
<th>Registrado</th>
<th>Estado</th>
<th style="width:200px;">Acciones</th>
</tr>
</thead>

<tbody>
@forelse($plantillas as $p)

<tr>

<td>{{ $p->id }}</td>

<td>{{ $p->plantilla }}</td>

<td>{{ $p->tipoPlantilla->tipo_plantilla ?? '—' }}</td>

<td>{{ $p->descripcion }}</td>

<td>{{ \Carbon\Carbon::parse($p->registrado)->format('d/m/Y H:i') }}</td>

<td>
@if($p->estado)
<span class="badge bg-success">Activo</span>
@else
<span class="badge bg-danger">Inactivo</span>
@endif
</td>

<td>
<div class="dropdown">

<button class="btn btn-info btn-sm dropdown-toggle"
type="button"
id="accionesDropdown{{ $p->id }}"
data-toggle="dropdown"
aria-haspopup="true"
aria-expanded="false">

Acciones

</button>

<div class="dropdown-menu dropdown-menu-right"
aria-labelledby="accionesDropdown{{ $p->id }}">

@if($p->ruta_archivo)

<a class="dropdown-item"
href="{{ route('plantillas.verPDF',$p->id) }}"
target="_blank">

<i class="fas fa-file text-info"></i> Descargar

</a>

@else

<span class="dropdown-item text-muted">
<i class="fas fa-ban"></i> No adjunto
</span>

@endif

<a class="dropdown-item"
href="{{ route('plantillas.edit',$p->id) }}">

<i class="fas fa-edit text-info"></i> Editar

</a>

<form action="{{ route('plantillas.destroy',$p->id) }}"
method="POST"
onsubmit="return confirm('¿Eliminar plantilla?')">

@csrf
@method('DELETE')

<button class="dropdown-item text-danger" type="submit">

<i class="fas fa-trash"></i> Eliminar

</button>

</form>

</div>
</div>
</td>

</tr>

@empty
{{-- ❌ IMPORTANTE: NO usar colspan aquí --}}
{{-- DataTables mostrará el mensaje automáticamente --}}
@endforelse
</tbody>

</table>
</div>

{{-- 🔹 Paginación Laravel --}}
<div class="d-flex justify-content-between align-items-center mt-3">

<div>
Mostrando
{{ $plantillas->firstItem() ?? 0 }}
a
{{ $plantillas->lastItem() ?? 0 }}
de
{{ $plantillas->total() }}
registros
</div>

<div>
{{ $plantillas->appends(['search'=>request('search')])->links() }}
</div>

</div>