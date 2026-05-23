<div class="table-responsive">

    <table id="tablaExpedientes"
        class="table table-hover text-center align-middle">

        <thead class="table-light">

            <tr>
                <th>IDENTIFICACIÓN</th>
                <th>Expediente N°</th>
                <th>Cliente</th>
                <th>Usuario Asignado</th>
                <th>Estado</th>
                <th>Fecha Registro</th>
                <th>Modificado por</th>
                <th style="width: 280px;">Acciones</th>
            </tr>

        </thead>

        <tbody>

            @foreach($expedientes as $expediente)

                <tr>

                    <td>
                        {{ $expediente->codigo_expediente ?? '---' }}
                    </td>

                    <td>
                        {{ $expediente->nro_expediente ?? '---' }}
                    </td>

                    <td>
                        {{ $expediente->cliente->nombre ?? '---' }}
                    </td>

                    <td>
                        {{ $expediente->usuarioMod?->usuario ?? 'Sin asignar' }}
                    </td>

                    <td>

                        <span class="badge border text-dark">
                            {{ strtoupper($expediente->estado_expediente ?? '---') }}
                        </span>

                    </td>

                    <td>
                        {{ \Carbon\Carbon::parse($expediente->registrado)->format('d/m/Y H:i') }}
                    </td>

                    <td>
                        {{ $expediente->usuarioReg->usuario ?? '---' }}
                    </td>

                    <td>

                        <div class="d-flex justify-content-center gap-1 flex-wrap">

                            <a class="btn btn-outline-dark btn-sm ver-detalle-expediente"
                                href="#"
                                data-id="{{ $expediente->id }}">

                                <i class="fas fa-eye"></i> Ver

                            </a>

                            <a href="{{ route('expedientes.edit', $expediente->id_expediente) }}"
                                class="btn btn-outline-info btn-sm">

                                <i class="fas fa-edit"></i> Editar

                            </a>

                            <form action="{{ route('expedientes.destroy', $expediente->id_expediente) }}"
                                method="POST"
                                style="display:inline-block;">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                    class="btn btn-outline-danger btn-sm"
                                    onclick="return confirm('¿Seguro que deseas eliminar este expediente?')">

                                    <i class="fas fa-trash-alt"></i> Eliminar

                                </button>

                            </form>

                        </div>

                    </td>

                </tr>

            @endforeach

        </tbody>

    </table>

</div>

<div class="d-flex justify-content-center mt-3">
    {{ $expedientes->links() }}
</div>

{{-- DataTables --}}
<script>

$(function () {

    $('#tablaExpedientes').DataTable({

        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',
            search: "Buscar:",
            lengthMenu: "Mostrar _MENU_ registros"
        },

        responsive: true,

        pageLength: 5,

        lengthMenu: [
            [5, 10, 25, 50, 100],
            [5, 10, 25, 50, 100]
        ],

        autoWidth: false

    });

});

</script>

<style>

/* TABLA */
#tablaExpedientes{
    width: 100%;
    border-collapse: separate !important;
    border-spacing: 0;
    background: white;
}

/* QUITAR RAYAS NEGRAS */
#tablaExpedientes,
#tablaExpedientes th,
#tablaExpedientes td{
    border: none !important;
}

/* ENCABEZADO */
#tablaExpedientes thead th{
    background: #f8f9fa !important;
    color: #000;
    padding: 14px;
    font-family: Georgia, serif;
    font-size: 13px;
    text-transform: uppercase;
    font-weight: bold;
}


#tablaExpedientes tbody tr{
    border-bottom: 1px solid #ffffff !important;
    transition: 0.2s ease;
}

#tablaExpedientes tbody tr:hover{
    background: #f9f9f9;
}

#tablaExpedientes tbody td{
    padding: 14px;
    font-family: Georgia, serif;
    color: #222;
    vertical-align: middle;
}

.badge{
    background: transparent !important;
    padding: 7px 14px;
    border-radius: 30px;
}

.btn{
    border-radius: 10px;
}

/* BUSCADOR */
.dataTables_filter input{
    border-radius: 10px !important;
    border: 1px solid #ddd !important;
    padding: 5px 10px !important;
}

/* SELECT MOSTRAR */
.dataTables_length select{
    border-radius: 10px !important;
    border: 1px solid #ddd !important;
}

/* PAGINACIÓN */
.dataTables_wrapper .dataTables_paginate .paginate_button{
    border-radius: 8px !important;
    margin: 2px;
}

/* TEXTO */
.dataTables_info,
.dataTables_length,
.dataTables_filter{
    font-family: Georgia, serif;
}

</style>