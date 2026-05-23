@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1 style="font-family: Georgia, serif;">Dashboard</h1>
@stop

@section('content')

{{-- ALERTAS DE CITAS DEL DÍA --}}
@php
    use Carbon\Carbon;
    $personaId = auth()->user()->persona_id ?? null;
    $citasHoy = \App\Models\Cita::where('id_empleado', $personaId)
                    ->whereDate('fecha_hora_cita', today())
                    ->get();
@endphp

@if($citasHoy->count() > 0)
<div class="row mt-3">
    <div class="col-12">
        @foreach($citasHoy as $cita)
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Alerta:</strong> Tienes una cita hoy: <strong>{{ $cita->titulo }}</strong>
                a las <strong>{{ Carbon::parse($cita->fecha_hora_cita)->format('H:i') }}</strong>.
                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
        @endforeach
    </div>
</div>
@endif

{{-- PRIMER BLOQUE --}}
<div class="row">

    @can('ver clientes')
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $clientesCount ?? 0 }}</h3>
                <p>Clientes</p>
            </div>
            <div class="icon"><i class="fas fa-users"></i></div>
            <a href="{{ route('clientes.index') }}" class="small-box-footer">
                Más información <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    @endcan

    @can('ver empleados')
    <div class="col-lg-3 col-6">
        <div class="small-box bg-primary">
            <div class="inner">
                <h3>{{ $empleadosCount ?? 0 }}</h3>
                <p>Empleados</p>
            </div>
            <div class="icon"><i class="fas fa-user-tie"></i></div>
            <a href="{{ route('empleados.index') }}" class="small-box-footer">
                Más información <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    @endcan

    @can('ver procesos')
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $procesosCount ?? 0 }}</h3>
                <p>Procesos</p>
            </div>
            <div class="icon"><i class="fas fa-tasks"></i></div>
            <a href="{{ route('procesos.index') }}" class="small-box-footer">
                Más información <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    @endcan

    @can('ver procesos')
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $procesosTerminadosCount ?? 0 }}</h3>
                <p>Procesos Terminados</p>
            </div>
            <div class="icon"><i class="fas fa-check-circle"></i></div>
            <a href="{{ route('procesos.index') }}" class="small-box-footer">
                Ver más <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    @endcan

</div>

{{-- SEGUNDO BLOQUE --}}
<div class="row">

    @can('ver expedientes')
    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $expedientesCount ?? 0 }}</h3>
                <p>Expedientes</p>
            </div>
            <div class="icon"><i class="fas fa-folder"></i></div>
            <a href="{{ route('expedientes.index') }}" class="small-box-footer">
                Más información <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    @endcan

    @can('ver cuentas')
    <div class="col-lg-3 col-6">
        <div class="small-box bg-white">
            <div class="inner text-dark">
                <h3>Cuentas</h3> 
                <p>Pagos</p>
            </div>
            <div class="icon"><i class="fas fa-credit-card text-dark"></i></div>
            <a href="{{ route('pagos.index') }}" class="small-box-footer text-dark">
                Más información <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    @endcan

    @can('ver agenda')
    <div class="col-lg-3 col-6">
        <div class="small-box bg-secondary">
            <div class="inner">
                <h3>Agenda</h3>
                <p>Agenda</p>
            </div>
            <div class="icon"><i class="fas fa-book"></i></div>
            <a href="{{ route('citas.index') }}" class="small-box-footer">
                Más información <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    @endcan

    @can('ver plantillas')
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>+</h3>
                <p>Plantillas</p>
            </div>
            <div class="icon"><i class="fas fa-folder-open"></i></div>
            <a href="{{ route('plantillas.index') }}" class="small-box-footer">
                Más información <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    @endcan

</div>
{{-- ===================== --}}
{{-- TIPOS DE PROCESO (CLARO PARA ABOGADO) --}}
{{-- ===================== --}}
<div class="row mt-4">

    <div class="col-12">
        <div class="card shadow">

        <div class="card-header text-black" style="font-family: Georgia, serif;">
    <strong>Casos por Área Legal</strong>
</div>

            <div class="card-body">

                <div class="row">

                    @foreach($tiposProcesos as $i => $tipo)

                        @php
                            $nombre = strtolower($tipo);
                        @endphp

                        <div class="col-md-3 col-sm-6 mb-3">

                            <div class="info-box shadow-sm">

                                <span class="info-box-icon 
                                    @if(str_contains($nombre,'penal')) 
                                    @elseif(str_contains($nombre,'civil')) 
                                    @elseif(str_contains($nombre,'familia')) 
                                    @elseif(str_contains($nombre,'laboral')) 
                                    @else bg-info
                                    @endif
                                ">
                                    <i class="fas fa-balance-scale"></i>
                                </span>

                                <div class="info-box-content">

                                    <span class="info-box-text">
                                        {{ $tipo }}
                                    </span>

                                    <span class="info-box-number">
                                        {{ $cantidadProcesos[$i] ?? 0 }} casos
                                    </span>

                                </div>

                            </div>

                        </div>

                    @endforeach

                </div>

            </div>
        </div>
    </div>

</div>
{{-- ===================== --}}
{{-- GRÁFICAS --}}
{{-- ===================== --}}
<div class="row mt-4">

    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-info text-white">
                Procesos por Mes
            </div>
            <div class="card-body">
                <canvas id="procesosPorMesChart"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-info text-white">
                Estados de Procesos
            </div>
            <div class="card-body">
                <canvas id="estadosProcesosChart"></canvas>
            </div>
        </div>
    </div>

</div>

@stop

{{-- ===================== --}}
{{-- CSS --}}
{{-- ===================== --}}
@section('css')
<style>
.small-box {
    height: 140px;
    border-radius: 10px;
}
</style>
@stop

{{-- ===================== --}}
{{-- JS --}}
{{-- ===================== --}}
@section('js')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    new Chart(document.getElementById('procesosPorMesChart'), {
        type: 'bar',
        data: {
            labels: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
            datasets: [{
                label: 'Procesos',
                data: {!! json_encode($procesosMeses ?? []) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.6)'
            }]
        }
    });

    new Chart(document.getElementById('estadosProcesosChart'), {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($estados ?? []) !!},
            datasets: [{
                data: {!! json_encode($cantidadEstados ?? []) !!}
            }]
        }
    });

});
</script>

@endsection