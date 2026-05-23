@extends('adminlte::page')

@section('title', 'Gestión de Notificaciones')

@section('content_header')
    <div class="w-100 text-center mb-3">
        <h2 class="fw-bold" style="font-family: Georgia, serif;"> Gestión de Notificaciones</h2>
    </div>
@stop

@section('content')
<div class="card shadow rounded">
    <div class="card-body">

        <div class="input-group my-4 d-flex align-items-center gap-3">

            <!-- Selector de cantidad de registros -->
            <div class="d-flex align-items-center">
                <label class="me-2 mb-0">Mostrar</label>
                <form method="GET" action="{{ route('notificaciones.index') }}">
                    <select name="per_page" class="form-select form-select-sm me-2" onchange="this.form.submit()">
                        @foreach([5, 10, 25, 50, 100] as $size)
                            <option value="{{ $size }}" {{ request('per_page', 10) == $size ? 'selected' : '' }}>
                                {{ $size }}
                            </option>
                        @endforeach
                    </select>
                </form>
                <label class="mb-0">entradas</label>
            </div>

            <!-- Buscador -->
            <form method="GET" action="{{ route('notificaciones.index') }}" class="d-flex flex-grow-1">
                <input type="text" name="buscar" class="form-control me-2" placeholder="Buscar..." value="{{ request('buscar') }}">
                <button class="btn btn-info">Buscar</button>
            </form>

        </div>

        
    
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Usuario</th>
                        <th>Canal</th>
                        <th>Estado</th>
                        <th>Leído</th>
                        <th>Fecha Evento</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($notificaciones as $n)
                    <tr>
                        <td>{{ $n->id_notificacion }}</td>
                        <td>{{ $n->titulo }}</td>
                        <td>{{ $n->usuario->nombre ?? 'Sin usuario' }}</td>
                        <td>
                            <span class="badge 
                            @if($n->canal == 'sistema') bg-primary
                            @elseif($n->canal == 'email') bg-info
                            @elseif($n->canal == 'whatsapp') bg-success
                            @else bg-secondary @endif">
                                {{ ucfirst($n->canal) }}
                            </span>
                        </td>
                        <td>
                            <span class="badge 
                            @if($n->estado == 'pendiente') bg-warning
                            @elseif($n->estado == 'enviado') bg-success
                            @else bg-secondary @endif">
                                {{ ucfirst($n->estado) }}
                            </span>
                        </td>
                        <td>
                            @if($n->leido)
                                <span class="badge bg-success">Sí</span>
                            @else
                                <span class="badge bg-danger">No</span>
                            @endif
                        </td>
                        <td>{{ $n->fecha_evento ? \Carbon\Carbon::parse($n->fecha_evento)->format('d/m/Y H:i') : '-' }}</td>
                        <td class="d-flex flex-wrap gap-1">
                            <a href="{{ route('notificaciones.show', $n->id_notificacion) }}" class="btn btn-sm btn-info" title="Ver">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('notificaciones.edit', $n->id_notificacion) }}" class="btn btn-sm btn-secondary" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('notificaciones.destroy', $n->id_notificacion) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar notificación?')" title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            @if(!$n->leido)
                                <form action="{{ route('notificaciones.marcarLeida', $n->id_notificacion) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-success" title="Marcar como leída">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">No hay notificaciones registradas.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

       
        <div class="mt-3 d-flex justify-content-center">
            {{ $notificaciones->links() }}
        </div>
    </div>
</div>

<div style="position: fixed; top: 30%; right: 0; z-index: 999;">
    
    <div class="menu-btn bg-purple mb-2" onclick="location.href='{{ route('notificaciones.create') }}'" style="cursor:pointer;">
    <div class="btn-content">
     <i class="fas fa-bell"></i>

        <span class="menu-text">Crear Nueva</span>
    </div>
</div>

</div>
<footer class="mt-5 text-center text-white" style="background-color: #333;">
    <div class="py-3"></div>
    <div>
        <a href="#" class="btn btn-success me-2">
            <i class="fab fa-whatsapp"></i>
        </a>
        <a href="#" class="btn btn-success">
            <i class="fab fa-whatsapp"></i>
        </a>
    </div>
</footer>
@stop

@section('css')
<style>
    h2, h4 {
        font-family: Georgia, serif;
    }
    .menu-btn {
        width: 50px;
        height: 50px;
        border-radius: 5px 0 0 5px;
        overflow: hidden;
        cursor: pointer;
        transition: width 0.3s ease-in-out;
        color: white;
    }
    .btn-content {
        display: flex;
        align-items: center;
        height: 100%;
        transform: translateX(0);
        padding-left: 10px;
        transition: transform 0.3s ease-in-out;
        white-space: nowrap;
    }
    .menu-text {
        margin-left: 10px;
        opacity: 0;
        transition: opacity 0.3s ease-in-out;
    }
    .menu-btn:hover {
        width: 160px;
    }
    .menu-btn:hover .btn-content {
        transform: translateX(0);
    }
    .menu-btn:hover .menu-text {
        opacity: 1;
    }
    
    .bg-pink { background-color:  #6f42c1; }
  
    .menu-btn i { font-size: 18px; }
</style>
@stop

@section('js')
<script>
    document.getElementById('btn-familiar').addEventListener('click', function () {
        alert('Aquí puedes mostrar la sección familiar si quieres');
    });
</script>
@stop
