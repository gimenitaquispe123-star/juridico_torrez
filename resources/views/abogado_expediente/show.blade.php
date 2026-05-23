@extends('adminlte::page')

@section('title', 'Detalle de Asignación de Abogado')

@section('content_header')

<h1 style="font-family: Georgia, serif;">Detalle de Asignación de Abogado</h1>
@stop

@section('content')



<div class="card-body">

    {{-- FILA 1 --}}
    <div class="row mb-3">

        <div class="col-md-3">
            <strong>Expediente</strong>
            <p>{{ $abogado->expediente->codigo_expediente ?? '-' }}</p>
        </div>

        <div class="col-md-3">
            <strong>Abogado</strong>
            <p>
                {{ $abogado->empleado->nombres ?? '' }}
                {{ $abogado->empleado->paterno ?? '' }}
                {{ $abogado->empleado->materno ?? '' }}
            </p>
        </div>

        <div class="col-md-3">
            <strong>Fecha Asignación</strong>
            <p>
                {{ $abogado->fecha_asignacion 
                    ? \Carbon\Carbon::parse($abogado->fecha_asignacion)->format('d/m/Y') 
                    : '-' }}
            </p>
        </div>

        <div class="col-md-3">
            <strong>Fecha Desvinculación</strong>
            <p>
                {{ $abogado->fecha_desvinculacion 
                    ? \Carbon\Carbon::parse($abogado->fecha_desvinculacion)->format('d/m/Y') 
                    : '-' }}
            </p>
        </div>

    </div>


    {{-- FILA 2 --}}
    <div class="row mb-3">

        <div class="col-md-3">
            <strong>Observación</strong>
            <p>{{ $abogado->observacion ?? '-' }}</p>
        </div>

        <div class="col-md-3">
            <strong>Estado</strong>
            <p>
                @if ($abogado->estado)
                    <span class="badge bg-success">Activo</span>
                @else
                    <span class="badge bg-danger">Inactivo</span>
                @endif
            </p>
        </div>

        <div class="col-md-3">
            <strong>Usuario Registro</strong>
            <p>{{ $abogado->usuarioReg->usuario ?? '-' }}</p>
        </div>

        <div class="col-md-3">
            <strong>Usuario Modificación</strong>
            <p>{{ $abogado->usuarioMod->usuario ?? '-' }}</p>
        </div>

    </div>


    {{-- FILA 3 --}}
    <div class="row mb-3">

        <div class="col-md-3">
            <strong>Fecha Registro</strong>
            <p>
                {{ $abogado->registro 
                    ? \Carbon\Carbon::parse($abogado->registro)->format('d/m/Y H:i') 
                    : '-' }}
            </p>
        </div>

        <div class="col-md-3">
            <strong>Fecha Modificación</strong>
            <p>
                {{ $abogado->modificado 
                    ? \Carbon\Carbon::parse($abogado->modificado)->format('d/m/Y H:i') 
                    : '-' }}
            </p>
        </div>

    </div>


    {{-- HISTORIAL DE ABOGADOS --}}
    <hr>

    <h4><i class="fas fa-history"></i> Historial de Abogados del Expediente</h4>

    @php
    $historial = \App\Models\AbogadoExpediente::where('id_expediente', $abogado->id_expediente)
                    ->orderBy('fecha_asignacion')
                    ->get();
    @endphp

    <div class="row mt-3">

    @forelse($historial as $registro)

        <div class="col-md-3">

            <div class="card border-primary shadow-sm">

                <div class="card-body">

                    <strong>Abogado</strong>
                    <p>
                        {{ $registro->empleado->nombres ?? '' }}
                        {{ $registro->empleado->paterno ?? '' }}
                        {{ $registro->empleado->materno ?? '' }}
                    </p>

                    <strong>Asignación</strong>
                    <p>
                        {{ $registro->fecha_asignacion 
                            ? \Carbon\Carbon::parse($registro->fecha_asignacion)->format('d/m/Y') 
                            : '-' }}
                    </p>

                    <strong>Desvinculación</strong>
                    <p>
                        {{ $registro->fecha_desvinculacion 
                            ? \Carbon\Carbon::parse($registro->fecha_desvinculacion)->format('d/m/Y') 
                            : '-' }}
                    </p>

                    <strong>Estado</strong>
                    <p>
                        @if($registro->estado)
                            <span class="badge bg-success">Activo</span>
                        @else
                            <span class="badge bg-danger">Inactivo</span>
                        @endif
                    </p>

                </div>

            </div>

        </div>

    @empty

        <div class="col-md-12 text-center">
            No hay historial de abogados para este expediente
        </div>

    @endforelse

    </div>


    <div class="mt-3">

        <a href="{{ route('expediente.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver
        </a>

        <a href="{{ route('abogado_expediente.edit', $abogado->id) }}" class="btn btn-info">
            <i class="fas fa-edit"></i> Editar
        </a>

    </div>

</div>
```

</div>

@stop
