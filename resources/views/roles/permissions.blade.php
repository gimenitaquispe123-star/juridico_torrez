@extends('adminlte::page')

@section('title', 'Asignar Permisos')

@section('content_header')
<h6 style="font-family: Georgia, serif; font-size: 32px;">
    Asignar Permisos al Rol: {{ $role->name }}
</h6>
@stop

@section('content')

<div class="card shadow-lg border rounded" style="border-radius: 12px;">
    <div class="card-header  text-black" style="font-family: Georgia, serif;">
        <strong>Listado de Permisos</strong>
    </div>

    <div class="card-body">

        <form action="{{ route('roles.permissions.update', $role) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                @foreach($permissions as $permission)
                <div class="col-md-4">
                    <div class="form-check mb-2 p-2 border rounded"
                        style="background: #f8f9fa; border-radius: 8px;">
                        <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                               class="form-check-input"
                               {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                        <label class="form-check-label" style="font-family: Georgia, serif;">
                            {{ $permission->name }}
                        </label>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-info"><i class="fas fa-check"></i> Asignar Permisos</button>
                <a href="{{ route('roles.index') }}" class="btn btn-danger">Volver</a>
            </div>

        </form>

    </div>
</div>

@stop
