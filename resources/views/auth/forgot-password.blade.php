@extends('adminlte::auth.auth-page', ['auth_type' => 'login'])

@section('title', 'Recuperar contraseña')

@section('auth_header')
   <strong style="font-family: Georgia, serif;">Recuperar contraseña</strong>
@stop

@section('auth_body')

<p class="login-box-msg">
    Ingresa tu correo electrónico para recibir el enlace de recuperación.
</p>

@if (session('status'))
    <div class="alert alert-success text-center">
        {{ session('status') }}
    </div>
@endif

<form action="{{ route('password.email') }}" method="POST">
    @csrf

    <div class="input-group mb-3">
        <input type="email"
               name="email"
               class="form-control @error('email') is-invalid @enderror"
               placeholder="Correo electrónico"
               required>

        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-envelope"></span>
            </div>
        </div>

        @error('email')
            <span class="invalid-feedback d-block">
                {{ $message }}
            </span>
        @enderror
    </div>

    <button type="submit" class="btn btn-info btn-block">
        Enviar enlace de recuperación
    </button>

</form>

<div class="text-center mt-3">
    <a href="{{ route('login') }}">
        Volver al inicio de sesión
    </a>
</div>

@stop