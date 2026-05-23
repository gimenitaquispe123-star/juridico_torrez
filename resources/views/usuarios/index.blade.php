@extends('adminlte::page')

@section('title', 'Usuarios')

@section('content_header')
<h1 class="text-dark" style="font-family: Georgia, serif; font-weight: 800;">
    Usuarios
</h1>
@stop

@section('content')

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>¡Error!</strong> Corrige los siguientes campos:
    <ul class="mb-0 mt-2">
        @foreach ($errors->all() as $error)
            <li>• {{ $error }}</li>
        @endforeach
    </ul>
    <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<div class="card shadow-lg">
    <div class="card-header d-flex flex-wrap justify-content-between align-items-center">
        <form method="GET" action="{{ route('usuarios.index') }}" class="form-inline w-100">
            <div class="form-row align-items-center w-100">
                <div class="col-auto">
                    <select name="per_page" class="form-control form-control-sm" onchange="this.form.submit()">
                        <option disabled>Mostrar</option>
                        @foreach([5,10,15,25,50,100] as $cantidad)
                            <option value="{{ $cantidad }}" {{ request('per_page') == $cantidad ? 'selected' : '' }}>{{ $cantidad }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-auto">
                    <input type="text" name="buscar" value="{{ request('buscar') }}" class="form-control form-control-sm" placeholder="Buscar usuario...">
                </div>

                <div class="col-auto">
                    <button type="submit" class="btn btn-info btn-sm">
                        <i class="fas fa-search"></i> Buscar
                    </button>
                </div>

                <div class="col-auto ml-auto d-flex">
                    
                    <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#crearUsuarioModal"
                        style="background-color: #ffffff; color: #c21508ff; border: 1px solid #aa1906ff;">
                        <i class="fas fa-plus"></i> Nuevo
                    </button>

         
                    <button type="button" class="btn btn-secondary btn-sm ml-2" data-toggle="modal" data-target="#exportarPdfModal">
                        <i class="fas fa-file-pdf"></i> Exportar PDF
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="card-body table-responsive">
        <table class="table table-bordered table-hover text-center">
            <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th>Nombre Completo</th>
                    <th>Usuario</th>
                    <th>Email</th>
                    <th>Estado</th>
                    <th>Registrado</th>
                    <th>Modificado</th>
                    <th>Usuario Mod</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($usuarios as $usuario)
                <tr>
                    <td>{{ $usuario->id }}</td>
                    <td>{{ $usuario->persona_id ? ($usuario->persona->nombres ?? '') . ' ' . ($usuario->persona->paterno ?? '') : '-' }}</td>
                    <td>{{ $usuario->usuario }}</td>
                    <td>{{ $usuario->email ?? '-' }}</td>
                    <td>{{ $usuario->estado ?? '-' }}</td>
                    <td>{{ $usuario->created_at ? $usuario->created_at->format('d/m/Y') : '-' }}</td>
                    <td>{{ $usuario->modificado ?? '-' }}</td>
                    <td>{{ $usuario->usuario_mod ?? '-' }}</td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-info btn-sm dropdown-toggle" type="button"
                                    id="accionesDropdown{{ $usuario->id }}" data-toggle="dropdown">
                                Acciones
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="accionesDropdown{{ $usuario->id }}">
                                <a class="dropdown-item" href="{{ route('usuarios.show', $usuario->id) }}">
                                    <i class="fas fa-info-circle text-primary"></i> Detalles
                                </a>
                                <a class="dropdown-item" href="{{ route('usuarios.edit', $usuario->id) }}">
                                    <i class="fas fa-edit text-warning"></i> Editar
                                </a>
                                <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="dropdown-item text-danger" onclick="return confirm('¿Eliminar usuario?')">
                                        <i class="fas fa-trash-alt"></i> Eliminar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center text-muted">No hay usuarios registrados.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        @if(method_exists($usuarios, 'links'))
        <div class="d-flex justify-content-between align-items-center mt-2">
            <div>
                Mostrando {{ $usuarios->firstItem() ?? 0 }} - {{ $usuarios->lastItem() ?? 0 }}
                de {{ $usuarios->total() ?? 0 }} registros
            </div>
            <div>
                {{ $usuarios->appends(request()->query())->links() }}
            </div>
        </div>
        @endif
    </div>
</div>

<div class="modal fade" id="crearUsuarioModal" tabindex="-1" role="dialog" aria-labelledby="crearUsuarioModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content border-0 shadow-lg">
      <div class="modal-header bg-info text-white">
        <h5 class="modal-title">
            <i class="fas fa-user-plus"></i> Nuevo Usuario
        </h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('usuarios.store') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="form-row">
            <div class="form-group col-md-4">
              <label><strong>Persona</strong></label>
              <select name="persona_id" class="form-control" required>
                  <option value="">-- Seleccionar --</option>
                  @foreach($personas as $persona)
                      <option value="{{ $persona->id }}">
                          {{ $persona->nombres }} {{ $persona->paterno }} {{ $persona->materno }} (CI: {{ $persona->ci }})
                      </option>
                  @endforeach
              </select>
            </div>
            <div class="form-group col-md-4">
              <label><strong>Usuario</strong></label>
              <input type="text" name="usuario" class="form-control" required>
            </div>
            <div class="form-group col-md-4">
              <label><strong>Email</strong></label>
              <input type="email" name="email" class="form-control" required>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-4">
              <label><strong>Password</strong></label>
              <input type="password" name="password" class="form-control" required>
            </div>
            <div class="form-group col-md-4">
              <label><strong>Estado</strong></label>
              <select name="estado" class="form-control">
                <option value="activo">Activo</option>
                <option value="inactivo">Inactivo</option>
              </select>
            </div>
            <div class="form-group col-md-4">
              <label><strong>Rol</strong></label>
              <select name="rol" class="form-control" required>
                  <option value="">-- Seleccionar Rol --</option>
                  @foreach($roles as $role)
                      <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                  @endforeach
              </select>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">
              <i class="fas fa-times"></i> Cancelar
          </button>
          <button type="submit" class="btn btn-info">
              <i class="fas fa-save"></i> Registrar
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="modal fade" id="exportarPdfModal" tabindex="-1" role="dialog" aria-labelledby="exportarPdfModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
    <div class="modal-content border-0 shadow-lg">
      <div class="modal-header bg-info text-white">
        <h5 class="modal-title" id="exportarPdfModalLabel">
            <i class="fas fa-file-pdf"></i> Exportar Usuarios PDF
        </h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <div class="form-group">
            <label>Mes</label>
            <input type="number" name="mes" class="form-control" min="1" max="12" placeholder="1-12">
        </div>
        <div class="form-group">
            <label>Año</label>
            <input type="number" name="anio" class="form-control" placeholder="Ej: 2025">
        </div>
      </div>

      <div class="modal-footer">
          <a id="vistaPreviaPdf" href="#" target="_blank" class="btn btn-secondary">
              <i class="fas fa-eye"></i> Vista Previa
          </a>
          <a id="descargarPdf" href="#" class="btn btn-info">
              <i class="fas fa-file-download"></i> Descargar PDF
          </a>
          <button type="button" class="btn btn-danger" data-dismiss="modal">
              <i class="fas fa-times"></i> Cancelar
          </button>
      </div>
    </div>
  </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function() {
    const mes = document.querySelector('input[name="mes"]');
    const anio = document.querySelector('input[name="anio"]');
    const vista = document.getElementById('vistaPreviaPdf');
    const descargar = document.getElementById('descargarPdf');

    function actualizarLinks() {
        const m = mes.value || '{{ date("m") }}';
        const a = anio.value || '{{ date("Y") }}';
        vista.href = `{{ route('usuarios.pdf.vista') }}?mes=${m}&anio=${a}`;
        descargar.href = `{{ route('usuarios.pdf.descargar') }}?mes=${m}&anio=${a}`;
    }

    mes.addEventListener('input', actualizarLinks);
    anio.addEventListener('input', actualizarLinks);

    actualizarLinks(); 
});
</script>

@stop
