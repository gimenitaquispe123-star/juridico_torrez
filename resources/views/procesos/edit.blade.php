@extends('adminlte::page')

@section('title', 'Editar Proceso')

@section('content_header')
    <h1 style="font-family: Georgia, serif;">Editar Proceso</h1>
@stop

@section('content')
<div class="card shadow">
    <div class="card-body">
        <form action="{{ route('procesos.update', $proceso->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="id_cliente">Cliente</label>
                        <select name="id_cliente" id="id_cliente" class="form-control select2" required>
                            <option value="">Seleccione...</option>
                            @foreach ($clientes as $cliente)
                                <option value="{{ $cliente->id }}" {{ $proceso->id_cliente == $cliente->id ? 'selected' : '' }}>
                                    {{ $cliente->nombres ?? $cliente->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="id_posicion">Posición del Cliente</label>
                        <select name="id_posicion" id="id_posicion" class="form-control" required>
                            <option value="">Seleccione...</option>
                            <option value="1" {{ $proceso->id_posicion == 1 ? 'selected' : '' }}>Demandante</option>
                            <option value="2" {{ $proceso->id_posicion == 2 ? 'selected' : '' }}>Demandado</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="contrario">Persona Contraria</label>
                        <input type="text" name="contrario" id="contrario" class="form-control" 
                               value="{{ $proceso->contrario }}" placeholder="Nombre de la persona contraria">
                    </div>
                </div>
            </div>

        
            <div class="row mt-2">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="estado_proceso">Estado del Proceso</label>
                        <select name="estado_proceso" id="estado_proceso" class="form-control select2">
                            <option value="">Seleccione estado...</option>
                            @foreach ($estados as $e)
                                <option value="{{ $e->id }}" {{ $proceso->estado_proceso == $e->id ? 'selected' : '' }}>
                                    {{ $e->estado_proceso }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="proceso">Nombre del Proceso</label>
                        <input type="text" name="proceso" id="proceso" class="form-control" 
                               value="{{ $proceso->proceso }}" required>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="tipo_proceso">Tipo de Proceso</label>
                        <select name="tipo_proceso" id="tipo_proceso" class="form-control select2" required>
                            <option value="">Seleccione tipo...</option>
                            @foreach ($tipos as $t)
                                <option value="{{ $t->id }}" {{ $proceso->tipo_proceso == $t->id ? 'selected' : '' }}>
                                    {{ $t->tipo_proceso }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-md-4">
                    <div class="form-group">
                        <input type="text" class="form-control"
            value="{{ $proceso->expediente && $proceso->expediente->abogadoAsignado
                ? $proceso->expediente->abogadoAsignado->empleado->nombres.' '.
                  $proceso->expediente->abogadoAsignado->empleado->paterno.' '.
                  $proceso->expediente->abogadoAsignado->empleado->materno
                : 'Sin abogado asignado' }}"
            readonly>

                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="fecha_inicio">Fecha de Inicio</label>
                        <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" 
                               value="{{ $proceso->fecha_inicio }}">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="estado">Estado General</label>
                        <select name="estado" id="estado" class="form-control" required>
                            <option value="Activo" {{ $proceso->estado == 'Activo' ? 'selected' : '' }}>Activo</option>
                            <option value="Concluido" {{ $proceso->estado == 'Concluido' ? 'selected' : '' }}>Concluido</option>
                            <option value="Archivado" {{ $proceso->estado == 'Archivado' ? 'selected' : '' }}>Archivado</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- FILA 4 --}}
            <div class="row mt-2">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="id_expediente">Expediente Asociado</label>
                        <select name="id_expediente" id="id_expediente" class="form-control select2" required>
                            <option value="">Seleccione expediente...</option>
                            @foreach($expedientes as $exp)
                                <option value="{{ $exp->id }}" {{ $proceso->id_expediente == $exp->id ? 'selected' : '' }}>
                                    {{ $exp->codigo_expediente ?? $exp->nro_expediente }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="involucrados">Personas Involucradas</label>
                        <textarea name="involucrados" id="involucrados" class="form-control" rows="2">{{ $proceso->involucrados }}</textarea>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="descripcion">Descripción del Proceso</label>
                        <textarea name="descripcion" id="descripcion" class="form-control" rows="2">{{ $proceso->descripcion }}</textarea>
                    </div>
                </div>
            </div>

            {{-- BOTONES --}}
            <div class="mt-4 text-end">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Actualizar
                </button>
                <a href="{{ route('procesos.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Cancelar
                </a>
            </div>
        </form>
    </div>


@section('js')
<script>
    $(document).ready(function() {
        $('.select2').select2({
            theme: 'bootstrap4'
        });
    });
</script>
@stop
@endsection