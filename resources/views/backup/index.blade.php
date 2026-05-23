@extends('adminlte::page')

@section('title', 'Backups')

@section('content')

<div class="container-fluid">

    <div class="card shadow-sm border-0">

        <div class="card-header bg- text-black d-flex justify-content-between align-items-center">
           <h5 class="mb-0" style="font-family: Georgia, 'Times New Roman', Times, serif;">
    <i class="fas fa-database"></i> Copias de Seguridad del Sistema
</h5>

            
            <a href="{{ route('backup.run') }}" class="btn btn-danger btn-sm">
                <i class="fas fa-sync-alt"></i> Generar Copias seguridad
            </a>
        </div>

        <!-- BODY -->
        <div class="card-body bg-light">

          
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fas fa-times-circle"></i> {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            @endif

           
            <div class="table-responsive">
                <table class="table table-striped table-hover text-center align-middle">

                    <thead class="bg-secondary text-white">
                        <tr>
                            <th>ID</th>
                            <th class="text-left">Archivo</th>
                            <th>Acción</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($files as $index => $file)
                            <tr>
                                <td>{{ $index + 1 }}</td>

                                <td class="text-left">
                                    <i class="fas fa-file-alt text-primary"></i>
                                    {{ $file->getFilename() }}
                                </td>

                                <td>
                                    <a href="{{ route('backup.download', $file->getFilename()) }}"
                                       class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-download"></i> Descargar
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">
                                    <div class="text-muted py-3">
                                        <i class="fas fa-folder-open fa-2x"></i><br>
                                        No hay copias de seguridad disponibles
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>

    </div>

</div>

@endsection