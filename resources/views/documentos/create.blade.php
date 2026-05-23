@extends('adminlte::page')

@section('title', 'Subir Documento')

@section('content_header')
    <h1 style="font-family: Georgia, serif;">Subir Documento</h1>

@stop

@section('content')
<div class="container-fluid">
    <div class="card card-">
        

        <form action="{{ route('documentos.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

        
            <input type="hidden" name="carpeta_id" value="{{ $carpeta_id ?? '' }}">

            <div class="card-body">
                <div class="form-group">
                    <label for="nombre">Nombre del Documento</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ingrese el nombre" required>
                </div>

                <div class="form-group">
                    <label for="archivo">Archivo</label>
                    <input type="file" name="archivo" id="archivo" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="descripcion">Descripción</label>
                    <textarea name="descripcion" id="descripcion" class="form-control" rows="3" placeholder="Descripción opcional"></textarea>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-info">
                    <i class="fas fa-upload"></i> Subir Documento
                </button>

                {{-- Solo mostrar enlace "Volver" si $carpeta_id existe --}}
                @if(isset($carpeta_id))
                    <a href="{{ route('carpetas.show', $carpeta_id) }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                @else
                    <a href="{{ route('carpetas.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Volver a carpetas</a>
                @endif
            </div>
        </form>
    </div>
</div>
@stop
