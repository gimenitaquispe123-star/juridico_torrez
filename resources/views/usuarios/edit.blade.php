@extends('adminlte::page')

@section('title', 'Editar Usuario')

@section('content')
<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h3 class="text-black" style="font-family: 'Georgia', serif;">
                Editar Usuario
            </h3>
            
        </div>
    </div>

    <form action="{{ route('usuarios.update', $usuario->id) }}" method="POST">
        @csrf
        @method('PUT')

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="form-row">
            <!-- Persona (solo lectura) -->
            <div class="form-group col-md-4">
                <label><strong>Persona</strong></label>
                <select class="form-control" disabled>
                    <option>
                        {{ $usuario->persona->nombres ?? '' }}
                        {{ $usuario->persona->paterno ?? '' }}
                        {{ $usuario->persona->materno ?? '' }}
                        (CI: {{ $usuario->persona->ci ?? '' }})
                    </option>
                </select>
                <input type="hidden" name="persona_id" value="{{ $usuario->persona_id }}">
            </div>

            <!-- Usuario -->
            <div class="form-group col-md-4">
                <label><strong>Usuario</strong></label>
                <input type="text" name="usuario" class="form-control" value="{{ $usuario->usuario }}" required>
            </div>

            <!-- Email -->
            <div class="form-group col-md-4">
                <label><strong>Email</strong></label>
                <input type="email" name="email" class="form-control" value="{{ $usuario->email }}" required>
            </div>
        </div>

        <div class="form-row mt-3">
            <!-- Nueva contraseña -->
            <div class="form-group col-md-6">
                <label><strong>Nueva Contraseña</strong></label>
                <div class="input-group">
                    <input type="password" name="password" class="form-control" id="password" placeholder="Deja vacío si no cambias">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                <small class="text-muted">Tu contraseña solo se actualizará si ingresas un valor.</small>
            </div>

            <!-- Confirmar contraseña -->
            <div class="form-group col-md-6">
                <label><strong>Confirmar Contraseña</strong></label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Confirma la contraseña">
            </div>
        </div>

        <div class="form-row mt-3">
            <!-- Estado -->
            <div class="form-group col-md-6">
                <label><strong>Estado</strong></label>
                <select name="estado" class="form-control">
                    <option value="activo" {{ $usuario->estado === 'activo' ? 'selected' : '' }}>Activo</option>
                    <option value="inactivo" {{ $usuario->estado === 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                </select>
            </div>

            <!-- Rol -->
            <div class="form-group col-md-6">
                <label><strong>Rol</strong></label>
                <select name="rol" class="form-control" required>
                    <option value="">-- Seleccionar Rol --</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->name }}" {{ $usuario->roles->contains('name', $role->name) ? 'selected' : '' }}>
                            {{ ucfirst($role->name) }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Botones -->
        <div class="form-group text-center mt-4">
            <a href="{{ route('usuarios.index') }}" class="btn btn-secondary px-4">
                <i class="fas fa-times"></i> Cancelar
            </a>
            <button type="submit" class="btn btn-info px-4">
                <i class="fas fa-save"></i> Actualizar
            </button>
        </div>
    </form>
</div>

@section('js')
<script>
    // Mostrar/ocultar contraseña
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');

    togglePassword.addEventListener('click', function () {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        this.querySelector('i').classList.toggle('fa-eye');
        this.querySelector('i').classList.toggle('fa-eye-slash');
    });
</script>
@stop

<style>
    .form-row { margin-bottom: 15px; }
    label { font-weight: 600; }
    input, select { font-size: 14px; padding: 10px; border-radius: 4px; border: 1px solid #ccc; }
    input:focus, select:focus { border-color: #17a2b8; box-shadow: 0 0 5px rgba(23,162,184,0.5); }
</style>

@endsection
