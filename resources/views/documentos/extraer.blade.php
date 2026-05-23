@extends('layouts.app')

@section('content')
<h1 style="font-family: Georgia, serif; font-weight: bold;">Editar Texto Extraído</h1>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="mb-3">
    <a href="{{ route('documentos.extraerOCR', $documento->id_documento) }}" class="btn btn-primary">
        <i class="fas fa-magic"></i> Ejecutar OCR
    </a>
</div>

<form action="{{ route('documentos.updateTexto', $documento->id_documento) }}" method="POST">
    @csrf
    @method('PUT')
    
    <div class="form-group">
        <label style="font-family: Georgia, serif;">Texto extraído:</label>
        <textarea name="texto_extraido" id="texto_extraido" rows="20" class="form-control" style="font-family: Georgia, serif;">{{ old('texto_extraido', $documento->texto_extraido) }}</textarea>
    </div>

    <div class="mt-3 d-flex justify-content-between">
        <button type="submit" class="btn btn-success">
            <i class="fas fa-save"></i> Guardar cambios
        </button>

        <button type="button" class="btn btn-danger" onclick="imprimirTexto()">
            <i class="fas fa-print"></i> Imprimir
        </button>
    </div>
</form>

<script>
function imprimirTexto() {
    const texto = document.getElementById('texto_extraido').value;
    const ventana = window.open('', '', 'height=600,width=800');
    ventana.document.write('<html><head><title>Imprimir Texto OCR</title>');
    ventana.document.write('<style>body { font-family: Georgia, serif; padding: 20px; white-space: pre-wrap; }</style>');
    ventana.document.write('</head><body>');
    ventana.document.write(texto);
    ventana.document.write('</body></html>');
    ventana.document.close();
    ventana.print();
}
</script>
@endsection
