@extends('adminlte::page')

@section('title', 'Gestión Procesal')

@section('content_header')
   <h1 style="font-family: Georgia, serif;">Procesos</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header p-0 border-bottom-0">
        <ul class="nav nav-tabs d-flex align-items-center" id="procesoTabs" role="tablist">
            
            <li class="nav-item">
                <a class="nav-link active" id="listado-tab" data-toggle="tab" href="#listado" role="tab">
                    <i class="fas fa-folder-open"></i> Lista de Procesos
                </a>
            </li>

            <li class="nav-item d-flex align-items-center">
                <a class="nav-link" id="nuevo-tab" data-toggle="tab" href="#nuevo" role="tab">
                    <i class="fas fa-plus-circle mr-1"></i> Nuevo / Editar Proceso
                </a>
  @can('imprimir proceso')
                <button class="btn  " data-toggle="modal" data-target="#modalPdfProcesos">
                    <i class="fas fa-file-pdf"> Imprimir pdf</i>
                </button>
                  @endcan
            </li>

        </ul>
    </div>

    <div class="card-body">
        <div class="tab-content" id="procesoTabsContent">
            
            <div class="tab-pane fade show active" id="listado" role="tabpanel">
                @include('procesos.partials._list')
            </div>

            <div class="tab-pane fade" id="nuevo" role="tabpanel">
                @include('procesos.partials._create')
            </div>

            <div class="tab-pane fade" id="detalle" role="tabpanel">
            </div>

        </div>
    </div>
</div>

{{-- ================= MODAL PDF ================= --}}
<div class="modal fade" id="modalPdfProcesos" tabindex="-1">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">Exportar Procesos PDF</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>

            <form method="GET" action="{{ route('procesos.pdfVista') }}" target="_blank">
                <div class="modal-body">
                    
                    <div class="form-group">
                        <label>Mes</label>
                        <input type="number" name="mes" class="form-control" min="1" max="12">
                    </div>

                    <div class="form-group">
                        <label>Año</label>
                        <input type="number" name="anio" class="form-control">
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button class="btn btn-danger">Generar PDF</button>
                </div>
            </form>

        </div>
    </div>
</div>

@stop

@section('css')
@stop

@section('js')
<script>
    console.log('Módulo Procesos cargado correctamente');
</script>
@stop