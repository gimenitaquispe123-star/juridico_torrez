@extends('adminlte::page')

@section('title', 'Editar Cliente')

@section('content_header')
    <h1 class="text-dark" style="font-family: Georgia, serif; font-weight: 800;">
        Editar Cliente
    </h1>
@stop

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>¡Atención!</strong> Hay errores en el formulario.<br><br>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-lg border-0">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0"><i class="fas fa-user-edit"></i> Actualizar Datos del Cliente</h5>
        </div>

        <form action="{{ route('clientes.update', $cliente->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="nombres">Nombres</label>
                        <input type="text" name="nombres" id="nombres"
                               class="form-control @error('nombres') is-invalid @enderror"
                               value="{{ old('nombres', $cliente->nombres) }}" required>
                        @error('nombres')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label for="paterno">Apellido Paterno</label>
                        <input type="text" name="paterno" id="paterno" class="form-control"
                               value="{{ old('paterno', $cliente->paterno) }}">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="materno">Apellido Materno</label>
                        <input type="text" name="materno" id="materno" class="form-control"
                               value="{{ old('materno', $cliente->materno) }}">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="ci">Cédula de Identidad</label>
                        <input type="text" name="ci" id="ci" class="form-control"
                               value="{{ old('ci', $cliente->ci) }}">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="ci_expedido">Expedido</label>
                        <input type="text" name="ci_expedido" id="ci_expedido" class="form-control"
                               value="{{ old('ci_expedido', $cliente->ci_expedido) }}">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="celular">Celular</label>
                        <input type="text" name="celular" id="celular" class="form-control"
                               value="{{ old('celular', $cliente->celular) }}">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="direccion">Dirección</label>
                        <input type="text" name="direccion" id="direccion" class="form-control"
                               value="{{ old('direccion', $cliente->direccion) }}">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="email">Correo Electrónico</label>
                        <input type="email" name="email" id="email" class="form-control"
                               value="{{ old('email', $cliente->email) }}">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                        <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control"
                               value="{{ old('fecha_nacimiento', $cliente->fecha_nacimiento) }}">
                    </div>

                </div>
            </div>

            <div class="card-footer d-flex justify-content-center">
                <a href="{{ route('clientes.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
                <button type="submit" class="btn btn-info">
                    <i class="fas fa-save"></i> Actualizar
                </button>
            </div>
        </form>
    </div>
@stop
