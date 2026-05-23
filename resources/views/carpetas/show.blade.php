@extends('adminlte::page')

@section('title', 'Carpeta')

@section('content')
<div class="container">

    <h3 style="font-family: Georgia, serif;">
        <i class="fas fa-folder text-dark"></i> {{ $carpeta->nombre }}
    </h3>

    @if($carpeta->proceso)
        <p>
            <strong>Proceso asociado:</strong> 
            {{ $carpeta->proceso->proceso ?? 'Sin proceso' }} 
            (Cliente: {{ $carpeta->proceso->cliente->nombre_completo ?? 'Sin cliente' }})
        </p>
    @endif

    {{-- BOTONES SUPERIORES --}}
    <div class="mb-3 d-flex gap-2">

        <a href="{{ route('documentos.create') }}?carpeta_id={{ $carpeta->id }}" 
           class="btn btn-info btn-sm">
            <i class="fas fa-upload"></i> Subir documento
        </a>

        <a href="{{ route('carpetas.create') }}?padre_id={{ $carpeta->id }}" 
           class="btn btn-primary btn-sm">
            <i class="fas fa-folder-plus"></i> Nueva subcarpeta
        </a>

        <a href="{{ route('carpetas.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Volver
        </a>

    </div>

    {{-- ================= SUBCARPETAS ================= --}}
    <h5 style="font-family: Georgia, serif;">📁 Subcarpetas</h5>

    @forelse($subcarpetas as $sub)

    <div class="d-flex align-items-center border rounded p-2 mb-2">

        <i class="fas fa-folder text-warning me-2"></i>

        <a href="{{ route('carpetas.show', $sub->id) }}" class="me-2">
            {{ $sub->nombre }}
        </a>

        {{-- BOTONES --}}
        <a href="{{ route('carpetas.edit', $sub->id) }}" 
           class="btn btn-xs btn-warning me-1">
            <i class="fas fa-edit"></i>
        </a>

        <form action="{{ route('carpetas.destroy', $sub->id) }}" 
              method="POST" style="display:inline;">
            @csrf
            @method('DELETE')

            <button class="btn btn-xs btn-danger"
                onclick="return confirm('⚠️ ¿Eliminar subcarpeta?')">
                <i class="fas fa-trash"></i>
            </button>
        </form>

    </div>

    @empty
        <p class="text-muted">No hay subcarpetas</p>
    @endforelse

    <div class="mt-2">
        {{ $subcarpetas->links() }}
    </div>

    {{-- ================= DOCUMENTOS ================= --}}
    <h5 class="mt-4" style="font-family: Georgia, serif;">📄 Documentos</h5>

    @forelse($documentos as $doc)

    <div class="d-flex align-items-center border rounded p-2 mb-2">

        <i class="fas fa-file-alt text-primary me-2"></i>

        <span class="me-3">{{ $doc->nombre }}</span>

        @if($doc->texto_extraido)
            <span class="badge bg-success me-2">OCR listo</span>
        @endif

        {{-- BOTONES --}}
        <a href="{{ route('documentos.download', $doc->id_documento) }}" 
           class="btn btn-xs btn-success me-1">
            <i class="fas fa-download"></i>
        </a>

        <form action="{{ route('documentos.destroy', $doc->id_documento) }}" 
              method="POST" style="display:inline;">
            @csrf
            @method('DELETE')

            <button class="btn btn-xs btn-danger"
                onclick="return confirm('⚠️ ¿Eliminar documento?')">
                <i class="fas fa-trash"></i>
            </button>
        </form>

    </div>

    @empty
        <p class="text-muted">No hay documentos</p>
    @endforelse

    <div class="mt-2">
        {{ $documentos->links() }}
    </div>

</div>
@stop

@section('css')
<style>
.btn-xs{
    padding:3px 6px;
    font-size:11px;
}
</style>
@stop