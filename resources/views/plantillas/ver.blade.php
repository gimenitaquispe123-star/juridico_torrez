@extends('adminlte::page')

@section('title', 'Ver Archivo')

@section('content_header')
    <h1>Vista previa del archivo</h1>
@endsection

@section('content')
    <div class="card p-3">

        <!-- Botón de descargar -->
        <a href="{{ $ruta }}" download class="btn btn-success mb-3">
            <i class="fas fa-download"></i> Descargar archivo
        </a>

        <div class="text-center">

            {{-- PDF --}}
            @if($extension == 'pdf')
                <iframe src="{{ $ruta }}" width="100%" height="600px"></iframe>
            @endif

            {{-- Imágenes --}}
            @if(in_array($extension, ['jpg','jpeg','png','webp']))
                <img src="{{ $ruta }}" class="img-fluid" style="max-height: 700px;">
            @endif

            {{-- TXT --}}
            @if($extension == 'txt')
                <iframe src="{{ $ruta }}" width="100%" height="600px"></iframe>
            @endif

        </div>
    </div>
@endsection
