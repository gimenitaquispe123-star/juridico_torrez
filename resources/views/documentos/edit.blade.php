@extends('adminlte::page')

@section('title', 'Editar Documento')

@section('content_header')
    <h1>Editar Documento: {{ $documento->nombre }}</h1>
@stop

@section('content')
<div class="container">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('documento.guardar', $documento->id_documento) }}" method="POST">
        @csrf

        <div class="card">
            <div class="card-header bg-info text-white">
                Contenido del Documento
            </div>
            <div class="card-body">
                <textarea name="contenido" class="form-control" rows="20">@if($documento->archivo && file_exists(storage_path('app/' . $documento->archivo))){{ file_get_contents(storage_path('app/' . $documento->archivo)) }}@endif</textarea>
            </div>
            <div class="card-footer text-right">
                <a href="{{ url()->previous() }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Guardar cambios
                </button>
            </div>
        </div>
    </form>

</div>
@stop
