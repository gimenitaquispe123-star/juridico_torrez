@extends('adminlte::page')

@section('title', 'Carpetas')

@section('content_header')
<h1 style="font-family: Georgia, serif; font-weight: 900; color: black;">
    Gestión de Carpetas
</h1>
@stop

@section('content')

<div class="container-fluid">

    <div class="mb-3 d-flex justify-content-start gap-2">

        <a href="{{ route('documentos.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Volver
        </a>

        <a href="{{ route('carpetas.create') }}" class="btn btn-info btn-sm">
            <i class="fas fa-folder-plus"></i> Nueva Carpeta
        </a>

    </div>

    <div class="mb-3">
        <form method="GET">

            <label for="perPage" class="me-2">Mostrar:</label>

            <select name="perPage" id="perPage"
                class="form-select d-inline-block w-auto form-select-sm"
                onchange="this.form.submit()">

                @foreach([5,10,15,25,50,100] as $size)
                    <option value="{{ $size }}"
                        {{ request('perPage',10)==$size?'selected':'' }}>
                        {{ $size }}
                    </option>
                @endforeach

            </select>

            <span>entrada</span>

        </form>
    </div>

    <div class="row">

        @forelse($carpetas as $c)

        <div class="col-6 col-md-2 col-lg-1 mb-3">

            <a href="{{ route('carpetas.show',$c->id) }}" style="text-decoration:none;">

                <div class="card carpeta-card text-center">

                    <div class="card-body p-2">

                        <i class="fas fa-folder fa-2x text-warning mb-1"></i>

                        <h6 class="carpeta-nombre" title="{{ $c->nombre }}">
                            {{ $c->nombre }}
                        </h6>

                        {{-- CONTADOR --}}
                        @if($c->subcarpetas_count ?? $c->subcarpetas->count())
                            <small class="text-muted d-block">
                                {{ $c->subcarpetas_count ?? $c->subcarpetas->count() }} subcarpetas
                            </small>
                        @endif

                    </div>

                    <div class="card-footer p-1 text-center">
                        <span class="text-primary" style="font-size:11px;">
                            <i class="fas fa-folder-open"></i> Abrir
                        </span>
                    </div>

                </div>

            </a>

        </div>

        @empty

        <div class="col-12">

            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle"></i>
                No hay carpetas disponibles.
            </div>

        </div>

        @endforelse

    </div>

    <div class="mt-3 d-flex justify-content-end">

        {{ $carpetas->appends(['perPage'=>request('perPage')])
            ->links('pagination::bootstrap-5') }}

    </div>

</div>

@stop


@section('css')

<style>

.carpeta-card{
    border-radius:8px;
    transition:0.2s;
    cursor:pointer;
}

.carpeta-card:hover{
    transform:scale(1.05);
    box-shadow:0px 3px 10px rgba(0,0,0,0.15);
}

.carpeta-nombre{
    font-size:12px;
    margin:0;
    white-space:nowrap;
    overflow:hidden;
    text-overflow:ellipsis;
    color:#2c3e50;
}

</style>

@stop