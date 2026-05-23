@extends('adminlte::page')

@section('title', 'Editar Expediente Digitalizado')

@section('content_header')
<h1 class="text-dark" style="font-family: Georgia, serif; font-weight: 800;">
    Editar Expediente Digitalizado
</h1>
@stop

@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert">
            <span>&times;</span>
        </button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert">
            <span>&times;</span>
        </button>
    </div>
@endif

<div class="card shadow-lg">
    <div class="card-body">

        <form action="{{ route('expedientes_digitalizados.update', $expedientes_digitalizado) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">

                {{-- CLIENTE --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="id_cliente">
                            <i class="fas fa-user"></i> Cliente
                        </label>

                        <select name="id_cliente" id="id_cliente"
                            class="form-control @error('id_cliente') is-invalid @enderror"
                            required>

                            <option value="">Seleccione un cliente</option>

                            @foreach($clientes as $cliente)
                                <option value="{{ $cliente->id }}"
                                    {{ old('id_cliente', $expedientes_digitalizado->id_cliente) == $cliente->id ? 'selected' : '' }}>
                                    {{ mb_strtoupper($cliente->nombres.' '.$cliente->paterno.' '.$cliente->materno, 'UTF-8') }}
                                </option>
                            @endforeach

                        </select>

                        @error('id_cliente')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- EXPEDIENTE --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="id_expediente">
                            <i class="fas fa-folder-open"></i> Expediente
                        </label>

                        <select name="id_expediente" id="id_expediente"
                            class="form-control @error('id_expediente') is-invalid @enderror"
                            required>

                            <option value="">Seleccione expediente</option>

                            @foreach($expedientes as $exp)
                                <option value="{{ $exp->id }}"
                                    {{ old('id_expediente', $expedientes_digitalizado->id_expediente) == $exp->id ? 'selected' : '' }}>
                                    {{ mb_strtoupper($exp->nombre_expediente ?? $exp->nro_expediente ?? $exp->id, 'UTF-8') }}
                                </option>
                            @endforeach

                        </select>

                        @error('id_expediente')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

            </div>

            <div class="row">

                {{-- NRO EXPEDIENTE --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nro_expediente">
                            <i class="fas fa-hashtag"></i> Número de Expediente
                        </label>

                        <input type="text"
                               name="nro_expediente"
                               id="nro_expediente"
                               class="form-control @error('nro_expediente') is-invalid @enderror"
                               value="{{ old('nro_expediente', $expedientes_digitalizado->nro_expediente) }}"
                               oninput="this.value = this.value.toUpperCase()"
                               required>

                        @error('nro_expediente')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- TIPO EXPEDIENTE --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tipo_expediente">
                            <i class="fas fa-folder"></i> Tipo de Expediente
                        </label>

                        <input type="text"
                               name="tipo_expediente"
                               id="tipo_expediente"
                               class="form-control @error('tipo_expediente') is-invalid @enderror"
                               value="{{ old('tipo_expediente', $expedientes_digitalizado->tipo_expediente ?? '') }}"
                               required>

                        @error('tipo_expediente')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

            </div>

            {{-- TEXTO --}}
            <div class="form-group">
                <label for="texto_expediente">
                    <i class="fas fa-file-alt"></i> Descripción / Texto
                </label>

                <textarea name="texto_expediente"
                          id="texto_expediente"
                          rows="5"
                          class="form-control"
                          oninput="this.value = this.value.toUpperCase()">{{ old('texto_expediente', $expedientes_digitalizado->texto_expediente) }}</textarea>
            </div>

            {{-- DOCUMENTOS --}}
            <div class="form-group">
                <label for="imagenes">
                    <i class="fas fa-upload"></i> Subir Imágenes / Documentos
                </label>

                <input type="file"
                       name="imagenes[]"
                       id="imagenes"
                       class="form-control"
                       accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.gif,.bmp,.tiff"
                       multiple>

                @if($expedientes_digitalizado->url_documento)
                    <small class="text-info d-block mt-2">
                        Documento actual:
                        <a href="{{ asset($expedientes_digitalizado->url_documento) }}" target="_blank">
                            {{ basename($expedientes_digitalizado->url_documento) }}
                        </a>
                    </small>
                @endif
            </div>

            <div class="form-group mt-4 d-flex justify-content-between">
                <a href="{{ route('expedientes_digitalizados.index') }}"
                   class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Actualizar Expediente
                </button>
            </div>

        </form>

    </div>
</div>

@stop