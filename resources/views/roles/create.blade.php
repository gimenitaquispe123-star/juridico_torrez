@extends('adminlte::page')
@section('title', isset($role) ? 'Editar Rol' : 'Crear Rol')
@section('content_header')
<h1>{{ isset($role) ? 'Editar Rol' : 'Crear Rol' }}</h1>
@stop
@section('content')
<form action="{{ isset($role) ? route('roles.update', $role) : route('roles.store') }}" method="POST">
    @csrf
    @if(isset($role)) @method('PUT') @endif
    <div class="form-group">
        <label>Nombre del Rol</label>
        <input type="text" name="name" class="form-control" value="{{ $role->name ?? '' }}" required>
    </div>
    <button type="submit" class="btn btn-success">Guardar</button>
    <a href="{{ route('roles.index') }}" class="btn btn-secondary">Volver</a>
</form>
@stop
