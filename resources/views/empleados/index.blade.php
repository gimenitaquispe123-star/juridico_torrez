@extends('adminlte::page')

@section('title', 'Empleados')

@section('content_header')
<h1 class="text-dark" style="font-family: Georgia, serif; font-weight: 800;">
    Empleados
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

<div class="card shadow-lg">
    <div class="card-header d-flex flex-wrap justify-content-between align-items-center">
        <form method="GET" action="{{ route('empleados.index') }}" class="form-inline w-100">
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
                    <input type="text" name="buscar" value="{{ request('buscar') }}" class="form-control form-control-sm" placeholder="Buscar empleado...">
                </div>

                <div class="col-auto">
                    <button type="submit" class="btn btn-info btn-sm">
                        <i class="fas fa-search"></i> Buscar
                    </button>
                </div>
         

                <div class="col-auto ml-auto d-flex">
                  
                    <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#modalNuevoEmpleado" 
                        style="background-color: #ffffff; color: #0b5ed7; border: 1px solid #0b5ed7;">
                        <i class="fas fa-plus"></i> Nuevo
                    </button>
                    
                </div>

                <a href="{{ route('empleados.export.pdf') }}" class="btn btn-danger btn-sm">
    <i class="fas fa-file-pdf"></i> PDF
</a>

            </div>
        </form>
    </div>

    <div class="card-body table-responsive">
        <table class="table table-bordered table-hover text-center">
            <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th>Nombre Completo</th>
                    <th>Rol</th>
                    <th>Celular</th>
                    <th>Matrícula</th>
                    <th>Área</th>
                    <th>Registrado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($empleados as $empleado)
                <tr>
                    <td>{{ $loop->iteration + ($empleados->currentPage()-1)*$empleados->perPage() }}</td>
                    <td>{{ $empleado->nombres }} {{ $empleado->paterno }} {{ $empleado->materno }}</td>
                    <td>{{ $empleado->tipoPersona->tipo_persona ?? '-' }}</td>
                    <td>{{ $empleado->celular ?? '-' }}</td>
                    <td>{{ $empleado->matricula ?? '-' }}</td>
                    <td>{{ $empleado->area ?? '-' }}</td>
                    <td>{{ $empleado->created_at ? $empleado->created_at->format('Y-m-d H:i') : '-' }}</td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                    id="accionesDropdown{{ $empleado->id }}"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Acciones
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="accionesDropdown{{ $empleado->id }}">
                                <a class="dropdown-item" href="{{ route('empleados.show', $empleado->id) }}">
                                    <i class="fas fa-eye"></i> Detalles
                                </a>
                            @can('editar empleado')      
                                <a class="dropdown-item" href="{{ route('empleados.edit', $empleado->id) }}">
                                    <i class="fas fa-edit text-warning"></i> Editar
                                </a>
                             @endcan
                               @can('eliminar empleado')    
                                <form action="{{ route('empleados.destroy', $empleado->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="dropdown-item text-danger" onclick="return confirm('¿Eliminar empleado?')">
                                        <i class="fas fa-trash-alt"></i> Eliminar
                                    </button>
                                </form>
                             @endcan
                                 
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center text-muted">No hay empleados registrados.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="d-flex justify-content-between align-items-center mt-2">
            <div>
                Mostrando {{ $empleados->firstItem() ?? 0 }} - {{ $empleados->lastItem() ?? 0 }}
                de {{ $empleados->total() ?? 0 }} registros
            </div>
            <div>
                {{ $empleados->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalNuevoEmpleado" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg">

      <div class="modal-header bg-info text-white">
        <h5 class="modal-title">
          <i class="fas fa-user-plus"></i> Nuevo Empleado
        </h5>
        <button type="button" class="close text-white" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>

      <form action="{{ route('empleados.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="modal-body">

          <div class="form-group">
            <label><strong>Tipo de Persona</strong></label>
            <select name="id_tipo_persona"
                    class="form-control @error('id_tipo_persona') is-invalid @enderror"
                    required>
              <option value="">-- Seleccionar Tipo de Persona --</option>
              @foreach($tipos_personas as $tipo)
                <option value="{{ $tipo->id }}"
                  {{ old('id_tipo_persona') == $tipo->id ? 'selected' : '' }}>
                  {{ $tipo->tipo_persona }}
                </option>
              @endforeach
            </select>
            @error('id_tipo_persona')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-row">


            <div class="form-group col-md-4">
              <label>Nombres </label>
              <input type="text"
                     name="nombres"
                     value="{{ old('nombres') }}"
                     class="form-control @error('nombres') is-invalid @enderror"
                     style="text-transform: uppercase;"
                     oninput="this.value=this.value.toUpperCase().replace(/[^A-ZÁÉÍÓÚÑ ]/g,'')"
                     required>
              @error('nombres')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            
            <div class="form-group col-md-4">
              <label>Apellido Paterno</label>
              <input type="text"
                     name="paterno"
                     value="{{ old('paterno') }}"
                     class="form-control @error('paterno') is-invalid @enderror"
                     style="text-transform: uppercase;"
                     oninput="this.value=this.value.toUpperCase().replace(/[^A-ZÁÉÍÓÚÑ ]/g,'')">
              @error('paterno')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group col-md-4">
              <label>Apellido Materno</label>
              <input type="text"
                     name="materno"
                     value="{{ old('materno') }}"
                     class="form-control @error('materno') is-invalid @enderror"
                     style="text-transform: uppercase;"
                     oninput="this.value=this.value.toUpperCase().replace(/[^A-ZÁÉÍÓÚÑ ]/g,'')">
              @error('materno')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

          </div>

    
          <div class="form-row">

            <div class="form-group col-md-4">
              <label>Cédula de Identidad</label>
              <input type="text"
                     name="ci"
                     value="{{ old('ci') }}"
                     class="form-control @error('ci') is-invalid @enderror"
                     style="text-transform: uppercase;"
                     oninput="this.value=this.value.toUpperCase().replace(/[^0-9A-Z-]/g,'')">
              @error('ci')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group col-md-4">
              <label>Expedido</label>
              <input type="text"
                     name="ci_expedido"
                     value="{{ old('ci_expedido') }}"
                     class="form-control @error('ci_expedido') is-invalid @enderror"
                     style="text-transform: uppercase;"
                     oninput="this.value=this.value.toUpperCase()">
              @error('ci_expedido')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group col-md-4">
              <label>Celular</label>
              <input type="text"
                     name="celular"
                     maxlength="8"
                     value="{{ old('celular') }}"
                     class="form-control @error('celular') is-invalid @enderror"
                     oninput="this.value = this.value.replace(/[^0-9]/g,''); if(this.value.length > 8) this.value = this.value.slice(0,8)">
              @error('celular')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

          </div>

          <div class="form-row">

            <div class="form-group col-md-6">
              <label>Dirección</label>
              <input type="text"
                     name="direccion"
                     value="{{ old('direccion') }}"
                     class="form-control @error('direccion') is-invalid @enderror"
                     style="text-transform: uppercase;"
                     oninput="this.value=this.value.toUpperCase()">
              @error('direccion')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>


            <div class="form-group col-md-3">
              <label>Matrícula</label>
              <input type="text"
                     name="matricula"
                     value="{{ old('matricula') }}"
                     class="form-control @error('matricula') is-invalid @enderror"
                     style="text-transform: uppercase;"
                     oninput="this.value=this.value.toUpperCase()">
              @error('matricula')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            
            <div class="form-group col-md-3">
              <label>Área</label>
              <select name="area"
                      class="form-control @error('area') is-invalid @enderror">
                <option value="">-- Seleccionar Área --</option>
                <option value="FAMILIAR" {{ old('area') == 'FAMILIAR' ? 'selected' : '' }}>FAMILIAR</option>
                <option value="CIVIL" {{ old('area') == 'CIVIL' ? 'selected' : '' }}>CIVIL</option>
                <option value="PENAL" {{ old('area') == 'PENAL' ? 'selected' : '' }}>PENAL</option>
                <option value="ADMINISTRATIVO" {{ old('area') == 'ADMINISTRATIVO' ? 'selected' : '' }}>ADMINISTRATIVO</option>
                <option value="LABORAL" {{ old('area') == 'LABORAL' ? 'selected' : '' }}>LABORAL</option>
              </select>
              @error('area')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

          </div>

          <div class="form-row">

       
            <div class="form-group col-md-6">
              <label>Correo Electrónico</label>
              <input type="email"
                     name="email"
                     value="{{ old('email') }}"
                     class="form-control @error('email') is-invalid @enderror">
              @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            
            <div class="form-group col-md-6">
              <label>Fecha de Nacimiento</label>
              <input type="date"
                     name="fecha_nacimiento"
                     value="{{ old('fecha_nacimiento') }}"
                     class="form-control @error('fecha_nacimiento') is-invalid @enderror">
              @error('fecha_nacimiento')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
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
@stop
