<div class="d-flex justify-content-between align-items-center mb-2">
    <div>
        <label>
            Mostrar
            <select id="perPage" class="custom-select custom-select-sm form-control form-control-sm" style="width:auto; display:inline-block;">
                @foreach([10,25,50,100] as $size)
                    <option value="{{ $size }}">{{ $size }}</option>
                @endforeach
            </select>
            registros por página
        </label>
    </div>

    <div class="input-group" style="width:250px;">
        <input type="text" id="busqueda" class="form-control form-control-sm" placeholder="Escriba para buscar...">
        <button class="btn btn-sm btn-danger" id="btnBuscar">Buscar</button>
    </div>
</div>

<div class="table-responsive">
    <table id="tablaDigitalizados" class="table table-bordered table-hover">
        <thead class="bg-light">
            <tr>
                <th>Nro exp</th>
                <th>Codigo Expediente</th>
                <th>Tipo</th>
                <th>Cliente</th>
                <th>Archivo</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            @foreach($digitalizados as $exp)
                <tr>
                    <td>{{ $exp->expediente->nro_expediente ?? '-' }}</td>
                    <td>{{ $exp->nro_expediente }}</td>
                    <td><span class="badge">{{ ucfirst($exp->tipo_expediente) }}</span></td>
                    <td>{{ $exp->cliente->nombres ?? 'Sin cliente' }}</td>
                    <td>
                        @if($exp->url_documento)
                            <a href="{{ asset('storage/'.$exp->url_documento) }}" target="_blank">
                                {{ basename($exp->url_documento) }}
                            </a>
                        @else
                            <span class="text-muted">No disponible</span>
                        @endif
                    </td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-toggle="dropdown">
                                Acciones
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ route('expedientes_digitalizados.edit', $exp->id) }}">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                <a class="dropdown-item" href="{{ route('expedientes_digitalizados.show', $exp->id) }}">
                                    <i class="fas fa-eye"></i> Ver Detalles
                                </a>


                                @if($exp->url_documento)
                                    <a class="dropdown-item" href="{{ route('expedientes_digitalizados.verPDF', basename($exp->url_documento)) }}" target="_blank">
                                        <i class="fas fa-file-pdf"></i> Ver PDF
                                    </a>
                                @endif
@can('eliminar expedientes digitalizados') 
                            <a href="#" class="dropdown-item text-danger"
                                onclick="event.preventDefault();
                                            if(confirm('¿Seguro que desea eliminar este expediente?')) {
                                                document.getElementById('delete-form-{{ $exp->id }}').submit();
                                            }">
                                    <i class="fas fa-trash"></i> Eliminar
                            </a>

<form id="delete-form-{{ $exp->id }}" action="{{ route('expedientes_digitalizados.destroy', $exp->id) }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endcan

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<div class="d-flex justify-content-center mt-3">
    {{ $digitalizados->links('pagination::bootstrap-4') }}
</div>


<script>
$(document).ready(function() {
    const table = $('#tablaDigitalizados').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
        },
        "responsive": true,
        "pageLength": 10,
        "lengthMenu": [10,25,50,100],
        "columnDefs": [
            { "orderable": false, "targets": 5 } 
        ],
        "dom": 't' 
    });

    $('#perPage').on('change', function() {
        table.page.len($(this).val()).draw();
    });

    $('#btnBuscar').on('click', function() {
        table.search($('#busqueda').val()).draw();
    });
});
</script>
