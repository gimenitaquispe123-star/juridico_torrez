@extends('adminlte::page')

@section('title', 'Nuevo Seguimiento de Proceso')

@section('content_header')
<h1 class="text-dark" style="font-family: Georgia, serif; font-weight: 800;">
    Nuevo Seguimiento de Proceso
</h1>
@stop

@section('content')

<div class="card shadow-lg">
    <div class="card-body">

        <form action="{{ route('procesos_seguimiento.store') }}" method="POST">
            @csrf

            <div class="row">

                @if($proceso)
                    <input type="hidden" name="id_proceso" value="{{ $proceso->id }}">
                @else
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Proceso</label>

                        <select name="id_proceso" id="id_proceso"
                            class="form-control select2 @error('id_proceso') is-invalid @enderror" required>

                            <option value="">Seleccione un proceso</option>

                            @foreach($procesos as $p)
                            <option value="{{ $p->id }}" {{ old('id_proceso') == $p->id ? 'selected' : '' }}>
                                {{ $p->proceso }}
                            </option>
                            @endforeach

                        </select>

                        @error('id_proceso')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror

                    </div>
                </div>
                @endif

                <div class="col-md-4">
                    <div class="form-group">

                        <label>Fecha</label>

                        <input type="date"
                            name="fecha"
                            id="fecha"
                            class="form-control @error('fecha') is-invalid @enderror"
                            value="{{ old('fecha', date('Y-m-d')) }}"
                            required>

                        @error('fecha')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror

                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">

                        <label>Etapa</label>

                        <input type="text"
                            name="etapa"
                            class="form-control"
                            value="{{ old('etapa') }}"
                            placeholder="Ej: Demanda, Admisión, Notificación">

                    </div>
                </div>

            </div>


            <div class="row">

                {{-- ACCION --}}
                <div class="col-md-4">
                    <div class="form-group">

                        <label>Acción</label>

                        <input type="text"
                            name="accion"
                            class="form-control"
                            value="{{ old('accion') }}"
                            placeholder="Acción realizada">

                    </div>
                </div>


                <div class="col-md-4">
                    <div class="form-group">

                        <label>Cliente</label>

                        <select name="id_cliente"
                            id="id_cliente"
                            class="form-control select2">

                            <option value="">Seleccione cliente...</option>

                            @foreach ($clientes as $cliente)

                            <option value="{{ $cliente->id }}"
                                {{ old('id_cliente') == $cliente->id ? 'selected' : '' }}>

                                {{ $cliente->nombres }}
{{ $cliente->paterno }}
{{ $cliente->materno }}

                            </option>

                            @endforeach

                        </select>

                    </div>
                </div>


                {{-- DIAS PLAZO --}}
                <div class="col-md-4">
                    <div class="form-group">

                        <label>Días de Plazo</label>

                        <input type="number"
                            name="dias_plazo"
                            id="dias_plazo"
                            class="form-control"
                            placeholder="Ej: 3, 5, 10">

                    </div>
                </div>

            </div>


            <div class="row">

                {{-- FECHA VENCIMIENTO --}}
                <div class="col-md-4">
                    <div class="form-group">

                        <label>Fecha de Vencimiento</label>

                        <input type="date"
                            id="fecha_vencimiento"
                            class="form-control"
                            readonly>

                    </div>
                </div>

            </div>


            {{-- OBSERVACIONES --}}
            <div class="row">

                <div class="col-md-12">

                    <div class="form-group">

                        <label>Observaciones</label>

                        <textarea name="observaciones"
                            rows="3"
                            class="form-control"
                            placeholder="Notas o comentarios">{{ old('observaciones') }}</textarea>

                    </div>

                </div>

            </div>


            {{-- BOTONES --}}
            <div class="mt-3">

                <a href="{{ route('procesos_seguimiento.index', $proceso ? ['proceso_id' => $proceso->id] : []) }}"
                    class="btn btn-secondary">

                    <i class="fas fa-arrow-left"></i> Volver

                </a>

                <button type="submit" class="btn btn-info">

                    <i class="fas fa-save"></i> Registrar

                </button>

            </div>

        </form>

    </div>
</div>

@stop


@section('js')

<script>

$(document).ready(function(){

    $('.select2').select2({
        theme:'bootstrap4',
        width:'100%'
    });


    $('#dias_plazo, #fecha').on('change', function(){

        let fecha = $('#fecha').val();
        let dias = $('#dias_plazo').val();

        if(fecha && dias){

            let fechaBase = new Date(fecha);

            fechaBase.setDate(fechaBase.getDate() + parseInt(dias));

            let yyyy = fechaBase.getFullYear();
            let mm = ('0' + (fechaBase.getMonth()+1)).slice(-2);
            let dd = ('0' + fechaBase.getDate()).slice(-2);

            $('#fecha_vencimiento').val(yyyy+'-'+mm+'-'+dd);

        }

    });

});

</script>

@stop