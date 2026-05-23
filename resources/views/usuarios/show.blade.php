@extends('adminlte::page')

@section('title', 'Detalle del Usuario')

@section('content_header')
    <h1 class="text-center" style="font-family: Georgia, serif;">Detalle del Usuario</h1>

@stop

@section('content')

<div class="card">
    <div class="card-header bg-info">
        <h3 class="card-title">Información del usuario</h3>
    </div>

    <div class="card-body">

        <table class="table table-bordered">
            <tr>
                <th>ID</th>
                <td>{{ $usuario->id }}</td>
            </tr>

            <tr>
                <th>Nombre</th>
                <td>{{ $usuario->name }}</td>
            </tr>

            <tr>
                <th>Email</th>
                <td>{{ $usuario->email }}</td>
            </tr>

            <tr>
                <th>Rol</th>
                <td>{{ $usuario->rol ?? '-' }}</td>
            </tr>

            <tr>
                <th>Estado</th>
                <td>
                    <span class="badge {{ $usuario->estado ? 'badge-success' : 'badge-danger' }}">
                        {{ $usuario->estado ? 'Activo' : 'Inactivo' }}
                    </span>
                </td>
            </tr>

            <tr>
                <th>Registrado el</th>
                <td>{{ $usuario->created_at->format('d/m/Y') }}</td>
            </tr>
        </table>

        <a href="{{ route('usuarios.index') }}" class="btn btn-secondary mt-3">
            <i class="fas fa-arrow-left"></i> Volver al listado
        </a>

    </div>
</div>

@stop

