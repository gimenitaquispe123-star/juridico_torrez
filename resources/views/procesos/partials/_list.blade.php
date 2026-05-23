<div class="card">

    <div class="card-header d-flex justify-content-between align-items-center">
    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table id="tablaProcesos" class="table table-bordered table-striped table-hover align-middle text-center">

                <thead class="bg-light text-primary">
                    <tr>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Nombre Proceso</th>
                        <th>Tipo Proceso</th>
                        <th>Estado</th>
                        <th>Abogado Asignado</th>
                        <th width="120">Acciones</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse ($procesos as $proceso)

                        <tr>
                            <td>{{ $proceso->id }}</td>

                            <td>{{ $proceso->cliente->nombres ?? 'Sin asignar' }}</td>

                            <td>{{ $proceso->proceso }}</td>

                            <td>{{ $proceso->tipoProceso->tipo_proceso ?? '-' }}</td>

                            <td>{{ $proceso->estadoProceso->estado_proceso ?? '-' }}</td>

                            <td>
                                @if($proceso->expediente && $proceso->expediente->abogadoAsignado)
                                    {{ $proceso->expediente->abogadoAsignado->empleado->nombres ?? '' }}
                                    {{ $proceso->expediente->abogadoAsignado->empleado->paterno ?? '' }}
                                @else
                                    <span class="text-danger">Sin abogado</span>
                                @endif
                            </td>

                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-info btn-sm dropdown-toggle"
                                            type="button"
                                            data-toggle="dropdown"
                                            aria-haspopup="true"
                                            aria-expanded="false">
                                        Opciones
                                    </button>

                                    <div class="dropdown-menu dropdown-menu-right">

                                        <a href="{{ route('procesos.show',$proceso->id) }}" class="dropdown-item">
                                            <i class="fas fa-eye"></i> Ver
                                        </a>

                                        <a href="{{ route('procesos_seguimiento.index',['proceso_id'=>$proceso->id]) }}" class="dropdown-item">
                                            <i class="fas fa-list"></i> Seguimiento
                                        </a>

                                        <a href="{{ route('procesos.edit',$proceso->id) }}" class="dropdown-item">
                                            <i class="fas fa-edit"></i> Editar
                                        </a>

                                        <form action="{{ route('procesos.destroy',$proceso->id) }}" method="POST"
                                              onsubmit="return confirm('¿Seguro que deseas eliminar este proceso?')">

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
                        {{-- IMPORTANTE: no poner colspan --}}
                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

{{-- JS --}}
@section('js')

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

<script>
$(document).ready(function(){

    $('#tablaProcesos').DataTable({

        language:{
            url:'//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',
            emptyTable: "No hay procesos registrados"
        },

        responsive:true,

        pageLength:5,

        lengthMenu:[
            [5,10,15,25,50,100],
            [5,10,15,25,50,100]
        ],

        order:[[0,'asc']]

    });

});
</script>

@stop

{{-- CSS --}}
@section('css')

<link rel="stylesheet"
href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">

<style>
table, th, td{
    font-family: Georgia, serif;
}
</style>

@stop