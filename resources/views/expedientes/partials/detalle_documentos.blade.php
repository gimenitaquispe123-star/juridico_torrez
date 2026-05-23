@php
$documentos = $expediente->documentos ?? collect();
@endphp

<div class="card shadow-sm mt-3 border-top border-primary">
    <div class="table-responsive">
        <table id="tablaDocumentos" class="table table-bordered table-striped table-hover align-middle text-center">
            <thead class="bg-light text-primary">
                <tr>
                    <th>ID</th>
                    <th>Documento</th>
                    <th>Observación</th>
                    <th>Ruta</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($documentos as $index => $doc)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $doc->documento->nombre ?? 'N/A' }}</td>
                        <td>{{ $doc->observacion_descripcion ?? '-' }}</td>
                        <td>{{ $doc->ruta_documento ?? '-' }}</td>
                        <td>
                            @if ($doc->estado)
                                <span class="badge bg-success">Activo</span>
                            @else
                                <span class="badge bg-danger">Inactivo</span>
                            @endif
                        </td>
                        <td>
                            {{-- Botones editar/eliminar --}}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">No hay documentos asignados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
