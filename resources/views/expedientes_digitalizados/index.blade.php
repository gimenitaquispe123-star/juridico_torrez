@extends('adminlte::page')

@section('title', 'Expedientes Digitalizados')

@section('content_header')
    <h3 style="font-family: Georgia, serif;">Expedientes Digitalizados</h3>
@stop

@section('content')
<div class="card shadow-sm">
    <div class="card-header p-2 border-bottom-0">
        <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="tab-lista" data-toggle="tab" href="#lista" role="tab" 
                   aria-controls="lista" aria-selected="true">
                    <i class="fas fa-folder-open"></i> Expedientes Digitalizados
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tab-crear" data-toggle="tab" href="#crear" role="tab" 
                   aria-controls="crear" aria-selected="false">
                    <i class="fas fa-file-upload"></i> Digitalizar Expediente
                </a>
            </li>
        </ul>
    </div>

    <div class="card-body">
        <div class="tab-content" id="custom-tabs-one-tabContent">
            <div class="tab-pane fade show active" id="lista" role="tabpanel" aria-labelledby="tab-lista">
                @include('expedientes_digitalizados.partials.lista')
            </div>
            <div class="tab-pane fade" id="crear" role="tabpanel" aria-labelledby="tab-crear">
                @include('expedientes_digitalizados.partials.crear')
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
<style>
.nav-tabs .nav-link.active {
    background-color:;
    color: black !important;
    border-color: #dee2e6 #dee2e6 #fff;
}
.table th, .table td {
    vertical-align: middle;
    text-align: center;
}
</style>
@stop

@section('js')
<script>
    document.getElementById('busqueda').addEventListener('keyup', function() {
        let filtro = this.value.toLowerCase();
        document.querySelectorAll('#tablaDigitalizados tbody tr').forEach(tr => {
            tr.style.display = tr.textContent.toLowerCase().includes(filtro) ? '' : 'none';
        });
    });
</script>
@stop

