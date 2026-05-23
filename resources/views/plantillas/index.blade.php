@extends('adminlte::page')

@section('title', 'Gestión de Plantillas')

@section('content_header')
<h5 class="text-dark font-weight-bold" style="font-family: Georgia, 'Times New Roman', Times, serif;">
    <i class="fas fa-file-word"></i> Gestión de Plantillas
</h5>
@stop

@section('content')
<div class="card shadow-lg">

    <div class="card-header p-2">
        <ul class="nav nav-tabs" id="plantillaTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="tab-tipos" data-toggle="tab" href="#tipos" role="tab">
                    <i class="fas fa-layer-group"></i> Tipos de Plantilla
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tab-plantillas" data-toggle="tab" href="#plantillas" role="tab">
                    <i class="fas fa-file-alt"></i> Plantillas
                </a>
            </li>
            <li class="nav-item ml-auto">
                <a href="{{ route('tipo_plantilla.create') }}" class="btn btn-orange btn-sm">
                    <i class="fas fa-plus-circle"></i> Nuevo / Tipo plantilla 
                </a>
            </li>       
        </ul>
    </div>

    <div class="card-body tab-content">
        <div class="tab-pane fade show active" id="tipos" role="tabpanel">
            @include('plantillas.partials._tipos')
        </div>

        <div class="tab-pane fade" id="plantillas" role="tabpanel">
            @include('plantillas.partials._plantillas')
        </div>
    </div>

</div>
@stop

@section('css')
<style>
    .btn-dark { background-color: #080808ff; color: #fff; font-weight: 600; }
    .btn-dark:hover { background-color: #080808ff; color: #fff; }
    .table th, .table td { vertical-align: middle !important; }
</style>
@stop

@section('js')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

<script>
$(document).ready(function(){

    // destruir si ya existe (evita errores)
    if ($.fn.DataTable.isDataTable('#tablaPlantillas')) {
        $('#tablaPlantillas').DataTable().destroy();
    }

    $('#tablaPlantillas').DataTable({
        paging: false,
        lengthChange: false,
        searching: false,
        ordering: true,
        info: false,
        autoWidth: false,
        columnDefs: [
            { orderable: false, targets: 6 }
        ],
        language: {
            url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json",
            emptyTable: "No se encontraron registros."
        }
    });

});
</script>
@stop