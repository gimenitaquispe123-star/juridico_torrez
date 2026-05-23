@extends('adminlte::page')

@section('title', 'Gestión de Citas')

@section('content_header')
   <h1 style="font-family: Georgia, serif;">Agenda</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header p-0 border-bottom-0">
        <ul class="nav nav-tabs" id="citaTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="listado-tab" data-bs-toggle="tab" href="#listado" role="tab"
                   aria-controls="listado" aria-selected="true">
                    <i class="fas fa-folder-open"></i> Lista de Citas
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" id="calendario-tab" data-bs-toggle="tab" href="#calendario" role="tab"
                   aria-controls="calendario" aria-selected="false">
                    <i class="fas fa-calendar-alt"></i> Calendario
                </a>
            </li>
        </ul>
    </div>

    <div class="card-body">
        <div class="tab-content" id="citaTabsContent">
            
            <div class="tab-pane fade show active" id="listado" role="tabpanel" aria-labelledby="listado-tab">
                @include('citas.partials._list')
            </div>

            <div class="tab-pane fade" id="calendario" role="tabpanel" aria-labelledby="calendario-tab">
                {{-- Pasamos $events al partial --}}
                @include('citas.partials._calendario', ['events' => $events])
            </div>

        </div>
    </div>
</div>
@stop

@section('css')
    {{-- CSS adicional si necesitas --}}
@stop

@section('js')
<script>
    console.log('Módulo Citas cargado correctamente');
</script>
@stop
