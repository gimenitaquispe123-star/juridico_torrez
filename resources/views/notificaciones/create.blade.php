@extends('adminlte::page')

@section('title', 'Crear Notificación')

@section('content_header')
<div class="d-flex justify-content-center mb-3">
   <h1 class="text-center" style="font-family: Georgia, serif;">Nueva Notificación</h1>

</div>
@endsection

@section('content')
    <div class="card shadow">
        <div class="card-header bg-info text-white">
            <h3 class="card-title mb-0">Formulario de Registro</h3>
        </div>

        <form action="{{ route('notificaciones.store') }}" method="POST">
            @csrf
            <div class="card-body row">

                {{-- Columna izquierda --}}
                <div class="col-md-6">

                    {{-- Título --}}
                    <div class="form-group">
                        <label for="titulo"><i class="fas fa-heading"></i> Título</label>
                        <input type="text" name="titulo" class="form-control"
                            value="{{ old('titulo') }}" required>
                    </div>

                    {{-- Fecha de evento --}}
                    <div class="form-group">
                        <label for="fecha_evento"><i class="fas fa-calendar-alt"></i> Fecha del evento (audiencia, reunión, etc.)</label>
                        <input type="datetime-local" name="fecha_evento" class="form-control"
                            value="{{ old('fecha_evento') }}">
                    </div>

                    {{-- Canal --}}
                    <div class="form-group">
                        <label for="canal"><i class="fas fa-paper-plane"></i> Canal</label>
                        <select name="canal" class="form-control select2" required>
                            <option value="">-- Seleccione --</option>
                            <option value="sistema" {{ old('canal') == 'sistema' ? 'selected' : '' }}>🌐 Sistema</option>
                            <option value="email" {{ old('canal') == 'email' ? 'selected' : '' }}>📩 Email</option>
                            <option value="whatsapp" {{ old('canal') == 'whatsapp' ? 'selected' : '' }}>📱 WhatsApp</option>
                            <option value="ambos" {{ old('canal') == 'ambos' ? 'selected' : '' }}>🔄 Ambos</option>
                        </select>
                    </div>
                </div>

                {{-- Columna derecha --}}
                <div class="col-md-6">

                    {{-- Mensaje --}}
                    <div class="form-group">
                        <label for="mensaje"><i class="fas fa-envelope"></i> Mensaje</label>
                        <textarea name="mensaje" class="form-control" rows="3" required>{{ old('mensaje') }}</textarea>
                    </div>

                    {{-- Usuario destinatario --}}
                    <div class="form-group">
                        <label for="usuario_id"><i class="fas fa-user"></i> Usuario destinatario</label>
                        <select name="usuario_id" class="form-control select2" required>
                            <option value="">-- Seleccione --</option>
                            @foreach ($usuarios as $usuario)
                                <option value="{{ $usuario->id_usuarios }}" {{ old('usuario_id') == $usuario->id_usuarios ? 'selected' : '' }}>
                                    {{ $usuario->nombre_completo ?? $usuario->name }} ({{ $usuario->email ?? 'sin email' }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- URL de redirección --}}
                    <div class="form-group">
                        <label for="url_direccion"><i class="fas fa-link"></i> URL de redirección (opcional)</label>
                        <input type="text" name="url_direccion" class="form-control"
                            value="{{ old('url_direccion') }}" placeholder="https://...">
                    </div>
                </div>
            </div>

            <div class="card-footer d-flex justify-content-center gap-3">
                <a href="{{ route('notificaciones.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times-circle"></i> Cancelar
                </a>
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-save"></i> Guardar
                </button>
            </div>
        </form>
    </div>
@endsection

@section('css')
    {{-- Estilos Select2 --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('js')
    {{-- Activación Select2 --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap4',
                placeholder: 'Seleccione una opción'
            });
        });
    </script>
@endsection
