@extends('adminlte::page')

@section('title', 'Crear Usuario')

@section('content_header')
<h1>Crear Nuevo Usuario</h1>
@stop

@section('content')

@if($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="card">
    <div class="card-body">
        <form action="{{ route('usuarios.store') }}" method="POST">
            @csrf

            <div class="row">
                <!-- Persona -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="persona_id">Persona</label>
                        <select name="persona_id" class="form-control" required>
                            <option value="">-- Seleccionar Persona --</option>
                            @foreach($personas as $persona)
                                <option value="{{ $persona->id }}" {{ old('persona_id') == $persona->id ? 'selected' : '' }}>
                                    {{ $persona->nombre_completo }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Usuario -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="usuario">Usuario (CI)</label>
                        <input type="text" name="usuario" class="form-control" value="{{ old('usuario') }}" required>
                    </div>
                </div>
            </div>

            <div class="row mt-2">
                <!-- Email -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email">Correo Electrónico</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                    </div>
                </div>

                <!-- Contraseña -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="password">Contraseña (Opcional)</label>
                        <input type="text" name="password" class="form-control" value="{{ old('password') }}">
                        <small class="form-text text-muted">Si no se ingresa, se generará automáticamente.</small>
                    </div>
                </div>
            </div>

            <div class="row mt-2">
                <!-- Estado -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="estado">Estado</label>
                        <select name="estado" class="form-control" required>
                            <option value="activo" {{ old('estado') == 'activo' ? 'selected' : '' }}>Activo</option>
                            <option value="inactivo" {{ old('estado') == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                        </select>
                    </div>
                </div>

                <!-- Rol -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="rol">Asignar Rol</label>
                        <select name="rol" class="form-control" required>
                            <option value="">-- Seleccionar Rol --</option>
                            @foreach($roles as $role)
                               <option value="{{ $role->name }}" {{ old('rol') == $role->name ? 'selected' : '' }}>
    {{ ucfirst($role->name) }} <!-- Esto es solo para mostrar con mayúscula, no cambia el valor -->
</option>

                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-12 text-right">
                    <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Guardar Usuario</button>
                </div>
            </div>

        </form>
    </div>
</div>

@stop
