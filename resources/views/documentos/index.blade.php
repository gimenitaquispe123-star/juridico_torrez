@extends('adminlte::page')

@section('title', 'Lista de Documentos')

@section('content_header')
<div class="text-center">
    <h1 style="font-family: Georgia, serif; font-weight: bold;">Lista de Documentos</h1>
</div>
@stop

@section('content')
<div class="container-fluid">         

    <div class="mb-3 d-flex justify-content-between align-items-center">
      
        <a href="{{ route('documentos.create') }}" class="btn btn-info" style="font-family: Georgia, serif; font-weight: bold;">
            <i class="fas fa-upload"></i> Subir documento
        </a>
    
        <form action="{{ route('documentos.index') }}" method="GET" class="form-inline">
            <select name="perPage" class="form-control mr-2" onchange="this.form.submit()">
                @foreach([5,10,25,50,100] as $size)
                    <option value="{{ $size }}" {{ request('perPage') == $size ? 'selected' : '' }}>
                        Mostrar {{ $size }}
                    </option>
                @endforeach
            </select>    

            <input type="text" name="search" class="form-control mr-2" placeholder="Buscar..." value="{{ request('search') }}">
           
            <button class="btn btn-danger"><i class="fas fa-search"></i> Buscar</button>
        </form>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    
    <div class="card">
        <div class="card-header">
            <h3 class="card-title" style="font-family: Georgia, serif; font-weight: bold;">Documentos</h3>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover text-center align-middle">
                
            
            <thead class="thead-light">
                    <tr>
                        <th style="font-family: Georgia, serif;">ID</th>
                        <th style="font-family: Georgia, serif;">Nombre</th>
                        <th style="font-family: Georgia, serif;">Tipo</th>
                        <th style="font-family: Georgia, serif;">Fecha</th>
                        <th style="font-family: Georgia, serif;">Archivo</th>
                        <th style="font-family: Georgia, serif;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($documentos as $doc)
                        @php
                            $icon = 'fa-file';
                            $ext = strtolower($doc->tipo);
                            if ($ext == 'pdf') $icon = 'fa-file-pdf';
                            elseif (in_array($ext, ['doc','docx'])) $icon = 'fa-file-word';
                            elseif (in_array($ext, ['xls','xlsx'])) $icon = 'fa-file-excel';
                            elseif (in_array($ext, ['jpg','jpeg','png','gif','svg'])) $icon = 'fa-file-image';
                        @endphp
                        <tr>
                            <td>{{ $doc->id_documento }}</td>

                            <td style="font-family: Georgia, serif;">{{ $doc->nombre }}</td>
                            <td>{{ strtoupper($doc->tipo) }}</td>   

                            <td>{{ $doc->fecha_subida?->format('d/m/Y H:i') ?? '-' }}</td>

                            <td>
                                <a href="{{ route('documentos.show', $doc->id_documento) }}" target="_blank" class="btn btn-secondary btn-sm">
                                    <i class="fas {{ $icon }}"></i> Ver
                                </a>
                            </td>

                            <td>
                                <a href="{{ route('documentos.download', $doc->id_documento) }}" class="btn btn-sm btn-primary" title="Descargar">
                                    <i class="fas fa-download">Descargar</i>
                                </a>

                                @if(!$doc->texto_extraido)
                                    <form action="{{ route('documentos.ocr', $doc->id_documento) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button class="btn btn-sm btn-warning" title="Aplicar OCR">
                                            <i class="fas fa-file-alt">OCR</i>
                                        </button>
                                    </form>
                                @else
                                    <span class="badge bg-success">OCR listo</span>
                                @endif
                                <form action="{{ route('documentos.destroy', $doc->id_documento) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar este documento?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" title="Eliminar">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center" style="font-family: Georgia, serif;">No hay documentos disponibles</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            
        </div>

    <div class="d-flex justify-content-end mt-3">
    {{ $documentos->onEachSide(1)->links('pagination::bootstrap-4') }}
</div>


    </div>
</div>
@stop
