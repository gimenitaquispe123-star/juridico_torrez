@extends('adminlte::page')

@section('title', 'Ver Documento')

@section('content_header')
<h1 class="text-center" style="font-family: Georgia, serif; font-weight: bold;">
    {{ $documento->nombre }}
</h1>
@stop

@section('content')

<div class="container">

    {{-- MENSAJES --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}

            <button type="button"
                    class="close"
                    data-dismiss="alert">

                &times;

            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}

            <button type="button"
                    class="close"
                    data-dismiss="alert">

                &times;

            </button>
        </div>
    @endif

    {{-- CARD OCR --}}
    <div class="card">

        <div class="card-body">

            @if($documento->texto_extraido)

                <form action="{{ route('documentos.updateTexto', $documento->id_documento) }}"
                      method="POST">

                    @csrf
                    @method('PUT')

                    <div class="form-group">

                        <label style="font-family: Georgia, serif; font-weight:bold;">

                            Texto Extraído

                        </label>

                        <textarea
                            id="texto_extraido"
                            name="texto_extraido"
                            class="form-control"
                            rows="18"
                            style="font-family: Georgia, serif; font-size:15px;"
                        >{{ old('texto_extraido', $documento->texto_extraido) }}</textarea>

                    </div>

                    <div class="mt-4 d-flex flex-wrap justify-content-center">

                        {{-- GUARDAR CAMBIOS --}}
                        <button type="submit"
                                class="btn btn-success mr-2 mb-2">

                            <i class="fas fa-save"></i>
                            Guardar Cambios

                        </button>

                        {{-- NUEVO DOCUMENTO --}}
                        <button type="button"
                                class="btn btn-primary mr-2 mb-2"
                                data-toggle="modal"
                                data-target="#modalNuevoDocumento">

                            <i class="fas fa-copy"></i>
                            Guardar como Nuevo Documento

                        </button>

                        {{-- IMPRIMIR --}}
                        <button type="button"
                                class="btn btn-danger mb-2"
                                onclick="imprimirTexto()">

                            <i class="fas fa-print"></i>
                            Imprimir

                        </button>

                    </div>

                </form>

            @else

                <div class="alert alert-info">

                    <i class="fas fa-info-circle"></i>

                    Este documento aún no tiene OCR aplicado.

                </div>

            @endif

        </div>

    </div>

    {{-- BOTÓN VOLVER --}}
    <a href="{{ route('documentos.index') }}"
       class="btn btn-info mt-3">

        <i class="fas fa-arrow-left"></i>
        Volver

    </a>

</div>


{{-- MODAL NUEVO DOCUMENTO OCR --}}
<div class="modal fade"
     id="modalNuevoDocumento"
     tabindex="-1">

    <div class="modal-dialog">

        <div class="modal-content">

            <form id="formNuevoOCR"
                  action="{{ route('documentos.guardarNuevoOCR', $documento->id_documento) }}"
                  method="POST">

                @csrf

                <div class="modal-header bg-info">

                    <h5 class="modal-title">

                        <i class="fas fa-copy"></i>
                        Guardar OCR Como Nuevo Documento

                    </h5>

                    <button type="button"
                            class="close"
                            data-dismiss="modal">

                        <span>&times;</span>

                    </button>

                </div>

                <div class="modal-body">

                    {{-- NOMBRE --}}
                    <div class="form-group">

                        <label>
                            Nombre del Nuevo Documento
                        </label>

                        <input type="text"
                               name="nuevo_nombre"
                               class="form-control"
                               placeholder="Ej: Memorial corregido OCR"
                               required>

                    </div>

                    {{-- CARPETAS --}}
                    <div class="form-group">

                        <label>
                            Seleccionar Carpeta
                        </label>

                        <select name="carpeta_id"
                                class="form-control">

                            <option value="">
                                -- Seleccionar --
                            </option>

                            @foreach($carpetas as $carpeta)

                                <option value="{{ $carpeta->id }}">
                                    📁 {{ $carpeta->nombre }}
                                </option>

                                @foreach($carpeta->subcarpetas as $sub)

                                    <option value="{{ $sub->id }}">
                                        &nbsp;&nbsp;&nbsp;📂 {{ $sub->nombre }}
                                    </option>

                                @endforeach

                            @endforeach

                        </select>

                    </div>

                    {{-- TEXTO OCR --}}
                    <input type="hidden"
                           name="texto_extraido"
                           id="texto_extraido_hidden">

                </div>

                <div class="modal-footer">

                    <button type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal">

                        Cancelar

                    </button>

                    <button type="button"
                            class="btn btn-info"
                            onclick="guardarNuevoDocumentoOCR()">

                        <i class="fas fa-save"></i>
                        Crear Nuevo Documento

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@stop


@section('js')

<script>

function imprimirTexto() {

    const texto = document.getElementById('texto_extraido').value;

    const ventana = window.open('', '', 'height=700,width=900');

    ventana.document.write(`
        <html>

        <head>

            <title>Imprimir OCR</title>

            <style>

                body{
                    font-family: Georgia, serif;
                    padding: 30px;
                    white-space: pre-wrap;
                    font-size: 15px;
                    line-height: 1.7;
                }

            </style>

        </head>

        <body>

            ${texto}

        </body>

        </html>
    `);

    ventana.document.close();

    ventana.print();
}


function guardarNuevoDocumentoOCR() {

    document.getElementById('texto_extraido_hidden').value =
        document.getElementById('texto_extraido').value;

    document.getElementById('formNuevoOCR').submit();
}

</script>

@stop