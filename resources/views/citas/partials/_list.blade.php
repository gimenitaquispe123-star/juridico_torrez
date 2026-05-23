<form method="GET" class="mb-3">
    <div class="d-flex align-items-center gap-2 flex-wrap">

        <label class="mb-0 font-weight-bold">Mostrar:</label>

        <select name="porPagina" class="form-control form-control-sm w-auto" onchange="this.form.submit()">
            <option value="5" {{ $porPagina == 5 ? 'selected' : '' }}>5</option>
            <option value="10" {{ $porPagina == 10 ? 'selected' : '' }}>10</option>
            <option value="15" {{ $porPagina == 15 ? 'selected' : '' }}>15</option>
            <option value="25" {{ $porPagina == 25 ? 'selected' : '' }}>25</option>
            <option value="50" {{ $porPagina == 50 ? 'selected' : '' }}>50</option>
            <option value="100" {{ $porPagina == 100 ? 'selected' : '' }}>100</option>
        </select>

        <span class="text-muted">Entradas</span>

    </div>
</form>

<div class="table-responsive">
    <table id="tablaCitas" class="table table-bordered table-striped table-hover text-center align-middle">
        
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Empleado</th>
                <th>Título</th>
                <th>Asunto</th>
                <th>Fecha / Hora</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            @forelse($citas as $cita)
                <tr>

                    <td>
                        {{ $loop->iteration + ($citas->currentPage() - 1) * $citas->perPage() }}
                    </td>

                    <td>
                        {{ $cita->cliente->paterno ?? '' }}
                        {{ $cita->cliente->materno ?? '' }},
                        {{ $cita->cliente->nombres ?? 'Sin asignar' }}
                    </td>

                    <td>
                        {{ $cita->empleado->paterno ?? '' }}
                        {{ $cita->empleado->materno ?? '' }},
                        {{ $cita->empleado->nombres ?? 'Sin asignar' }}
                    </td>

                    <td>{{ $cita->titulo ?? '---' }}</td>

                    <td>{{ $cita->asunto ?? '---' }}</td>

                    <td>
                        @if($cita->fecha_hora_cita)
                            {{ \Carbon\Carbon::parse($cita->fecha_hora_cita)->format('d/m/Y H:i') }}
                        @else
                            ---
                        @endif
                    </td>

                    <td>
                        <span class="badge badge- px-3 py-2">
                            {{ strtoupper($cita->estado_cita ?? '---') }}
                        </span>
                    </td>

                    <td>
                        <div class="btn-group">
                            
                            <button type="button"
                                    class="btn btn-info btn-sm dropdown-toggle"
                                    data-toggle="dropdown"
                                    aria-expanded="false">
                                Acciones
                            </button>

                            <div class="dropdown-menu dropdown-menu-right">

                                <a class="dropdown-item text-info"
                                   href="{{ route('citas.show', $cita->id) }}">
                                    <i class="fas fa-eye"></i> Ver Detalle
                                </a>

                                <a class="dropdown-item text-primary"
                                   href="{{ route('citas.edit', $cita->id) }}">
                                    <i class="fas fa-edit"></i> Editar
                                </a>

                                <div class="dropdown-divider"></div>

                                <form action="{{ route('citas.destroy', $cita->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('¿Seguro que deseas eliminar esta cita?');">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-trash-alt"></i> Eliminar
                                    </button>

                                </form>

                            </div>
                        </div>
                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="8" class="text-center text-muted">
                        No hay citas registradas.
                    </td>
                </tr>

            @endforelse
        </tbody>

    </table>
</div>

<div class="d-flex justify-content-between align-items-center mt-3 flex-wrap">

    <div class="text-muted mb-2">
        Mostrando
        {{ $citas->firstItem() ?? 0 }}
        a
        {{ $citas->lastItem() ?? 0 }}
        de
        {{ $citas->total() }}
        registros
    </div>

    <div>
        {{ $citas->appends(request()->query())->links('pagination::bootstrap-4') }}
    </div>

</div>