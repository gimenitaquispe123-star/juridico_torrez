@extends('adminlte::page')

@section('title', 'Editar Cita')

@section('content_header')
    <h1 style="font-family: Georgia, 'Times New Roman', serif;">
    <i class=""></i> Editar Cita
</h1>

@stop

@section('content')
<div class="card shadow-lg">
    <div class="card-body">
        <form action="{{ route('citas.update', $cita->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row g-3">
                <div class="col-md-6">
                    <label>Cliente</label>
                    <select name="id_cliente" class="form-select rounded-4" required>
                        <option value="">Seleccione cliente</option>
                        @foreach($clientes as $cliente)
                            <option value="{{ $cliente->id }}" {{ $cita->id_cliente == $cliente->id ? 'selected' : '' }}>
                                {{ $cliente->nombres }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label>Empleado</label>
                    <select name="id_empleado" class="form-select rounded-4" required>
                        <option value="">Seleccione empleado</option>
                        @foreach($empleados as $empleado)
                            <option value="{{ $empleado->id }}" {{ $cita->id_empleado == $empleado->id ? 'selected' : '' }}>
                                {{ $empleado->nombres }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label>Título</label>
                    <input type="text" name="titulo" value="{{ $cita->titulo }}" class="form-control rounded-4" required>
                </div>

                <div class="col-md-6">
                    <label>Asunto</label>
                    <input type="text" name="asunto" value="{{ $cita->asunto }}" class="form-control rounded-4" required>
                </div>

                <div class="col-md-6">
                    <label>Fecha y hora</label>
                    <input type="datetime-local" name="fecha_hora_cita" 
                           value="{{ \Carbon\Carbon::parse($cita->fecha_hora_cita)->format('Y-m-d\TH:i') }}" 
                           class="form-control rounded-4" required>
                </div>

                <div class="col-md-6">
                    <label>Lugar</label>
                    <input type="text" name="lugar_cita" value="{{ $cita->lugar_cita }}" class="form-control rounded-4">
                </div>

                <div class="col-md-6">
                    <label>Estado de la Cita</label>
                    <select name="estado_cita" class="form-select rounded-4">
    <option value="Pendiente" @selected($cita->estado_cita == 'Pendiente')>Pendiente</option>
    <option value="Confirmada" @selected($cita->estado_cita == 'Confirmada')>Confirmada</option>
    <option value="Cancelada" @selected($cita->estado_cita == 'Cancelada')>Cancelada</option>
</select>
                </div>

                

                <div class="col-12">
                    <label>Mensaje</label>
                    <textarea name="mensaje" class="form-control rounded-4" rows="3">{{ $cita->mensaje }}</textarea>
                </div>
            </div>

            <div class="text-end mt-4">
                <a href="{{ route('citas.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Volver</a>
                <button type="submit" class="btn btn-info"><i class="fas fa-save"></i> Actualizar</button>
            </div>
        </form>
    </div>
</div>
@stop
