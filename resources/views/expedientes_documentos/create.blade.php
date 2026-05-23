@extends('adminlte::page')

@section('title', 'Agregar Documento a Expediente')

@section('content_header')
    <h1 class="text-center" style="font-family: Georgia, serif;">📑 Registrar Documento en Expediente</h1>
@stop

@section('content')
<div class="card shadow-sm border-top border-success">
    <div class="card-header bg-success text-white">
        <h5 class="mb-0">Nuevo Documento</h5>
    </div>

    <form action="{{ route('expedientes-documentos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id_expediente" value="{{ $expediente->id }}">

        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <label>Expediente:</label>
                    <select name="id_expediente" class="form-control" required>
                        <option value="">-- Seleccione --</option>
                        @foreach ($expedientes as $exp)
                            <option value="{{ $exp->id }}">{{ $exp->codigo_expediente }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
    <label for="documento">Tipo de Documento:</label>
    <input type="text" name="documento" id="documento" class="form-control" placeholder="Ingrese tipo de documento" required>
</div>

            </div>

            <div class="mt-3">
                <label>Observación o Descripción:</label>
                <textarea name="observacion_descripcion" class="form-control" rows="3" placeholder="Detalles sobre el documento..."></textarea>
            </div>

            <div class="mt-3">
                <label>Archivo (opcional):</label>
                <input type="file" name="ruta_documento" class="form-control">
            </div>

            <div class="mt-3">
                <label>Estado:</label>
                <select name="estado" class="form-control">
                    <option value="1">Activo</option>
                    <option value="0">Inactivo</option>
                </select>
            </div>
        </div>

        <div class="card-footer text-end">
            <a href="{{ route('expedientes-documentos.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
            <button type="submit" class="btn btn-success">
                <i class="fas fa-save"></i> Guardar
            </button>
        </div>
    </form>
</div>
@stop

@section('css')
<style>
h1 { font-family: Georgia, serif; }
</style>
@stop
