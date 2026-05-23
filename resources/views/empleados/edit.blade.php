@extends('adminlte::page')

@section('title', 'Editar Empleado')

@section('content_header')
<h1 class="text-dark" style="font-family: Georgia, serif; font-weight: 800;">
    Editar Empleado
</h1>
@stop

@section('content')
<div class="card shadow-lg">
    <div class="card-header bg-info text-white">
        <h5 class="mb-0"><i class="fas fa-user-edit"></i> Editar Datos del Empleado</h5>
    </div>

    <form action="{{ route('empleados.update', $empleado->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="card-body">

            <!-- ================= DATOS PERSONALES ================= -->
            <h6 class="text-info font-weight-bold mb-3">
                <i class="fas fa-id-card"></i> Información Personal
            </h6>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label>Nombres</label>
                    <input type="text" name="nombres"
                           value="{{ old('nombres', $empleado->nombres) }}"
                           class="form-control @error('nombres') is-invalid @enderror"
                           style="text-transform: uppercase;"
                           oninput="this.value=this.value.toUpperCase().replace(/[^A-ZÁÉÍÓÚÑ ]/g,'')"
                           required>
                    @error('nombres') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="form-group col-md-4">
                    <label>Apellido Paterno</label>
                    <input type="text" name="paterno"
                           value="{{ old('paterno', $empleado->paterno) }}"
                           class="form-control @error('paterno') is-invalid @enderror"
                           style="text-transform: uppercase;"
                           oninput="this.value=this.value.toUpperCase().replace(/[^A-ZÁÉÍÓÚÑ ]/g,'')">
                    @error('paterno') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="form-group col-md-4">
                    <label>Apellido Materno</label>
                    <input type="text" name="materno"
                           value="{{ old('materno', $empleado->materno) }}"
                           class="form-control @error('materno') is-invalid @enderror"
                           style="text-transform: uppercase;"
                           oninput="this.value=this.value.toUpperCase().replace(/[^A-ZÁÉÍÓÚÑ ]/g,'')">
                    @error('materno') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label>Cédula de Identidad</label>
                    <input type="text" name="ci"
                           value="{{ old('ci', $empleado->ci) }}"
                           class="form-control @error('ci') is-invalid @enderror"
                           style="text-transform: uppercase;"
                           oninput="this.value=this.value.toUpperCase().replace(/[^0-9A-Z-]/g,'')">
                    @error('ci') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="form-group col-md-4">
                    <label>Expedido</label>
                    <input type="text" name="ci_expedido"
                           value="{{ old('ci_expedido', $empleado->ci_expedido) }}"
                           class="form-control @error('ci_expedido') is-invalid @enderror"
                           style="text-transform: uppercase;"
                           oninput="this.value=this.value.toUpperCase()">
                    @error('ci_expedido') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="form-group col-md-4">
                    <label>Celular</label>
                    <input type="text" name="celular"
                           value="{{ old('celular', $empleado->celular) }}"
                           maxlength="8"
                           class="form-control @error('celular') is-invalid @enderror"
                           oninput="this.value=this.value.replace(/[^0-9]/g,''); if(this.value.length>8) this.value=this.value.slice(0,8)">
                    @error('celular') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <!-- ================= INFORMACIÓN LABORAL ================= -->
            <h6 class="text-info font-weight-bold mt-4 mb-3">
                <i class="fas fa-briefcase"></i> Información Laboral
            </h6>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label>Tipo de Empleado</label>
                    <select name="id_tipo_persona"
                            class="form-control @error('id_tipo_persona') is-invalid @enderror"
                            required>
                        <option value="">-- Seleccione --</option>
                        @foreach($tipos_personas as $tipo)
                            <option value="{{ $tipo->id }}"
                                {{ old('id_tipo_persona', $empleado->id_tipo_persona) == $tipo->id ? 'selected' : '' }}>
                                {{ $tipo->tipo_persona }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_tipo_persona') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="form-group col-md-4">
                    <label>Matrícula</label>
                    <input type="text" name="matricula"
                           value="{{ old('matricula', $empleado->matricula) }}"
                           class="form-control @error('matricula') is-invalid @enderror"
                           style="text-transform: uppercase;"
                           oninput="this.value=this.value.toUpperCase()">
                    @error('matricula') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- NUEVO CAMPO ÁREA -->
                <div class="form-group col-md-4">
                    <label>Área</label>
                    <select name="area"
                            class="form-control @error('area') is-invalid @enderror">
                        <option value="">-- Seleccionar Área --</option>
                        <option value="FAMILIAR" {{ old('area', $empleado->area) == 'FAMILIAR' ? 'selected' : '' }}>FAMILIAR</option>
                        <option value="CIVIL" {{ old('area', $empleado->area) == 'CIVIL' ? 'selected' : '' }}>CIVIL</option>
                        <option value="PENAL" {{ old('area', $empleado->area) == 'PENAL' ? 'selected' : '' }}>PENAL</option>
                        <option value="ADMINISTRATIVO" {{ old('area', $empleado->area) == 'ADMINISTRATIVO' ? 'selected' : '' }}>ADMINISTRATIVO</option>
                        <option value="LABORAL" {{ old('area', $empleado->area) == 'LABORAL' ? 'selected' : '' }}>LABORAL</option>
                    </select>
                    @error('area') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Dirección</label>
                    <input type="text" name="direccion"
                           value="{{ old('direccion', $empleado->direccion) }}"
                           class="form-control @error('direccion') is-invalid @enderror"
                           style="text-transform: uppercase;"
                           oninput="this.value=this.value.toUpperCase()">
                    @error('direccion') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="form-group col-md-6">
                    <label>Correo Electrónico</label>
                    <input type="email" name="email"
                           value="{{ old('email', $empleado->email) }}"
                           class="form-control @error('email') is-invalid @enderror">
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="form-group">
                <label>Fecha de Nacimiento</label>
                <input type="date" name="fecha_nacimiento"
                       value="{{ old('fecha_nacimiento', $empleado->fecha_nacimiento) }}"
                       class="form-control @error('fecha_nacimiento') is-invalid @enderror">
                @error('fecha_nacimiento') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

        </div>

        <div class="card-footer text-right">
            <a href="{{ route('empleados.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
            <button type="submit" class="btn btn-danger">
                <i class="fas fa-save"></i> Actualizar
            </button>
        </div>

    </form>
</div>
@stop